<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationDelivery extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'alert_event_ids' => 'array',
        'attempted_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
