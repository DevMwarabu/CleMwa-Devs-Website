<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertEvent extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'value_at_transition' => 'float',
        'occurred_at' => 'datetime',
    ];

    public function rule()
    {
        return $this->belongsTo(AlertRule::class, 'alert_rule_id');
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
