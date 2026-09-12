<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IncidentController extends Controller
{
    /**
     * Incidents are auto-created from critical alerts (see
     * EvaluateAlertRules::syncIncident()) — no manual store/destroy here.
     */
    public function index(Request $request)
    {
        $query = Incident::with(['server', 'rule', 'assignee']);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        return response()->json($query->latest('started_at')->get());
    }

    public function show(Incident $incident)
    {
        return response()->json($incident->load(['server', 'rule', 'assignee', 'notes.user', 'alertEvents']));
    }

    public function update(Request $request, Incident $incident)
    {
        $validated = $request->validate([
            'status' => ['sometimes', Rule::in(['open', 'acknowledged', 'investigating', 'resolved'])],
            'assigned_to' => 'sometimes|nullable|exists:users,id',
        ]);

        $before = $incident->toArray();

        if (($validated['status'] ?? null) === 'resolved' && ! $incident->resolved_at) {
            $validated['resolved_at'] = now();
        }

        $incident->update($validated);

        AuditLogger::log('incident.updated', 'Incident', (string) $incident->id, $before, $incident->fresh()->toArray());

        return response()->json($incident->fresh(['server', 'rule', 'assignee']));
    }

    public function addNote(Request $request, Incident $incident)
    {
        $validated = $request->validate(['body' => 'required|string']);

        $note = $incident->notes()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        AuditLogger::log('incident.note_added', 'Incident', (string) $incident->id, [], ['note_id' => $note->id]);

        return response()->json($note->load('user'), 201);
    }
}
