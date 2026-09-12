<?php

namespace App\Support;

use App\Models\AlertState;
use App\Models\Server;

/**
 * A weighted 0-100 score computed on read (same "no persisted derived state"
 * approach as Server::getStatusAttribute()) — never stored, always fresh.
 */
class HealthScoreCalculator
{
    private const SEVERITY_PENALTY = ['critical' => 25, 'high' => 15, 'warning' => 10, 'info' => 5];

    public static function calculate(Server $server): array
    {
        $score = 100;
        $reasons = [];

        if ($server->status === 'offline') {
            $score -= 40;
            $reasons[] = 'Server is offline';
        } elseif ($server->status === 'unknown') {
            $score -= 25;
            $reasons[] = 'Server has never reported a heartbeat';
        }

        $server->loadMissing('metric');
        if ($server->metric) {
            $percentages = MetricRangeQuery::extractPercentages(
                json_encode($server->metric->cpu),
                json_encode($server->metric->memory),
                json_encode($server->metric->disk),
            );

            [$score, $reasons] = self::applyResourcePenalty($score, $reasons, 'CPU', $percentages['cpu_percent']);
            [$score, $reasons] = self::applyResourcePenalty($score, $reasons, 'Memory', $percentages['memory_percent']);
            [$score, $reasons] = self::applyResourcePenalty($score, $reasons, 'Disk', $percentages['disk_percent']);
        }

        $firingStates = AlertState::where('server_id', $server->id)->where('state', 'firing')->with('rule')->get();
        foreach ($firingStates->groupBy(fn ($state) => $state->rule?->severity ?? 'warning') as $severity => $states) {
            $penalty = (self::SEVERITY_PENALTY[$severity] ?? 10) * $states->count();
            $score -= $penalty;
            $reasons[] = $states->count().' '.$severity.' alert(s) firing';
        }

        $score = max(0, min(100, $score));

        return ['score' => $score, 'reasons' => $reasons];
    }

    private static function applyResourcePenalty(int $score, array $reasons, string $label, ?float $percent): array
    {
        if ($percent === null) {
            return [$score, $reasons];
        }

        if ($percent >= 90) {
            $score -= 20;
            $reasons[] = "{$label} usage critically high ({$percent}%)";
        } elseif ($percent >= 80) {
            $score -= 10;
            $reasons[] = "{$label} usage high ({$percent}%)";
        }

        return [$score, $reasons];
    }
}
