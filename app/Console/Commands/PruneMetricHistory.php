<?php

namespace App\Console\Commands;

use App\Models\MonitoringSetting;
use App\Models\ServerMetricHistory;
use App\Models\UptimeCheckResult;
use Illuminate\Console\Command;

class PruneMetricHistory extends Command
{
    protected $signature = 'metrics:prune';

    protected $description = 'Delete raw metric/uptime-check history rows older than the configured retention window';

    public function handle(): int
    {
        $days = MonitoringSetting::getSettings()->raw_metrics_retention_days;
        $cutoff = now()->subDays($days);

        $deletedMetrics = ServerMetricHistory::where('collected_at', '<', $cutoff)->delete();
        $deletedUptime = UptimeCheckResult::where('checked_at', '<', $cutoff)->delete();

        $this->info("Deleted {$deletedMetrics} metric history row(s) and {$deletedUptime} uptime check result(s) older than {$days} day(s).");

        return self::SUCCESS;
    }
}
