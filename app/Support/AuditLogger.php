<?php

namespace App\Support;

use App\Models\AuditLog;

class AuditLogger
{
    public static function log(
        string $action,
        string $resource,
        ?string $resourceId = null,
        array $before = [],
        array $after = [],
        string $result = 'success',
    ): void {
        $request = request();
        $user = $request->user();

        AuditLog::create([
            'user_id' => $user?->id,
            'user_email' => $user?->email,
            'action' => $action,
            'resource' => $resource,
            'resource_id' => $resourceId,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
            'before' => $before ?: null,
            'after' => $after ?: null,
            'result' => $result,
        ]);
    }
}
