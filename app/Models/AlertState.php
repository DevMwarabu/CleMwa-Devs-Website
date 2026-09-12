<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertState extends Model
{
    protected $guarded = [];

    protected $casts = [
        'breach_started_at' => 'datetime',
        'fired_at' => 'datetime',
        'resolved_at' => 'datetime',
        'last_notified_at' => 'datetime',
        'last_evaluated_at' => 'datetime',
        'current_value' => 'float',
    ];

    public function rule()
    {
        return $this->belongsTo(AlertRule::class, 'alert_rule_id');
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Whether an active silence or maintenance window currently suppresses
     * notification for this state — the real `state` column is never
     * altered by this; it's a read-time overlay only (see Phase 6 plan:
     * silencing is not a state value).
     */
    public function isSilenced(): bool
    {
        $silenced = AlertSilence::query()
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->where(function ($q) {
                $q->whereNull('alert_rule_id')->orWhere('alert_rule_id', $this->alert_rule_id);
            })
            ->where(function ($q) {
                $q->whereNull('server_id')->orWhere('server_id', $this->server_id);
            })
            ->exists();

        if ($silenced) {
            return true;
        }

        return MaintenanceWindow::query()
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->get()
            ->contains(function (MaintenanceWindow $window) {
                $appliesToServer = empty($window->server_ids) || in_array($this->server_id, $window->server_ids, true);
                if (! $appliesToServer) {
                    return false;
                }

                if (empty($window->service_names)) {
                    return true;
                }

                return in_array($this->rule?->service_name, $window->service_names, true);
            });
    }
}
