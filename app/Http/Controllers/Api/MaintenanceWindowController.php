<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceWindow;
use App\Support\AuditLogger;
use Illuminate\Http\Request;

class MaintenanceWindowController extends Controller
{
    public function index()
    {
        return response()->json(MaintenanceWindow::with('creator')->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['created_by'] = $request->user()->id;

        $window = MaintenanceWindow::create($validated);

        AuditLogger::log('maintenance_window.created', 'MaintenanceWindow', (string) $window->id, [], $window->toArray());

        return response()->json($window, 201);
    }

    public function update(Request $request, MaintenanceWindow $maintenanceWindow)
    {
        $validated = $this->validated($request, $maintenanceWindow);
        $before = $maintenanceWindow->toArray();

        $maintenanceWindow->update($validated);

        AuditLogger::log('maintenance_window.updated', 'MaintenanceWindow', (string) $maintenanceWindow->id, $before, $maintenanceWindow->fresh()->toArray());

        return response()->json($maintenanceWindow->fresh());
    }

    public function destroy(MaintenanceWindow $maintenanceWindow)
    {
        $before = $maintenanceWindow->toArray();
        $maintenanceWindow->delete();

        AuditLogger::log('maintenance_window.deleted', 'MaintenanceWindow', (string) $before['id'], $before, []);

        return response()->json(null, 204);
    }

    private function validated(Request $request, ?MaintenanceWindow $window = null): array
    {
        return $request->validate([
            'name' => $window ? 'sometimes|string|max:255' : 'required|string|max:255',
            'server_ids' => 'nullable|array',
            'server_ids.*' => 'string|exists:servers,id',
            'service_names' => 'nullable|array',
            'service_names.*' => 'string|max:255',
            'starts_at' => $window ? 'sometimes|date' : 'required|date',
            'ends_at' => $window ? 'sometimes|date|after:starts_at' : 'required|date|after:starts_at',
            'reason' => 'nullable|string|max:255',
        ]);
    }
}
