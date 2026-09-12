<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertSilence extends Model
{
    protected $guarded = [];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function rule()
    {
        return $this->belongsTo(AlertRule::class, 'alert_rule_id');
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
