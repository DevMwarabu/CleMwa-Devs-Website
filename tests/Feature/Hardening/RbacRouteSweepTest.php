<?php

namespace Tests\Feature\Hardening;

use App\Models\AlertRule;
use App\Models\Incident;
use App\Models\Server;
use App\Models\UptimeCheck;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * A single sweep of every monitoring-platform route that carries a
 * `permission:` middleware, run against every one of the 7 seeded roles —
 * the most direct way to catch a route that's missing its gate, or a role
 * matrix that drifted from what routes/api.php actually enforces.
 *
 * Scope: read-only (GET) routes, plus two mutating actions that are safe to
 * run repeatedly without destroying shared fixtures (incidents.manage via
 * PUT, alerts.silence via POST — both additive/idempotent). Destructive
 * DELETE routes (servers.delete, alerts.delete, uptime-check delete) are
 * intentionally excluded here — running them for a permitted role would
 * remove the fixture other roles in this same sweep depend on — and were
 * instead verified by direct inspection of routes/api.php (every one
 * carries an explicit permission:* middleware; see Phase 13 audit notes).
 */
class RbacRouteSweepTest extends TestCase
{
    use RefreshDatabase;

    // Mirrors database/seeders/RolePermissionSeeder::ROLE_MATRIX. Kept
    // hardcoded (not read from the seeder) so this test fails loudly if the
    // two ever drift apart, rather than silently testing against itself.
    private const ROLE_PERMISSIONS = [
        'Super Admin' => '*',
        'Administrator' => '*',
        'Monitoring Engineer' => [
            'servers.view', 'servers.create', 'servers.edit', 'servers.delete', 'metrics.view',
            'dashboards.view', 'dashboards.create', 'dashboards.edit', 'dashboards.delete',
            'alerts.view', 'alerts.create', 'alerts.edit', 'alerts.delete', 'alerts.silence',
            'incidents.view', 'incidents.manage', 'notifications.view',
            'logs.view', 'logs.export', 'reports.view', 'reports.generate',
        ],
        'Operator' => [
            'servers.view', 'metrics.view', 'dashboards.view', 'alerts.view', 'alerts.silence',
            'incidents.view', 'incidents.manage', 'notifications.view', 'logs.view', 'reports.view',
        ],
        'Viewer' => [
            'servers.view', 'metrics.view', 'dashboards.view', 'alerts.view',
            'incidents.view', 'notifications.view', 'logs.view', 'reports.view',
        ],
        'admin' => '*',
        'editor' => [
            'servers.view', 'metrics.view', 'dashboards.view', 'alerts.view',
            'incidents.view', 'notifications.view', 'logs.view', 'reports.view',
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function roleHas(string $role, string $permission): bool
    {
        $granted = self::ROLE_PERMISSIONS[$role];

        return $granted === '*' || in_array($permission, $granted, true);
    }

    /**
     * @return array{0: Server, 1: AlertRule, 2: Incident, 3: UptimeCheck}
     */
    private function fixtures(): array
    {
        $server = Server::create(['name' => 'rbac-sweep-server']);
        $rule = AlertRule::create(['name' => 'rbac rule', 'metric' => 'cpu_percent', 'server_id' => $server->id, 'condition' => '>', 'threshold' => 90, 'severity' => 'warning']);
        $incident = Incident::create(['title' => 'rbac incident', 'severity' => 'critical', 'server_id' => $server->id, 'status' => 'open', 'started_at' => now()]);
        $check = UptimeCheck::create(['name' => 'rbac check', 'url' => 'https://example.com']);

        return [$server, $rule, $incident, $check];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: array}> [method, uri, permission, jsonBody]
     */
    private function routes(Server $server, AlertRule $rule, Incident $incident, UptimeCheck $check): array
    {
        return [
            ['GET', '/api/servers', 'servers.view', []],
            ['GET', "/api/servers/{$server->id}", 'servers.view', []],
            ['GET', '/api/servers/compare/history', 'servers.view', []],
            ['GET', "/api/servers/{$server->id}/metrics/history", 'servers.view', []],
            ['GET', '/api/monitoring/overview', 'servers.view', []],
            ['GET', '/api/monitoring/overview/history', 'servers.view', []],
            ['GET', '/api/monitoring/overview/top', 'servers.view', []],
            ['GET', '/api/uptime-checks', 'servers.view', []],
            ['GET', "/api/uptime-checks/{$check->id}", 'servers.view', []],
            ['GET', '/api/database-health', 'servers.view', []],
            ['GET', '/api/alerts', 'alerts.view', []],
            ['GET', '/api/alert-rules', 'alerts.view', []],
            ['GET', "/api/alert-rules/{$rule->id}", 'alerts.view', []],
            ['GET', '/api/alert-events', 'alerts.view', []],
            ['GET', '/api/alert-silences', 'alerts.view', []],
            ['GET', '/api/maintenance-windows', 'alerts.view', []],
            ['GET', '/api/notification-policies', 'alerts.view', []],
            ['GET', '/api/notification-deliveries', 'alerts.view', []],
            ['GET', '/api/incidents', 'incidents.view', []],
            ['GET', "/api/incidents/{$incident->id}", 'incidents.view', []],
            ['PUT', "/api/incidents/{$incident->id}", 'incidents.manage', ['status' => 'open']],
            ['GET', "/api/servers/{$server->id}/logs", 'logs.view', []],
            ['GET', "/api/servers/{$server->id}/logs/export", 'logs.export', []],
            ['GET', '/api/reports/summary', 'reports.view', []],
            ['GET', '/api/report-schedule', 'reports.view', []],
            ['GET', '/api/reports/export', 'reports.generate', []],
            ['GET', '/api/audit-logs', 'audit.view', []],
            ['GET', '/api/monitoring-settings', 'settings.manage', []],
        ];
    }

    public function test_every_permission_gated_route_matches_each_roles_permission_set(): void
    {
        [$server, $rule, $incident, $check] = $this->fixtures();
        $routes = $this->routes($server, $rule, $incident, $check);

        $failures = [];

        foreach (array_keys(self::ROLE_PERMISSIONS) as $role) {
            $user = User::factory()->create();
            $user->assignRole($role);

            foreach ($routes as [$method, $uri, $permission, $body]) {
                $response = $this->actingAs($user)->json($method, $uri, $body);
                $shouldBeAllowed = $this->roleHas($role, $permission);
                $statusCode = $response->getStatusCode();
                $wasForbidden = $statusCode === 403;

                if ($shouldBeAllowed === $wasForbidden) {
                    $failures[] = sprintf(
                        '%s %s (permission: %s) as %s: expected %s, got status %d',
                        $method, $uri, $permission, $role,
                        $shouldBeAllowed ? 'access' : '403',
                        $statusCode
                    );
                }
            }
        }

        $this->assertEmpty($failures, implode("\n", $failures));
    }
}
