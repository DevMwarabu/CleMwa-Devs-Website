<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportSchedule extends Model
{
    protected $guarded = [];

    protected $casts = [
        'enabled' => 'boolean',
        'last_sent_at' => 'datetime',
    ];

    // Singleton model, same pattern as MonitoringSetting.
    public static function getSettings()
    {
        return self::first() ?? self::create(['enabled' => false, 'frequency' => 'weekly']);
    }
}
