<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NotificationPolicy;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NotificationPolicyController extends Controller
{
    public function index()
    {
        return response()->json(NotificationPolicy::orderBy('priority')->get());
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $policy = NotificationPolicy::create($validated);

        AuditLogger::log('notification_policy.created', 'NotificationPolicy', (string) $policy->id, [], $policy->toArray());

        return response()->json($policy, 201);
    }

    public function update(Request $request, NotificationPolicy $notificationPolicy)
    {
        $validated = $this->validated($request, $notificationPolicy);
        $before = $notificationPolicy->toArray();

        $notificationPolicy->update($validated);

        AuditLogger::log('notification_policy.updated', 'NotificationPolicy', (string) $notificationPolicy->id, $before, $notificationPolicy->fresh()->toArray());

        return response()->json($notificationPolicy->fresh());
    }

    public function destroy(NotificationPolicy $notificationPolicy)
    {
        $before = $notificationPolicy->toArray();
        $notificationPolicy->delete();

        AuditLogger::log('notification_policy.deleted', 'NotificationPolicy', (string) $before['id'], $before, []);

        return response()->json(null, 204);
    }

    private function validated(Request $request, ?NotificationPolicy $policy = null): array
    {
        return $request->validate([
            'name' => $policy ? 'sometimes|string|max:255' : 'required|string|max:255',
            'priority' => 'nullable|integer|min:0',
            'severity' => ['nullable', Rule::in(['info', 'warning', 'high', 'critical'])],
            'environment' => ['nullable', Rule::in(['production', 'staging', 'development'])],
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
            // 'present' (not 'required') so an explicit empty array — a
            // deliberate "dashboard only" policy — is accepted.
            'channels' => $policy ? 'sometimes|array' : 'present|array',
            'channels.*' => Rule::in(['email', 'telegram']),
            'enabled' => 'nullable|boolean',
        ]);
    }
}
