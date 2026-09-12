#!/bin/bash
# Install the CleMwa Devs monitoring agent on this host.
#
# Usage (run as root, from inside this agent/ directory):
#   sudo AGENT_TOKEN="..." API_URL="https://clemwadevelopers.com" \
#        CRITICAL_SERVICES="nginx,postgresql" ./install.sh
#
# AGENT_TOKEN and API_URL are shown once when you register the server in
# the admin panel (Servers > Register Server). CRITICAL_SERVICES is optional,
# comma-separated systemd unit names this host should be checked for.

set -euo pipefail

if [ "$(id -u)" -ne 0 ]; then
  echo "Run this as root (sudo)." >&2
  exit 1
fi

if [ -z "${AGENT_TOKEN:-}" ] || [ -z "${API_URL:-}" ]; then
  echo "AGENT_TOKEN and API_URL must be set. See the usage comment at the top of this script." >&2
  exit 1
fi

if ! command -v python3 >/dev/null 2>&1; then
  echo "python3 is required but was not found on this host." >&2
  exit 1
fi

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

echo "==> Installing agent script"
install -m 0755 "$SCRIPT_DIR/monitoring_agent.py" /usr/local/bin/clemwa-monitoring-agent.py

echo "==> Writing config"
mkdir -p /etc/clemwa-monitoring-agent
CRITICAL_SERVICES_JSON="[]"
if [ -n "${CRITICAL_SERVICES:-}" ]; then
  CRITICAL_SERVICES_JSON=$(python3 -c "import json,sys; print(json.dumps([s.strip() for s in sys.argv[1].split(',') if s.strip()]))" "$CRITICAL_SERVICES")
fi
cat > /etc/clemwa-monitoring-agent/config.json <<CONFIG
{
  "api_url": "${API_URL}",
  "token": "${AGENT_TOKEN}",
  "critical_services": ${CRITICAL_SERVICES_JSON}
}
CONFIG
chmod 600 /etc/clemwa-monitoring-agent/config.json

echo "==> Installing systemd units"
install -m 0644 "$SCRIPT_DIR/clemwa-monitoring-agent.service" /etc/systemd/system/clemwa-monitoring-agent.service
install -m 0644 "$SCRIPT_DIR/clemwa-monitoring-agent.timer" /etc/systemd/system/clemwa-monitoring-agent.timer

echo "==> Enabling and starting the timer"
systemctl daemon-reload
systemctl enable --now clemwa-monitoring-agent.timer
systemctl start clemwa-monitoring-agent.service || true

echo
echo "==> Done. Check status with:"
echo "    systemctl status clemwa-monitoring-agent.timer"
echo "    journalctl -u clemwa-monitoring-agent.service -f"
