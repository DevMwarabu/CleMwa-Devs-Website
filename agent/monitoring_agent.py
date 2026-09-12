#!/usr/bin/env python3
"""
CleMwa Devs monitoring agent — Phase 3.

Standard-library only (no pip installs required). Collects one point-in-time
snapshot of CPU, memory, disk, network, processes and configured critical
services, then POSTs it to the backend. Designed to be run once per systemd
timer tick (see clemwa-monitoring-agent.timer) rather than looping itself —
systemd owns scheduling, retries and logging.

Each collector is independently try/excepted: a failure reading one metric
group (e.g. permission denied on some /proc file) must never prevent the
rest of the snapshot from being collected and sent.
"""

import json
import os
import subprocess
import sys
import time
import urllib.error
import urllib.request

DEFAULT_CONFIG_PATH = "/etc/clemwa-monitoring-agent/config.json"
AGENT_VERSION = "0.3.0"
CPU_SAMPLE_INTERVAL = 0.2  # seconds between the two /proc/stat samples


def log(message):
    sys.stderr.write("[clemwa-monitoring-agent] %s\n" % message)


def load_config(path):
    with open(path, "r") as f:
        config = json.load(f)
    if not config.get("api_url") or not config.get("token"):
        raise ValueError("config must set api_url and token")
    return config


# ---------------------------------------------------------------------------
# CPU
# ---------------------------------------------------------------------------

def _read_stat_lines():
    lines = {}
    with open("/proc/stat", "r") as f:
        for line in f:
            if line.startswith("cpu"):
                parts = line.split()
                name = parts[0]
                values = [int(v) for v in parts[1:]]
                lines[name] = values
    return lines


def _cpu_percentages(before, after):
    # Fields: user nice system idle iowait irq softirq steal guest guest_nice
    fields = ["user", "nice", "system", "idle", "iowait", "irq", "softirq", "steal", "guest", "guest_nice"]
    deltas = [a - b for a, b in zip(after, before)]
    total = sum(deltas)
    if total <= 0:
        return None
    result = {}
    for name, value in zip(fields, deltas):
        result[name] = round(100.0 * value / total, 2)
    result["usage_percent"] = round(100.0 - result.get("idle", 0), 2)
    return result


def collect_cpu():
    before = _read_stat_lines()
    time.sleep(CPU_SAMPLE_INTERVAL)
    after = _read_stat_lines()

    overall = _cpu_percentages(before["cpu"], after["cpu"]) if "cpu" in before and "cpu" in after else None

    per_core = {}
    for name in before:
        if name == "cpu" or not name.startswith("cpu"):
            continue
        if name in after:
            pct = _cpu_percentages(before[name], after[name])
            if pct:
                per_core[name] = pct

    load = {}
    with open("/proc/loadavg", "r") as f:
        parts = f.read().split()
        load = {"1m": float(parts[0]), "5m": float(parts[1]), "15m": float(parts[2])}

    return {
        "usage_percent": overall.get("usage_percent") if overall else None,
        "breakdown": overall,
        "per_core": per_core,
        "load": load,
        "cores": os.cpu_count(),
    }


# ---------------------------------------------------------------------------
# Memory
# ---------------------------------------------------------------------------

def collect_memory():
    values = {}
    with open("/proc/meminfo", "r") as f:
        for line in f:
            key, _, rest = line.partition(":")
            values[key.strip()] = int(rest.strip().split()[0])  # kB

    total = values.get("MemTotal", 0)
    available = values.get("MemAvailable", 0)
    used = total - available

    return {
        "total_mb": round(total / 1024, 1),
        "used_mb": round(used / 1024, 1),
        "available_mb": round(available / 1024, 1),
        "free_mb": round(values.get("MemFree", 0) / 1024, 1),
        "cached_mb": round(values.get("Cached", 0) / 1024, 1),
        "buffers_mb": round(values.get("Buffers", 0) / 1024, 1),
        "swap_total_mb": round(values.get("SwapTotal", 0) / 1024, 1),
        "swap_free_mb": round(values.get("SwapFree", 0) / 1024, 1),
    }


# ---------------------------------------------------------------------------
# Disk
# ---------------------------------------------------------------------------

_PSEUDO_FS_TYPES = {
    "proc", "sysfs", "tmpfs", "devtmpfs", "devpts", "cgroup", "cgroup2",
    "overlay", "squashfs", "autofs", "mqueue", "debugfs", "tracefs",
    "securityfs", "pstore", "bpf", "configfs", "fusectl", "hugetlbfs",
}


def collect_disk():
    filesystems = []
    with open("/proc/mounts", "r") as f:
        for line in f:
            parts = line.split()
            if len(parts) < 3:
                continue
            device, mount, fstype = parts[0], parts[1], parts[2]
            if fstype in _PSEUDO_FS_TYPES or not device.startswith("/dev/"):
                continue
            try:
                stat = os.statvfs(mount)
            except OSError:
                continue
            size = stat.f_blocks * stat.f_frsize
            free = stat.f_bfree * stat.f_frsize
            available = stat.f_bavail * stat.f_frsize
            used = size - free
            usage_percent = round(100.0 * used / size, 1) if size else 0
            filesystems.append({
                "filesystem": device,
                "mount": mount,
                "size_gb": round(size / (1024 ** 3), 2),
                "used_gb": round(used / (1024 ** 3), 2),
                "available_gb": round(available / (1024 ** 3), 2),
                "usage_percent": usage_percent,
                "status": "critical" if usage_percent >= 95 else "warning" if usage_percent >= 85 else "ok",
            })

    io = _collect_disk_io()

    return {"filesystems": filesystems, "io": io}


def _read_diskstats():
    stats = {}
    with open("/proc/diskstats", "r") as f:
        for line in f:
            parts = line.split()
            if len(parts) < 14:
                continue
            name = parts[2]
            if name[-1:].isdigit() and (name.startswith("loop") or name.startswith("ram")):
                continue
            reads_completed = int(parts[3])
            sectors_read = int(parts[5])
            writes_completed = int(parts[7])
            sectors_written = int(parts[9])
            stats[name] = {
                "reads": reads_completed,
                "read_bytes": sectors_read * 512,
                "writes": writes_completed,
                "write_bytes": sectors_written * 512,
            }
    return stats


def _collect_disk_io():
    before = _read_diskstats()
    time.sleep(CPU_SAMPLE_INTERVAL)
    after = _read_diskstats()

    io = {}
    for name, a in after.items():
        b = before.get(name)
        if not b:
            continue
        elapsed = CPU_SAMPLE_INTERVAL
        io[name] = {
            "read_iops": round((a["reads"] - b["reads"]) / elapsed, 1),
            "write_iops": round((a["writes"] - b["writes"]) / elapsed, 1),
            "read_bytes_per_sec": round((a["read_bytes"] - b["read_bytes"]) / elapsed, 1),
            "write_bytes_per_sec": round((a["write_bytes"] - b["write_bytes"]) / elapsed, 1),
        }
    return io


# ---------------------------------------------------------------------------
# Network
# ---------------------------------------------------------------------------

def _read_net_dev():
    stats = {}
    with open("/proc/net/dev", "r") as f:
        lines = f.readlines()[2:]
    for line in lines:
        iface, _, rest = line.partition(":")
        iface = iface.strip()
        fields = rest.split()
        if len(fields) < 16:
            continue
        stats[iface] = {
            "rx_bytes": int(fields[0]),
            "rx_packets": int(fields[1]),
            "rx_errors": int(fields[2]),
            "rx_dropped": int(fields[3]),
            "tx_bytes": int(fields[8]),
            "tx_packets": int(fields[9]),
            "tx_errors": int(fields[10]),
            "tx_dropped": int(fields[11]),
        }
    return stats


def _operstate(iface):
    try:
        with open("/sys/class/net/%s/operstate" % iface, "r") as f:
            return f.read().strip()
    except OSError:
        return "unknown"


def collect_network():
    before = _read_net_dev()
    time.sleep(CPU_SAMPLE_INTERVAL)
    after = _read_net_dev()

    interfaces = []
    for iface, a in after.items():
        if iface == "lo":
            continue
        b = before.get(iface, a)
        elapsed = CPU_SAMPLE_INTERVAL
        interfaces.append({
            "interface": iface,
            "state": _operstate(iface),
            "rx_bytes_per_sec": round((a["rx_bytes"] - b["rx_bytes"]) / elapsed, 1),
            "tx_bytes_per_sec": round((a["tx_bytes"] - b["tx_bytes"]) / elapsed, 1),
            "rx_errors": a["rx_errors"],
            "tx_errors": a["tx_errors"],
            "rx_dropped": a["rx_dropped"],
            "tx_dropped": a["tx_dropped"],
        })
    return interfaces


# ---------------------------------------------------------------------------
# Processes
# ---------------------------------------------------------------------------

def _read_proc_snapshot():
    snapshot = {}
    hertz = os.sysconf("SC_CLK_TCK")
    for entry in os.listdir("/proc"):
        if not entry.isdigit():
            continue
        pid = int(entry)
        try:
            with open("/proc/%d/stat" % pid, "r") as f:
                stat_line = f.read()
            # comm may contain spaces/parens — split on the last ')'
            comm_end = stat_line.rfind(")")
            name = stat_line[stat_line.find("(") + 1:comm_end]
            rest = stat_line[comm_end + 2:].split()
            state = rest[0]
            utime = int(rest[11])
            stime = int(rest[12])

            rss_kb = 0
            with open("/proc/%d/status" % pid, "r") as f:
                for line in f:
                    if line.startswith("VmRSS:"):
                        rss_kb = int(line.split()[1])
                        break

            snapshot[pid] = {
                "name": name,
                "state": state,
                "ticks": utime + stime,
                "rss_kb": rss_kb,
                "hertz": hertz,
            }
        except (OSError, ValueError, IndexError):
            continue
    return snapshot


def collect_processes():
    before = _read_proc_snapshot()
    time.sleep(CPU_SAMPLE_INTERVAL)
    after = _read_proc_snapshot()

    elapsed = CPU_SAMPLE_INTERVAL
    entries = []
    zombie_count = 0
    for pid, a in after.items():
        if a["state"] == "Z":
            zombie_count += 1
        b = before.get(pid)
        cpu_percent = 0.0
        if b:
            delta_ticks = a["ticks"] - b["ticks"]
            cpu_percent = round(100.0 * (delta_ticks / a["hertz"]) / elapsed, 1)
        entries.append({
            "pid": pid,
            "name": a["name"],
            "state": a["state"],
            "cpu_percent": max(cpu_percent, 0.0),
            "memory_mb": round(a["rss_kb"] / 1024, 1),
        })

    top_cpu = sorted(entries, key=lambda e: e["cpu_percent"], reverse=True)[:10]
    top_memory = sorted(entries, key=lambda e: e["memory_mb"], reverse=True)[:10]

    return {
        "total": len(entries),
        "zombie": zombie_count,
        "top_cpu": top_cpu,
        "top_memory": top_memory,
    }


# ---------------------------------------------------------------------------
# Services
# ---------------------------------------------------------------------------

def _systemctl(args):
    try:
        result = subprocess.run(
            ["systemctl"] + args,
            stdout=subprocess.PIPE, stderr=subprocess.PIPE, timeout=5,
        )
        return result.stdout.decode().strip()
    except (OSError, subprocess.SubprocessError):
        return None


def collect_services(names):
    services = []
    for name in names or []:
        active = _systemctl(["is-active", name])
        enabled = _systemctl(["is-enabled", name])
        services.append({
            "name": name,
            "active": active == "active",
            "status": active or "unknown",
            "enabled": enabled == "enabled",
        })
    return services


# ---------------------------------------------------------------------------
# Docker (Phase 9) — entirely optional. Returns None (not an empty list) when
# the `docker` binary isn't present, so the backend can tell "no Docker here"
# apart from "Docker is here with zero containers" and never fabricate either.
# ---------------------------------------------------------------------------

def _has_docker():
    for path in ("/usr/bin/docker", "/usr/local/bin/docker", "/bin/docker"):
        if os.path.exists(path):
            return True
    return False


def collect_docker():
    if not _has_docker():
        return None

    try:
        result = subprocess.run(
            ["docker", "stats", "--no-stream", "--format",
             "{{.Name}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.MemPerc}}"],
            stdout=subprocess.PIPE, stderr=subprocess.PIPE, timeout=10,
        )
        containers = []
        for line in result.stdout.decode().strip().splitlines():
            parts = line.split("\t")
            if len(parts) != 4:
                continue
            name, cpu_perc, mem_usage, mem_perc = parts
            containers.append({
                "name": name,
                "cpu_percent": _parse_percent(cpu_perc),
                "memory_usage": mem_usage.strip(),
                "memory_percent": _parse_percent(mem_perc),
            })

        status_result = subprocess.run(
            ["docker", "ps", "-a", "--format", "{{.Names}}\t{{.Status}}"],
            stdout=subprocess.PIPE, stderr=subprocess.PIPE, timeout=10,
        )
        statuses = {}
        for line in status_result.stdout.decode().strip().splitlines():
            parts = line.split("\t")
            if len(parts) == 2:
                statuses[parts[0]] = parts[1]

        for c in containers:
            c["status"] = statuses.get(c["name"], "unknown")

        return {"containers": containers, "count": len(containers)}
    except (OSError, subprocess.SubprocessError):
        return None


def _parse_percent(value):
    try:
        return float(value.strip().rstrip("%"))
    except (ValueError, AttributeError):
        return None


# ---------------------------------------------------------------------------
# Logs (Phase 10) — tail of admin-configured file paths plus journalctl for
# admin-configured critical services. Level parsing happens server-side
# (App\Support\LogLevelParser), not here — the agent just ships raw lines.
# ---------------------------------------------------------------------------

LOG_TAIL_LINES = 50


def _tail_file(path, lines):
    try:
        with open(path, "r", errors="replace") as fh:
            return fh.readlines()[-lines:]
    except OSError:
        return []


def collect_logs(log_files, critical_services):
    entries = []

    for path in (log_files or []):
        for line in _tail_file(path, LOG_TAIL_LINES):
            line = line.rstrip("\n")
            if line:
                entries.append({"source": path, "message": line})

    for service in (critical_services or []):
        try:
            result = subprocess.run(
                ["journalctl", "-n", str(LOG_TAIL_LINES), "-u", service, "--no-pager"],
                stdout=subprocess.PIPE, stderr=subprocess.PIPE, timeout=10,
            )
            source = "journalctl:%s" % service
            for line in result.stdout.decode(errors="replace").splitlines():
                if line:
                    entries.append({"source": source, "message": line})
        except (OSError, subprocess.SubprocessError):
            continue

    return entries


# ---------------------------------------------------------------------------
# Payload + transport
# ---------------------------------------------------------------------------

def build_payload(config):
    payload = {"agent_version": AGENT_VERSION}

    for key, collector in (
        ("cpu", collect_cpu),
        ("memory", collect_memory),
        ("disk", collect_disk),
        ("network", collect_network),
        ("processes", collect_processes),
    ):
        try:
            payload[key] = collector()
        except Exception as exc:  # noqa: BLE001 - one bad collector must not drop the rest
            log("failed to collect %s: %s" % (key, exc))

    try:
        payload["services"] = collect_services(config.get("critical_services"))
    except Exception as exc:  # noqa: BLE001
        log("failed to collect services: %s" % exc)

    try:
        docker = collect_docker()
        if docker is not None:
            payload["docker"] = docker
    except Exception as exc:  # noqa: BLE001
        log("failed to collect docker: %s" % exc)

    try:
        logs = collect_logs(config.get("log_files"), config.get("critical_services"))
        if logs:
            payload["logs"] = logs
    except Exception as exc:  # noqa: BLE001
        log("failed to collect logs: %s" % exc)

    return payload


def post_metrics(config, payload):
    url = config["api_url"].rstrip("/") + "/api/agent/metrics"
    body = json.dumps(payload).encode("utf-8")
    request = urllib.request.Request(
        url, data=body, method="POST",
        headers={
            "Content-Type": "application/json",
            "Authorization": "Bearer %s" % config["token"],
        },
    )
    with urllib.request.urlopen(request, timeout=15) as response:
        return response.status, response.read().decode()


def main():
    config_path = sys.argv[1] if len(sys.argv) > 1 else DEFAULT_CONFIG_PATH
    try:
        config = load_config(config_path)
    except Exception as exc:  # noqa: BLE001
        log("failed to load config from %s: %s" % (config_path, exc))
        return 1

    payload = build_payload(config)

    try:
        status, body = post_metrics(config, payload)
        log("push ok (%s): %s" % (status, body))
        return 0
    except urllib.error.HTTPError as exc:
        log("push failed: HTTP %s %s" % (exc.code, exc.read().decode(errors="replace")))
        return 1
    except Exception as exc:  # noqa: BLE001
        log("push failed: %s" % exc)
        return 1


if __name__ == "__main__":
    sys.exit(main())
