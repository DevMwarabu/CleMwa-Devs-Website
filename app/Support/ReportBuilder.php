<?php

namespace App\Support;

use App\Models\AlertEvent;
use App\Models\Incident;
use App\Models\Server;
use App\Models\UptimeCheckResult;
use Illuminate\Support\Carbon;

class ReportBuilder
{
    public static function summary(Carbon $from, Carbon $to): array
    {
        return [
            'range' => ['from' => $from->toIso8601String(), 'to' => $to->toIso8601String()],
            'uptime' => self::uptime($from, $to),
            'alerts_by_severity' => self::alertsBySeverity($from, $to),
            'incidents' => self::incidents($from, $to),
            'top_problem_servers' => self::topProblemServers($from, $to),
        ];
    }

    private static function uptime(Carbon $from, Carbon $to): array
    {
        $results = UptimeCheckResult::whereBetween('checked_at', [$from, $to])->get(['success']);
        $total = $results->count();
        $successful = $results->where('success', true)->count();

        return [
            'overall_percent' => $total > 0 ? round($successful / $total * 100, 2) : null,
            'total_checks' => $total,
            'failed_checks' => $total - $successful,
        ];
    }

    private static function alertsBySeverity(Carbon $from, Carbon $to): array
    {
        return AlertEvent::where('to_state', 'firing')
            ->whereBetween('occurred_at', [$from, $to])
            ->join('alert_rules', 'alert_rules.id', '=', 'alert_events.alert_rule_id')
            ->selectRaw('alert_rules.severity as severity, count(*) as event_count')
            ->groupBy('alert_rules.severity')
            ->pluck('event_count', 'severity')
            ->toArray();
    }

    private static function incidents(Carbon $from, Carbon $to): array
    {
        $count = Incident::whereBetween('started_at', [$from, $to])->count();

        $resolved = Incident::whereNotNull('resolved_at')
            ->whereBetween('resolved_at', [$from, $to])
            ->get(['started_at', 'resolved_at']);

        $mttrSeconds = $resolved->isNotEmpty()
            ? (int) round($resolved->avg(fn ($incident) => $incident->started_at->diffInSeconds($incident->resolved_at)))
            : null;

        $rangeSeconds = $to->diffInSeconds($from);
        $mtbfSeconds = $count > 0 ? (int) round($rangeSeconds / $count) : null;

        return [
            'count' => $count,
            'resolved_count' => $resolved->count(),
            'mttr_seconds' => $mttrSeconds,
            'mtbf_seconds' => $mtbfSeconds,
        ];
    }

    private static function topProblemServers(Carbon $from, Carbon $to, int $limit = 5): array
    {
        $rows = AlertEvent::where('to_state', 'firing')
            ->whereBetween('occurred_at', [$from, $to])
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
            'alert_count' => (int) $row->alert_count,
        ])->values()->toArray();
    }
}
