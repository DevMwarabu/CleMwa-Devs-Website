<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UptimeCheck extends Model
{
    protected $guarded = [];

    protected $casts = [
        'headers' => 'array',
        'enabled' => 'boolean',
        'last_success' => 'boolean',
        'last_checked_at' => 'datetime',
        'ssl_expires_at' => 'datetime',
    ];

    public function results()
    {
        return $this->hasMany(UptimeCheckResult::class);
    }
}
