<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlertRule;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlertRuleController extends Controller
{
    public function index()
    {
        return response()->json(AlertRule::with('server')->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $rule = AlertRule::create($validated);

        AuditLogger::log('alert_rule.created', 'AlertRule', (string) $rule->id, [], $rule->toArray());

        return response()->json($rule, 201);
    }

    public function show(AlertRule $alertRule)
    {
        return response()->json($alertRule->load('server'));
    }

    public function update(Request $request, AlertRule $alertRule)
    {
        $validated = $this->validated($request, $alertRule);
        $before = $alertRule->toArray();

        $alertRule->update($validated);

        AuditLogger::log('alert_rule.updated', 'AlertRule', (string) $alertRule->id, $before, $alertRule->fresh()->toArray());

        return response()->json($alertRule->fresh());
    }

    public function destroy(AlertRule $alertRule)
    {
        $before = $alertRule->toArray();
        $alertRule->delete();

        AuditLogger::log('alert_rule.deleted', 'AlertRule', (string) $before['id'], $before, []);

        return response()->json(null, 204);
    }

    private function validated(Request $request, ?AlertRule $rule = null): array
    {
        $metrics = ['cpu_percent', 'memory_percent', 'disk_percent', 'server_offline', 'service_down'];

        $validated = $request->validate([
            'name' => $rule ? 'sometimes|string|max:255' : 'required|string|max:255',
            'description' => 'nullable|string',
            'metric' => [$rule ? 'sometimes' : 'required', Rule::in($metrics)],
            'server_id' => 'nullable|exists:servers,id',
            'service_name' => 'nullable|string|max:255|required_if:metric,service_down',
            'condition' => ['nullable', Rule::in(['>', '<', '>=', '<='])],
            'threshold' => 'nullable|numeric',
            'for_duration_seconds' => 'nullable|integer|min:0',
            'severity' => ['nullable', Rule::in(['info', 'warning', 'high', 'critical'])],
            'enabled' => 'nullable|boolean',
            'labels' => 'nullable|array',
        ]);

        $metric = $validated['metric'] ?? $rule?->metric;
        if (in_array($metric, ['cpu_percent', 'memory_percent', 'disk_percent'], true)) {
            $request->validate([
                'condition' => 'required',
                'threshold' => 'required|numeric',
            ]);
        }

        return $validated;
    }
}
