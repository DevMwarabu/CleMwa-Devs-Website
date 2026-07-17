<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $guarded = [];

    // This is a singleton model, similar to other settings
    public static function getSettings()
    {
        return self::first() ?? self::create([]);
    }
}
