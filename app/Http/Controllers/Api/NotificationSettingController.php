<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NotificationSetting;
use App\Support\AuditLogger;
use App\Support\NotificationDispatcher;
use Illuminate\Http\Request;

class NotificationSettingController extends Controller
{
    public function show()
    {
        return response()->json(NotificationSetting::getSettings()->toMasked());
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'smtp_enabled' => 'boolean',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_encryption' => 'nullable|string|in:tls,ssl,none',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string',
            'smtp_from_address' => 'nullable|email|max:255',
            'smtp_from_name' => 'nullable|string|max:255',
            'telegram_enabled' => 'boolean',
            'telegram_bot_token' => 'nullable|string',
            'telegram_chat_id' => 'nullable|string|max:255',
            'alert_email_recipients' => 'nullable|string',
        ]);

        $settings = NotificationSetting::getSettings();
        $before = $settings->toMasked();

        // A blank/omitted secret means "keep the existing value" — never overwrite
        // with an empty string, and never accept the masked placeholder back.
        foreach (['smtp_password', 'telegram_bot_token'] as $secretField) {
            if (empty($validated[$secretField]) || $validated[$secretField] === '••••••••') {
                unset($validated[$secretField]);
            }
        }

        $settings->fill($validated);
        $settings->save();

        AuditLogger::log('settings.updated', 'NotificationSetting', (string) $settings->id, $before, $settings->toMasked());

        return response()->json($settings->toMasked());
    }

    public function testEmail(Request $request)
    {
        $request->validate(['to' => 'nullable|email']);

        $settings = NotificationSetting::getSettings();

        if (! $settings->smtp_enabled || ! $settings->smtp_host) {
            return response()->json(['message' => 'SMTP is not configured.'], 422);
        }

        $to = $request->input('to', $request->user()->email);

        try {
            NotificationDispatcher::sendEmail(
                $settings,
                [$to],
                'Monitoring: Test Email',
                'This is a test email from the CleMwa Devs monitoring platform. If you received this, SMTP is configured correctly.',
            );

            AuditLogger::log('settings.test_email', 'NotificationSetting', (string) $settings->id, [], ['to' => $to]);

            return response()->json(['message' => 'Test email sent successfully.']);
        } catch (\Throwable $e) {
            AuditLogger::log('settings.test_email', 'NotificationSetting', (string) $settings->id, [], ['to' => $to], 'failure');

            return response()->json(['message' => 'Failed to send test email: '.$e->getMessage()], 422);
        }
    }

    public function testTelegram(Request $request)
    {
        $settings = NotificationSetting::getSettings();

        if (! $settings->telegram_enabled || ! $settings->telegram_bot_token || ! $settings->telegram_chat_id) {
            return response()->json(['message' => 'Telegram is not configured.'], 422);
        }

        try {
            NotificationDispatcher::sendTelegram($settings, "\u{2705} Test message from the CleMwa Devs monitoring platform.");

            AuditLogger::log('settings.test_telegram', 'NotificationSetting', (string) $settings->id);

            return response()->json(['message' => 'Test Telegram message sent successfully.']);
        } catch (\Throwable $e) {
            AuditLogger::log('settings.test_telegram', 'NotificationSetting', (string) $settings->id, [], [], 'failure');

            return response()->json(['message' => 'Failed to send Telegram message: '.$e->getMessage()], 422);
        }
    }
}
