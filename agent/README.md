# CleMwa Devs Monitoring Agent

Lightweight, stdlib-only Python 3 script that collects CPU, memory, disk,
network, process and (configured) service status from a Linux host and
pushes it to the monitoring API. No pip installs required.

## Install

1. Register the server in the admin panel (**Servers → Register Server**).
   You'll get a one-time agent token.
2. Copy this `agent/` directory to the target host, e.g.:
   ```
   scp -r agent/ user@target-host:/tmp/clemwa-agent
   ```
3. On the target host, as root:
   ```
   cd /tmp/clemwa-agent
   sudo AGENT_TOKEN="<token from step 1>" \
        API_URL="https://clemwadevelopers.com" \
        CRITICAL_SERVICES="nginx,postgresql" \
        LOG_FILES="/var/log/nginx/error.log,/var/log/syslog" \
        ./install.sh
   ```
   `CRITICAL_SERVICES` is optional — a comma-separated list of systemd unit
   names this host should be checked for (also tailed via `journalctl` for
   log collection). `LOG_FILES` is optional — a comma-separated list of
   absolute log file paths this host should tail.

This installs the script to `/usr/local/bin/clemwa-monitoring-agent.py`,
writes `/etc/clemwa-monitoring-agent/config.json`, and enables a systemd
timer that runs it every 30 seconds.

## Verify

```
systemctl status clemwa-monitoring-agent.timer
journalctl -u clemwa-monitoring-agent.service -f
```

The server's page in the admin panel should show status `online` and real
CPU/memory/disk/network/process numbers within about a minute.

## Rotate the token

If a token is rotated from the admin panel, update
`/etc/clemwa-monitoring-agent/config.json`'s `token` field on the host and
restart is not required — the next timer tick picks it up automatically.

## Uninstall

```
sudo systemctl disable --now clemwa-monitoring-agent.timer
sudo rm /etc/systemd/system/clemwa-monitoring-agent.{service,timer}
sudo systemctl daemon-reload
sudo rm -rf /etc/clemwa-monitoring-agent /usr/local/bin/clemwa-monitoring-agent.py
```

## Why one-shot + systemd timer, not a daemon loop

Systemd already owns scheduling, retries, restart-on-boot and log capture
(via the journal) — reimplementing that in a Python `while True: sleep()`
loop would just duplicate what the OS already does reliably. A failed push
is simply retried on the next tick; each snapshot is a point-in-time
reading, not a sequential event that would need a local queue to avoid
loss.
