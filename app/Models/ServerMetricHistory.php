<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerMetricHistory extends Model
{
    protected $table = 'server_metric_history';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'cpu' => 'array',
        'memory' => 'array',
        'disk' => 'array',
        'network' => 'array',
        'collected_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $row) {
            $row->created_at ??= now();
        });
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
