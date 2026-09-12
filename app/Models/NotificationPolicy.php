<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationPolicy extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tags' => 'array',
        'channels' => 'array',
        'enabled' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * Whether this policy matches the given alert rule severity and server.
     * Null fields are wildcards; tags match on any overlap.
     */
    public function matches(string $severity, ?Server $server): bool
    {
        if ($this->severity !== null && $this->severity !== $severity) {
            return false;
        }

        if ($this->environment !== null && $this->environment !== $server?->environment) {
            return false;
        }

        if (! empty($this->tags)) {
            $serverTags = $server?->tags ?? [];
            if (empty(array_intersect($this->tags, $serverTags))) {
                return false;
            }
        }

        return true;
    }

    /**
     * First enabled policy (by priority ascending) that matches, or null if
     * none does — the safe default is "no notification", not "notify anyway".
     */
    public static function resolveFor(string $severity, ?Server $server): ?self
    {
        return self::where('enabled', true)
            ->orderBy('priority')
            ->get()
            ->first(fn (self $policy) => $policy->matches($severity, $server));
    }
}
