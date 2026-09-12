<?php

namespace App\Console\Commands;

use App\Models\MonitoringSetting;
use App\Models\ServerMetricHistory;
use Illuminate\Console\Command;

class PruneMetricHistory extends Command
{
    protected $signature = 'metrics:prune';

    protected $description = 'Delete raw metric history rows older than the configured retention window';

    public function handle(): int
    {
        $days = MonitoringSetting::getSettings()->raw_metrics_retention_days;
        $cutoff = now()->subDays($days);

        $deleted = ServerMetricHistory::where('collected_at', '<', $cutoff)->delete();

        $this->info("Deleted {$deleted} metric history row(s) older than {$days} day(s).");

        return self::SUCCESS;
    }
}
