<?php

namespace Tests\Feature\Incidents;

use App\Models\AlertRule;
use App\Models\Incident;
use App\Models\Server;
use App\Models\ServerMetric;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class IncidentAutoCreationTest extends TestCase
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

    private function serverWithCpu(float $usagePercent): Server
    {
        $server = Server::create(['name' => 'incident-target']);
        ServerMetric::create(['server_id' => $server->id, 'cpu' => ['usage_percent' => $usagePercent], 'collected_at' => now()]);

        return $server;
    }

    public function test_critical_alert_firing_creates_an_incident(): void
    {
        $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        $this->artisan('alerts:evaluate'); // -> pending
        $this->artisan('alerts:evaluate'); // -> firing

        $this->assertSame(1, Incident::count());
        $this->assertSame('open', Incident::first()->status);
    }

    public function test_non_critical_alert_firing_does_not_create_an_incident(): void
    {
        $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame(0, Incident::count());
    }

    public function test_repeated_firing_does_not_duplicate_the_open_incident(): void
    {
        $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate'); // fires, incident #1
        $this->artisan('alerts:evaluate'); // still firing, no new event, no new incident

        $this->assertSame(1, Incident::count());
    }

    public function test_alert_resolving_resolves_the_incident_and_mttr_is_computable(): void
    {
        $server = $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate'); // -> firing, incident opens

        Carbon::setTestNow(now()->addMinutes(10));
        ServerMetric::where('server_id', $server->id)->update(['cpu' => ['usage_percent' => 5]]);
        $this->artisan('alerts:evaluate'); // -> resolved

        $incident = Incident::first();
        $this->assertSame('resolved', $incident->status);
        $this->assertNotNull($incident->resolved_at);
        $this->assertGreaterThanOrEqual(600, $incident->duration_seconds);
    }

    public function test_a_new_firing_after_resolution_opens_a_fresh_incident(): void
    {
        $server = $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate'); // fires -> incident #1

        ServerMetric::where('server_id', $server->id)->update(['cpu' => ['usage_percent' => 5]]);
        $this->artisan('alerts:evaluate'); // resolves incident #1

        ServerMetric::where('server_id', $server->id)->update(['cpu' => ['usage_percent' => 95]]);
        $this->artisan('alerts:evaluate'); // pending again
        $this->artisan('alerts:evaluate'); // fires again -> incident #2

        $this->assertSame(2, Incident::count());
    }

    public function test_incidents_route_requires_permission(): void
    {
        $noPerm = User::factory()->create();
        $this->actingAs($noPerm)->getJson('/api/incidents')->assertForbidden();
    }

    public function test_operator_can_acknowledge_and_add_note(): void
    {
        $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'critical']);
        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $operator = User::factory()->create();
        $operator->assignRole('Operator');

        $incident = Incident::first();
        $this->actingAs($operator)->putJson("/api/incidents/{$incident->id}", ['status' => 'acknowledged'])
            ->assertOk()
            ->assertJsonPath('status', 'acknowledged');

        $this->actingAs($operator)->postJson("/api/incidents/{$incident->id}/notes", ['body' => 'Investigating now.'])
            ->assertCreated();

        $this->assertSame(1, $incident->fresh()->notes()->count());
    }
}
