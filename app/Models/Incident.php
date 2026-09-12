<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function rule()
    {
        return $this->belongsTo(AlertRule::class, 'alert_rule_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function notes()
    {
        return $this->hasMany(IncidentNote::class)->orderBy('created_at');
    }

    public function alertEvents()
    {
        return $this->belongsToMany(AlertEvent::class, 'incident_alerts');
    }

    /**
     * Duration in seconds — for a resolved incident, time-to-resolution
     * (feeds MTTR); for an open one, how long it's been open so far.
     */
    public function getDurationSecondsAttribute(): int
    {
        return abs($this->started_at->diffInSeconds($this->resolved_at ?? now()));
    }
}
