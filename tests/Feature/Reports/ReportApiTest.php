<?php

namespace Tests\Feature\Reports;

use App\Models\AlertEvent;
use App\Models\AlertRule;
use App\Models\Incident;
use App\Models\Server;
use App\Models\UptimeCheck;
use App\Models\UptimeCheckResult;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ReportApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
        Carbon::setTestNow(now());
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_summary_route_requires_reports_view_permission(): void
    {
        $noPerm = User::factory()->create();
        $this->actingAs($noPerm)->getJson('/api/reports/summary')->assertForbidden();
    }

    public function test_export_route_requires_reports_generate_permission(): void
    {
        $viewer = User::factory()->create();
        $viewer->assignRole('Viewer'); // has reports.view but not reports.generate

        $this->actingAs($viewer)->getJson('/api/reports/export')->assertForbidden();
    }

    public function test_malformed_from_param_returns_a_validation_error_not_a_server_error(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/reports/summary?from=not-a-date');
        $response->assertStatus(422);
    }

    public function test_summary_computes_uptime_percent_from_check_results(): void
    {
        $check = UptimeCheck::create(['name' => 'homepage', 'url' => 'https://example.com']);
        UptimeCheckResult::create(['uptime_check_id' => $check->id, 'success' => true, 'checked_at' => now()->subHours(2)]);
        UptimeCheckResult::create(['uptime_check_id' => $check->id, 'success' => true, 'checked_at' => now()->subHour()]);
        UptimeCheckResult::create(['uptime_check_id' => $check->id, 'success' => false, 'checked_at' => now()->subMinutes(30)]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/reports/summary');
        $response->assertOk();
        $this->assertEqualsWithDelta(66.67, $response->json('uptime.overall_percent'), 0.01);
        $this->assertSame(3, $response->json('uptime.total_checks'));
        $this->assertSame(1, $response->json('uptime.failed_checks'));
    }

    public function test_summary_groups_firing_alert_events_by_severity(): void
    {
        $server = Server::create(['name' => 'report-target']);
        $rule = AlertRule::create(['name' => 'cpu high', 'metric' => 'cpu_percent', 'server_id' => $server->id, 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'critical']);
        AlertEvent::create(['alert_rule_id' => $rule->id, 'server_id' => $server->id, 'from_state' => 'pending', 'to_state' => 'firing', 'occurred_at' => now()->subHour()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/reports/summary');
        $this->assertSame(1, $response->json('alerts_by_severity.critical'));
    }

    public function test_summary_computes_incident_count_and_mttr(): void
    {
        $server = Server::create(['name' => 'report-target-2']);
        Incident::create([
            'title' => 'cpu high', 'severity' => 'critical', 'server_id' => $server->id,
            'status' => 'resolved', 'started_at' => now()->subHours(2), 'resolved_at' => now()->subHour(),
        ]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/reports/summary');
        $this->assertSame(1, $response->json('incidents.count'));
        $this->assertSame(1, $response->json('incidents.resolved_count'));
        $this->assertSame(3600, $response->json('incidents.mttr_seconds'));
    }

    public function test_summary_ranks_top_problem_servers_by_firing_alert_count(): void
    {
        $noisyServer = Server::create(['name' => 'noisy']);
        $quietServer = Server::create(['name' => 'quiet']);
        $rule = AlertRule::create(['name' => 'cpu high', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        AlertEvent::create(['alert_rule_id' => $rule->id, 'server_id' => $noisyServer->id, 'from_state' => 'pending', 'to_state' => 'firing', 'occurred_at' => now()->subHours(3)]);
        AlertEvent::create(['alert_rule_id' => $rule->id, 'server_id' => $noisyServer->id, 'from_state' => 'resolved', 'to_state' => 'firing', 'occurred_at' => now()->subHours(2)]);
        AlertEvent::create(['alert_rule_id' => $rule->id, 'server_id' => $quietServer->id, 'from_state' => 'pending', 'to_state' => 'firing', 'occurred_at' => now()->subHour()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/reports/summary');
        $this->assertSame('noisy', $response->json('top_problem_servers.0.server_name'));
        $this->assertSame(2, $response->json('top_problem_servers.0.alert_count'));
    }

    public function test_csv_export_streams_expected_headers(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/api/reports/export?format=csv');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('range_from', $response->streamedContent());
    }

    public function test_pdf_export_returns_a_pdf_response(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/api/reports/export?format=pdf');
        $response->assertOk();
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
    }
}
