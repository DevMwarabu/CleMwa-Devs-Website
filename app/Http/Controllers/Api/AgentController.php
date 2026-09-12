<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Record a heartbeat from an authenticated agent. Payload is
     * intentionally minimal for Phase 2 — real metrics ingestion is a
     * later phase; this only proves connectivity and keeps status fresh.
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
}
