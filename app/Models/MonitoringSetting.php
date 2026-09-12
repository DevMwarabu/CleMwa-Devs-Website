<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringSetting extends Model
{
    protected $guarded = [];

    // This is a singleton model, similar to other settings. The default is
    // set explicitly here (matching the migration's column default) because
    // Eloquent doesn't re-read DB-applied column defaults back into the
    // model instance after create() — relying on create([]) alone would
    // leave this attribute null in memory despite the DB row being correct.
    public static function getSettings()
    {
        return self::first() ?? self::create(['raw_metrics_retention_days' => 30]);
    }
}
