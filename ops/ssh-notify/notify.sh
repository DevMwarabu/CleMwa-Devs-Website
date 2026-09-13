#!/bin/bash
# PAM exec hook: sends a Telegram message on every SSH session open/close on
# this host. Server-wide — fires for SSH into this box regardless of which
# app (this Laravel app, magdapos, etc.) someone's here to work on, since
# SSH access to the box is a single shared surface. Login/logout only, no
# command/session recording — see install.sh's usage comment for scope.
#
# Invoked by pam_exec.so via /etc/pam.d/sshd, which sets these env vars:
#   PAM_TYPE  = open_session | close_session
#   PAM_USER  = the local unix user that authenticated
#   PAM_RHOST = the remote IP the SSH connection came from
set -euo pipefail

CONFIG_FILE="/etc/clemwa-ssh-notify.conf"
[ -f "$CONFIG_FILE" ] || exit 0
# shellcheck source=/dev/null
. "$CONFIG_FILE"
[ -n "${BOT_TOKEN:-}" ] && [ -n "${CHAT_ID:-}" ] || exit 0

HOST="$(hostname)"
USER_NAME="${PAM_USER:-unknown}"
REMOTE_HOST="${PAM_RHOST:-unknown}"

case "${PAM_TYPE:-}" in
  open_session)
    TEXT="🔑 SSH login to ${HOST}: user '${USER_NAME}' from ${REMOTE_HOST}"
    ;;
  close_session)
    TEXT="🚪 SSH logout from ${HOST}: user '${USER_NAME}' (was connected from ${REMOTE_HOST})"
    ;;
  *)
    exit 0
    ;;
esac

# Best-effort, non-blocking: a Telegram/network hiccup must never delay or
# block an actual SSH login. Backgrounded and errors discarded.
(curl -s -m 5 -X POST "https://api.telegram.org/bot${BOT_TOKEN}/sendMessage" \
  --data-urlencode "chat_id=${CHAT_ID}" \
  --data-urlencode "text=${TEXT}" \
  >/dev/null 2>&1 || true) &

exit 0
