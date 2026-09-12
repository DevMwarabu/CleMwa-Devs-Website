<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UptimeCheck;
use App\Support\AuditLogger;
use Illuminate\Http\Request;

class UptimeCheckController extends Controller
{
    public function index()
    {
        return response()->json(UptimeCheck::latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $check = UptimeCheck::create($validated);

        AuditLogger::log('uptime_check.created', 'UptimeCheck', (string) $check->id, [], $check->toArray());

        return response()->json($check, 201);
    }

    public function show(UptimeCheck $uptimeCheck)
    {
        return response()->json($uptimeCheck);
    }

    public function update(Request $request, UptimeCheck $uptimeCheck)
    {
        $validated = $this->validated($request, $uptimeCheck);
        $before = $uptimeCheck->toArray();

        $uptimeCheck->update($validated);

        AuditLogger::log('uptime_check.updated', 'UptimeCheck', (string) $uptimeCheck->id, $before, $uptimeCheck->fresh()->toArray());

        return response()->json($uptimeCheck->fresh());
    }

    public function destroy(UptimeCheck $uptimeCheck)
    {
        $before = $uptimeCheck->toArray();
        $uptimeCheck->delete();

        AuditLogger::log('uptime_check.deleted', 'UptimeCheck', (string) $before['id'], $before, []);

        return response()->json(null, 204);
    }

    public function history(UptimeCheck $uptimeCheck)
    {
        $results = $uptimeCheck->results()->latest('checked_at')->limit(200)->get()->reverse()->values();

        return response()->json($results);
    }

    private function validated(Request $request, ?UptimeCheck $check = null): array
    {
        return $request->validate([
            'name' => $check ? 'sometimes|string|max:255' : 'required|string|max:255',
            'url' => $check ? 'sometimes|url|max:2048' : 'required|url|max:2048',
            'method' => 'nullable|string|in:GET,POST,PUT,PATCH,DELETE',
            'headers' => 'nullable|array',
            'body' => 'nullable|string',
            'expected_status' => 'nullable|integer|min:100|max:599',
            'expected_body_contains' => 'nullable|string|max:255',
            'check_interval_seconds' => 'nullable|integer|min:30',
            'enabled' => 'nullable|boolean',
        ]);
    }
}
