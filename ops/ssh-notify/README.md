# SSH Login/Logout Telegram Notifier

Sends a Telegram message whenever anyone opens or closes an SSH session on
this host. Server-wide — not scoped to any one app running here (this
Laravel app, magdapos, or anything else on the box), since SSH access to
the machine is a single shared surface regardless of which app someone's
here to work on.

Scope, deliberately: login/logout only — which user, from what IP, when.
Not full command/session recording. That's a separate, heavier feature
(session auditing) with a lot more moving parts; this is intentionally
lightweight.

## Install

As root, from this directory:

```
sudo BOT_TOKEN="<telegram bot token>" CHAT_ID="<telegram chat/group id>" ./install.sh
```

Reuse the same bot token + chat ID already configured in the admin panel's
Notification Settings if you want SSH notices in the same place as
monitoring alerts, or use a different bot/chat to split them.

This installs:
- `/usr/local/bin/clemwa-ssh-notify.sh` — the notify script
- `/etc/clemwa-ssh-notify.conf` (mode 600) — holds the bot token/chat id
- One `session optional pam_exec.so ...` line appended to `/etc/pam.d/sshd`

No sshd restart is needed — PAM is read fresh on every login attempt, not
cached by a running daemon.

## Verify

Open a new SSH session to this host from another terminal and confirm a
Telegram message arrives, then log out and confirm the logout message too.

## Remove

Delete the `pam_exec.so` line from `/etc/pam.d/sshd`, then:

```
rm /usr/local/bin/clemwa-ssh-notify.sh /etc/clemwa-ssh-notify.conf
```
