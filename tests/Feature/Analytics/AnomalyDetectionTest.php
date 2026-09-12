<?php

namespace Tests\Feature\Analytics;

use App\Models\AlertRule;
use App\Models\AlertState;
use App\Models\Server;
use App\Models\ServerMetric;
use App\Models\ServerMetricHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnomalyDetectionTest extends TestCase
{
    use RefreshDatabase;

    private function stableHistory(Server $server, float $usagePercent, int $rows = 10): void
    {
        for ($i = 0; $i < $rows; $i++) {
            ServerMetricHistory::create([
                'server_id' => $server->id,
                'cpu' => ['usage_percent' => $usagePercent],
                'collected_at' => now()->subMinutes($rows - $i),
            ]);
        }
    }

    public function test_anomaly_rule_does_not_evaluate_without_enough_history(): void
    {
        $server = Server::create(['name' => 'anomaly-01']);
        ServerMetric::create(['server_id' => $server->id, 'cpu' => ['usage_percent' => 90], 'collected_at' => now()]);
        AlertRule::create(['name' => 'cpu anomaly', 'metric' => 'anomaly_cpu_percent', 'server_id' => $server->id, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        $this->artisan('alerts:evaluate')->assertExitCode(0);

        $this->assertSame(0, AlertState::count());
    }

    public function test_anomaly_rule_does_not_fire_for_a_value_within_normal_range(): void
    {
        $server = Server::create(['name' => 'anomaly-02']);
        $this->stableHistory($server, 20);
        ServerMetric::create(['server_id' => $server->id, 'cpu' => ['usage_percent' => 21], 'collected_at' => now()]);
        AlertRule::create(['name' => 'cpu anomaly', 'metric' => 'anomaly_cpu_percent', 'server_id' => $server->id, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame(0, AlertState::where('state', 'firing')->count());
    }

    public function test_anomaly_rule_fires_for_a_value_far_from_the_recent_mean(): void
    {
        $server = Server::create(['name' => 'anomaly-03']);
        // Alternate low/high so stddev is nonzero, then spike far outside it.
        for ($i = 0; $i < 10; $i++) {
            ServerMetricHistory::create([
                'server_id' => $server->id,
                'cpu' => ['usage_percent' => $i % 2 === 0 ? 10 : 12],
                'collected_at' => now()->subMinutes(10 - $i),
            ]);
        }
        ServerMetric::create(['server_id' => $server->id, 'cpu' => ['usage_percent' => 99], 'collected_at' => now()]);
        AlertRule::create(['name' => 'cpu anomaly', 'metric' => 'anomaly_cpu_percent', 'server_id' => $server->id, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame('firing', AlertState::first()->state);
    }

    public function test_flatlined_history_never_flags_a_false_positive(): void
    {
        $server = Server::create(['name' => 'anomaly-04']);
        $this->stableHistory($server, 50); // stddev == 0
        ServerMetric::create(['server_id' => $server->id, 'cpu' => ['usage_percent' => 50], 'collected_at' => now()]);
        AlertRule::create(['name' => 'cpu anomaly', 'metric' => 'anomaly_cpu_percent', 'server_id' => $server->id, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame(0, AlertState::where('state', 'firing')->count());
    }
}
