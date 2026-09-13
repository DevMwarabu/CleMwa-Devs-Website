#!/bin/bash
# Install a Telegram SSH login/logout notifier on this host, via a PAM
# exec hook on sshd. Server-wide: fires for any SSH session to this box,
# not scoped to any one app running here.
#
# Scope, deliberately: login/logout only (who, from where, when) — not
# full command/session recording. That's a meaningfully heavier feature
# (session auditing) with more moving parts; add it separately if needed.
#
# Usage (run as root):
#   sudo BOT_TOKEN="123:abc" CHAT_ID="-100123456789" ./install.sh
#
# BOT_TOKEN/CHAT_ID are the same Telegram bot + chat already configured in
# the admin panel's Notification Settings — reuse them so alerts and SSH
# notices land in the same place, or point this at a different chat if
# you'd rather split them.

set -euo pipefail

if [ "$(id -u)" -ne 0 ]; then
  echo "Run this as root (sudo)." >&2
  exit 1
fi

if [ -z "${BOT_TOKEN:-}" ] || [ -z "${CHAT_ID:-}" ]; then
  echo "BOT_TOKEN and CHAT_ID must be set. See the usage comment at the top of this script." >&2
  exit 1
fi

if ! command -v curl >/dev/null 2>&1; then
  echo "curl is required but was not found on this host." >&2
  exit 1
fi

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

echo "==> Installing notify script"
install -m 0755 "$SCRIPT_DIR/notify.sh" /usr/local/bin/clemwa-ssh-notify.sh

echo "==> Writing config"
cat > /etc/clemwa-ssh-notify.conf <<CONFIG
BOT_TOKEN="${BOT_TOKEN}"
CHAT_ID="${CHAT_ID}"
CONFIG
chmod 600 /etc/clemwa-ssh-notify.conf

echo "==> Hooking into sshd's PAM stack"
PAM_LINE="session optional pam_exec.so seteuid /usr/local/bin/clemwa-ssh-notify.sh"
if grep -qF "clemwa-ssh-notify.sh" /etc/pam.d/sshd 2>/dev/null; then
  echo "    Already hooked in /etc/pam.d/sshd — leaving it as-is."
else
  echo "$PAM_LINE" >> /etc/pam.d/sshd
  echo "    Added to /etc/pam.d/sshd."
fi

echo
echo "==> Done. No sshd restart needed — PAM is read per-login, not cached."
echo "    Test it: open a new SSH session to this host from another terminal"
echo "    and confirm a Telegram message arrives, then log out and confirm"
echo "    the logout message too."
echo
echo "    To remove later: delete the pam_exec.so line from /etc/pam.d/sshd,"
echo "    then rm /usr/local/bin/clemwa-ssh-notify.sh /etc/clemwa-ssh-notify.conf"
