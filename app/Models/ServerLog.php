<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerLog extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'logged_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $log) {
            $log->created_at ??= now();
        });
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
