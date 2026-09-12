<?php

namespace Tests\Feature\Logs;

use App\Models\MonitoringSetting;
use App\Models\Server;
use App\Models\ServerLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServerLogRetentionTest extends TestCase
{
    use RefreshDatabase;

    public function test_prune_command_deletes_logs_older_than_the_retention_window(): void
    {
        MonitoringSetting::getSettings()->update(['raw_metrics_retention_days' => 7]);
        $server = Server::create(['name' => 'retention-01']);

        ServerLog::create(['server_id' => $server->id, 'source' => 'a.log', 'level' => 'INFO', 'message' => 'old', 'logged_at' => now()->subDays(10)]);
        ServerLog::create(['server_id' => $server->id, 'source' => 'a.log', 'level' => 'INFO', 'message' => 'recent', 'logged_at' => now()->subDays(1)]);

        $this->artisan('metrics:prune')->assertExitCode(0);

        $this->assertSame(1, ServerLog::where('server_id', $server->id)->count());
        $this->assertSame('recent', ServerLog::where('server_id', $server->id)->first()->message);
    }
}
