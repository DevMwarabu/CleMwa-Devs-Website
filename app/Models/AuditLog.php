<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $log) {
            $log->created_at ??= now();
        });

        static::updating(function () {
            throw new \RuntimeException('Audit logs are immutable.');
        });

        static::deleting(function () {
            throw new \RuntimeException('Audit logs are immutable.');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
