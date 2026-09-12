<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UptimeCheckResult extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'success' => 'boolean',
        'ssl_expires_at' => 'datetime',
        'checked_at' => 'datetime',
    ];

    public function uptimeCheck()
    {
        return $this->belongsTo(UptimeCheck::class);
    }
}
