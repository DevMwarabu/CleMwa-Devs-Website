<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Support\MetricRangeQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MonitoringOverviewController extends Controller
{
    /**
     * Fleet-wide KPI counts and averages. Servers with no metric yet are
     * counted toward status totals but excluded from the averages — a
     * missing reading is not a real 0%, per the no-fake-data rule.
     */
    public function summary()
    {
        $servers = Server::with('metric')->get();

        $byStatus = $servers->countBy(fn ($s) => $s->status);

        $withMetric = $servers->filter(fn ($s) => $s->metric !== null);
        $percentages = $withMetric->map(function ($s) {
            return MetricRangeQuery::extractPercentages(
                json_encode($s->metric->cpu),
                json_encode($s->metric->memory),
                json_encode($s->metric->disk),
            );
        });

        return response()->json([
            'total_servers' => $servers->count(),
            'online' => $byStatus->get('online', 0),
            'offline' => $byStatus->get('offline', 0),
            'unknown' => $byStatus->get('unknown', 0),
            'reporting_servers' => $withMetric->count(),
            'avg_cpu_percent' => $this->average($percentages->pluck('cpu_percent')),
            'avg_memory_percent' => $this->average($percentages->pluck('memory_percent')),
            'avg_disk_percent' => $this->average($percentages->pluck('disk_percent')),
        ]);
    }

    /**
     * Fleet-wide trend: one averaged point per time bucket across every
     * server's history rows in range, not per-server last-value like
     * ServerController::metricsHistory() — a fleet line needs a genuine
     * cross-server average at each point in time, not one server's latest
     * reading. Disk uses the first reported filesystem per row, matching
     * MetricRangeQuery::extractPercentages()'s same simplification.
     */
    public function history(Request $request)
    {
        $range = MetricRangeQuery::resolve($request->query('range'));
        $bucket = MetricRangeQuery::config($range)['fleet_bucket'];
        $since = MetricRangeQuery::since($range);

        $bucketExpr = MetricRangeQuery::bucketExpr('collected_at', $bucket);
        $cpuExpr = MetricRangeQuery::cpuPercentExpr();
        $memoryExpr = MetricRangeQuery::memoryPercentExpr();
        $diskExpr = MetricRangeQuery::diskPercentExpr();

        $rows = DB::select(
            "select {$bucketExpr} as bucket,
                    avg({$cpuExpr}) as cpu_percent,
                    avg({$memoryExpr}) as memory_percent,
                    avg({$diskExpr}) as disk_percent
             from server_metric_history
             where collected_at >= ?
             group by bucket
             order by bucket",
            [$since]
        );

        $points = collect($rows)->map(fn ($row) => [
            'collected_at' => Carbon::parse($row->bucket)->toIso8601String(),
            'cpu_percent' => $row->cpu_percent !== null ? round((float) $row->cpu_percent, 1) : null,
            'memory_percent' => $row->memory_percent !== null ? round((float) $row->memory_percent, 1) : null,
            'disk_percent' => $row->disk_percent !== null ? round((float) $row->disk_percent, 1) : null,
        ]);

        return response()->json(['range' => $range, 'points' => $points]);
    }

    private function average($values): ?float
    {
        $values = $values->filter(fn ($v) => $v !== null);

        return $values->isEmpty() ? null : round($values->avg(), 1);
    }
}
