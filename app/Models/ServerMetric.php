<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerMetric extends Model
{
    protected $guarded = [];

    protected $casts = [
        'cpu' => 'array',
        'memory' => 'array',
        'disk' => 'array',
        'network' => 'array',
        'processes' => 'array',
        'services' => 'array',
        'collected_at' => 'datetime',
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
