<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Record a heartbeat from an authenticated agent. Kept as a minimal
     * liveness-only ping (used by the manual "verify connectivity" curl
     * command shown at registration) — the real agent calls metrics()
     * instead, which also updates liveness.
     */
    public function heartbeat(Request $request)
    {
        $validated = $request->validate([
            'agent_version' => 'nullable|string|max:100',
        ]);

        $server = $request->user();
        $server->update([
            'last_heartbeat_at' => now(),
            'agent_version' => $validated['agent_version'] ?? $server->agent_version,
        ]);

        return response()->json(['message' => 'Heartbeat recorded.', 'status' => $server->status]);
    }

    /**
     * Record a full metrics snapshot from the real monitoring agent. Updates
     * the current-state row (overwritten each push) and appends a history
     * row (cpu/memory/disk/network only — processes/services are
     * current-state-only concerns, not worth per-tick history for).
     */
    public function metrics(Request $request)
    {
        $validated = $request->validate([
            'agent_version' => 'nullable|string|max:100',
            'cpu' => 'nullable|array',
            'memory' => 'nullable|array',
            'disk' => 'nullable|array',
            'network' => 'nullable|array',
            'processes' => 'nullable|array',
            'services' => 'nullable|array',
            'docker' => 'nullable|array',
        ]);

        $server = $request->user();
        $collectedAt = now();

        $server->metric()->updateOrCreate(
            ['server_id' => $server->id],
            [
                'cpu' => $validated['cpu'] ?? null,
                'memory' => $validated['memory'] ?? null,
                'disk' => $validated['disk'] ?? null,
                'network' => $validated['network'] ?? null,
                'processes' => $validated['processes'] ?? null,
                'services' => $validated['services'] ?? null,
                'docker' => $validated['docker'] ?? null,
                'collected_at' => $collectedAt,
            ]
        );

        $server->metricHistory()->create([
            'cpu' => $validated['cpu'] ?? null,
            'memory' => $validated['memory'] ?? null,
            'disk' => $validated['disk'] ?? null,
            'network' => $validated['network'] ?? null,
            'collected_at' => $collectedAt,
        ]);

        $server->update([
            'last_heartbeat_at' => $collectedAt,
            'agent_version' => $validated['agent_version'] ?? $server->agent_version,
        ]);

        return response()->json(['message' => 'Metrics recorded.', 'status' => $server->status]);
    }
}
