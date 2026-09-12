<?php

namespace App\Support;

use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

/**
 * The one place that actually talks to SMTP/Telegram — shared by the
 * Phase 1 "send test" buttons and Phase 7's real alert notifications, so
 * there's only one implementation of the dynamic-transport/API-call logic
 * to get right. Both callers catch \Throwable themselves; this class
 * doesn't swallow failures, it just centralizes how a send is attempted.
 */
class NotificationDispatcher
{
    /**
     * @param  string[]  $to
     */
    public static function sendEmail(NotificationSetting $settings, array $to, string $subject, string $textBody, ?string $htmlBody = null): void
    {
        config(['mail.mailers.monitoring_smtp' => [
            'transport' => 'smtp',
            'host' => $settings->smtp_host,
            'port' => $settings->smtp_port ?? 587,
            'encryption' => $settings->smtp_encryption === 'none' ? null : $settings->smtp_encryption,
            'username' => $settings->smtp_username,
            'password' => $settings->smtp_password,
        ]]);

        $from = $settings->smtp_from_address ?? $settings->smtp_username;
        $fromName = $settings->smtp_from_name ?? 'Monitoring';

        $callback = function ($message) use ($to, $subject, $from, $fromName) {
            $message->to($to)->subject($subject)->from($from, $fromName);
        };

        // html() always sets a plain-text alternative from the same string when
        // no html body is supplied, which is fine — the content is the same
        // either way, just not HTML-formatted.
        $mailer = Mail::mailer('monitoring_smtp');
        $htmlBody ? $mailer->html($htmlBody, $callback) : $mailer->raw($textBody, $callback);
    }

    public static function sendTelegram(NotificationSetting $settings, string $text): void
    {
        $response = Http::post("https://api.telegram.org/bot{$settings->telegram_bot_token}/sendMessage", [
            'chat_id' => $settings->telegram_chat_id,
            'text' => $text,
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException($response->json('description') ?? 'Telegram API error.');
        }
    }
}
