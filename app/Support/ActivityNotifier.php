<?php

namespace App\Support;

use App\Models\NotificationSetting;

/**
 * Best-effort Telegram notifications for real admin activity (logins,
 * logouts, content created, files uploaded) — distinct from
 * NotificationPolicy/NotificationDispatcher's alert-severity routing, which
 * is for monitoring alerts, not admin actions. Never throws: a notification
 * failure must never break the request that triggered it.
 */
class ActivityNotifier
{
    public static function notify(string $message): void
    {
        $settings = NotificationSetting::getSettings();

        if (! $settings->telegram_enabled || ! $settings->telegram_bot_token || ! $settings->telegram_chat_id) {
            return;
        }

        try {
            NotificationDispatcher::sendTelegram($settings, $message);
        } catch (\Throwable $e) {
            // Best-effort — logging config problems here would just be noise
            // on every request; settings.test_telegram is the diagnostic path.
        }
    }
}
