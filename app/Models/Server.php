<?php

namespace App\Models;

use App\Support\HealthScoreCalculator;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Server extends Model
{
    use HasApiTokens, HasUuids;

    protected $guarded = [];

    protected $appends = ['status', 'health_score'];

    protected $casts = [
        'tags' => 'array',
        'critical_services' => 'array',
        'log_files' => 'array',
        'last_heartbeat_at' => 'datetime',
    ];

    public function metric()
    {
        return $this->hasOne(ServerMetric::class);
    }

    public function metricHistory()
    {
        return $this->hasMany(ServerMetricHistory::class);
    }

    public function logs()
    {
        return $this->hasMany(ServerLog::class);
    }

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

    public function getHealthScoreAttribute(): array
    {
        return HealthScoreCalculator::calculate($this);
    }
}
