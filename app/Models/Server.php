<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Server extends Model
{
    use HasApiTokens, HasUuids;

    protected $guarded = [];

    protected $appends = ['status'];

    protected $casts = [
        'tags' => 'array',
        'last_heartbeat_at' => 'datetime',
    ];

    /**
     * Servers with no heartbeat yet are `unknown`. `warning`/`critical` are
     * not computed here — they depend on resource metrics and the health
     * score, both later phases. This only distinguishes online/offline/unknown.
     */
    public function getStatusAttribute(): string
    {
        if (! $this->last_heartbeat_at) {
            return 'unknown';
        }

        return $this->last_heartbeat_at->gt(now()->subSeconds(90)) ? 'online' : 'offline';
    }
}
