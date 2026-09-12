<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertRule extends Model
{
    protected $guarded = [];

    protected $casts = [
        'enabled' => 'boolean',
        'labels' => 'array',
        'threshold' => 'float',
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function states()
    {
        return $this->hasMany(AlertState::class);
    }
}
