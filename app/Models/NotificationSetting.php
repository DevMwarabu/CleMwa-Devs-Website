<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'smtp_enabled' => 'boolean',
        'telegram_enabled' => 'boolean',
        'smtp_password' => 'encrypted',
        'telegram_bot_token' => 'encrypted',
    ];

    // This is a singleton model, similar to other settings
    public static function getSettings()
    {
        return self::first() ?? self::create([]);
    }

    public function toMasked(): array
    {
        $data = $this->toArray();
        $data['smtp_password'] = $this->smtp_password ? '••••••••' : null;
        $data['telegram_bot_token'] = $this->telegram_bot_token ? '••••••••' : null;
        $data['smtp_password_set'] = (bool) $this->smtp_password;
        $data['telegram_bot_token_set'] = (bool) $this->telegram_bot_token;

        return $data;
    }
}
