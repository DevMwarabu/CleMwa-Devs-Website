<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlertEvent;
use App\Models\Incident;
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

    /**
     * Top-N problem servers by resource usage, firing-alert count, and
     * cumulative incident downtime — pure aggregation over data already
     * collected by earlier phases, no new storage.
     */
    public function topN(Request $request)
    {
        $limit = max(1, min((int) $request->query('limit', 5), 20));

        return response()->json([
            'top_cpu' => $this->topByMetric('cpu_percent', $limit),
            'top_memory' => $this->topByMetric('memory_percent', $limit),
            'top_disk' => $this->topByMetric('disk_percent', $limit),
            'most_alerts' => $this->mostAlerts($limit),
            'most_downtime' => $this->mostDowntime($limit),
        ]);
    }

    private function topByMetric(string $key, int $limit): array
    {
        return Server::with('metric')->get()
            ->filter(fn ($s) => $s->metric !== null)
            ->map(function ($s) use ($key) {
                $percentages = MetricRangeQuery::extractPercentages(
                    json_encode($s->metric->cpu),
                    json_encode($s->metric->memory),
                    json_encode($s->metric->disk),
                );

                return ['server_id' => $s->id, 'server_name' => $s->name, 'value' => $percentages[$key]];
            })
            ->filter(fn ($row) => $row['value'] !== null)
            ->sortByDesc('value')
            ->take($limit)
            ->values()
            ->toArray();
    }

    private function mostAlerts(int $limit): array
    {
        $rows = AlertEvent::where('to_state', 'firing')
            ->whereNotNull('server_id')
            ->selectRaw('server_id, count(*) as alert_count')
            ->groupBy('server_id')
            ->orderByDesc('alert_count')
            ->limit($limit)
            ->get();

        $servers = Server::whereIn('id', $rows->pluck('server_id'))->get()->keyBy('id');

        return $rows->map(fn ($row) => [
            'server_id' => $row->server_id,
            'server_name' => $servers->get($row->server_id)?->name ?? 'unknown',
            'value' => (int) $row->alert_count,
        ])->values()->toArray();
    }

    private function mostDowntime(int $limit): array
    {
        $downtimeSeconds = Incident::all(['server_id', 'started_at', 'resolved_at'])
            ->groupBy('server_id')
            ->map(fn ($incidents) => $incidents->sum(fn ($i) => $i->started_at->diffInSeconds($i->resolved_at ?? now())))
            ->sortDesc()
            ->take($limit);

        $servers = Server::whereIn('id', $downtimeSeconds->keys())->get()->keyBy('id');

        return $downtimeSeconds->map(fn ($seconds, $serverId) => [
            'server_id' => $serverId,
            'server_name' => $servers->get($serverId)?->name ?? 'unknown',
            'value' => (int) $seconds,
        ])->values()->toArray();
    }

    private function average($values): ?float
    {
        $values = $values->filter(fn ($v) => $v !== null);

        return $values->isEmpty() ? null : round($values->avg(), 1);
    }
}
