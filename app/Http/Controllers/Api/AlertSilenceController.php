<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlertSilence;
use App\Support\AuditLogger;
use Illuminate\Http\Request;

class AlertSilenceController extends Controller
{
    public function index()
    {
        return response()->json(AlertSilence::with(['rule', 'server', 'creator'])->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alert_rule_id' => 'nullable|exists:alert_rules,id',
            'server_id' => 'nullable|exists:servers,id',
            'reason' => 'required|string|max:255',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
        ]);

        $validated['created_by'] = $request->user()->id;
        $silence = AlertSilence::create($validated);

        AuditLogger::log('alert_silence.created', 'AlertSilence', (string) $silence->id, [], $silence->toArray());

        return response()->json($silence->load(['rule', 'server']), 201);
    }

    public function destroy(AlertSilence $alertSilence)
    {
        $before = $alertSilence->toArray();
        $alertSilence->delete();

        AuditLogger::log('alert_silence.deleted', 'AlertSilence', (string) $before['id'], $before, []);

        return response()->json(null, 204);
    }
}
