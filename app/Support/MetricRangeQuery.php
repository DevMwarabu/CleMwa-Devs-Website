<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class MetricRangeQuery
{
    public const RANGES = [
        '1h' => ['minutes' => 60, 'bucket' => null, 'fleet_bucket' => 'minute'],
        '6h' => ['minutes' => 360, 'bucket' => null, 'fleet_bucket' => 'minute'],
        '24h' => ['minutes' => 1440, 'bucket' => 'hour', 'fleet_bucket' => 'hour'],
        '7d' => ['minutes' => 10080, 'bucket' => 'day', 'fleet_bucket' => 'day'],
    ];

    /**
     * Validate a requested range string, falling back to '1h'.
     */
    public static function resolve(?string $requested): string
    {
        $requested = (string) $requested;

        return array_key_exists($requested, self::RANGES) ? $requested : '1h';
    }

    public static function config(string $range): array
    {
        return self::RANGES[$range];
    }

    public static function since(string $range)
    {
        return now()->subMinutes(self::RANGES[$range]['minutes']);
    }

    /**
     * Pull the three scalar percentages this app actually charts out of a
     * history row's raw cpu/memory/disk JSON. Disk uses the root filesystem
     * when present, otherwise the first reported filesystem — a deliberate
     * simplification rather than a full per-mount breakdown.
     */
    public static function extractPercentages(?string $cpuJson, ?string $memoryJson, ?string $diskJson): array
    {
        $cpu = json_decode($cpuJson ?? 'null', true);
        $memory = json_decode($memoryJson ?? 'null', true);
        $disk = json_decode($diskJson ?? 'null', true);

        $memoryPercent = null;
        if (! empty($memory['total_mb'])) {
            $memoryPercent = round(100 * $memory['used_mb'] / $memory['total_mb'], 1);
        }

        $diskPercent = null;
        if (! empty($disk['filesystems'])) {
            $root = collect($disk['filesystems'])->firstWhere('mount', '/') ?? $disk['filesystems'][0];
            $diskPercent = $root['usage_percent'] ?? null;
        }

        return [
            'cpu_percent' => $cpu['usage_percent'] ?? null,
            'memory_percent' => $memoryPercent,
            'disk_percent' => $diskPercent,
        ];
    }

    /**
     * The queries below need raw SQL (bucketed downsampling, JSON numeric
     * extraction) that isn't expressible portably through the query
     * builder, and this app runs Postgres in production but SQLite in
     * tests — so each fragment below branches on driver rather than
     * silently only working on one engine.
     */
    public static function isSqlite(): bool
    {
        return DB::connection()->getDriverName() === 'sqlite';
    }

    /**
     * SQL expression that truncates a timestamp column to the given bucket
     * unit (minute/hour/day), as a string bucket key.
     */
    public static function bucketExpr(string $column, string $unit): string
    {
        if (self::isSqlite()) {
            $format = match ($unit) {
                'minute' => '%Y-%m-%d %H:%M:00',
                'hour' => '%Y-%m-%d %H:00:00',
                default => '%Y-%m-%d 00:00:00',
            };

            return "strftime('{$format}', {$column})";
        }

        return "date_trunc('{$unit}', {$column})";
    }

    /** SQL expression extracting cpu.usage_percent as a number. */
    public static function cpuPercentExpr(string $column = 'cpu'): string
    {
        return self::isSqlite()
            ? "CAST(json_extract({$column}, '$.usage_percent') AS REAL)"
            : "({$column}->>'usage_percent')::numeric";
    }

    /** SQL expression extracting memory used-% (used_mb/total_mb*100) as a number, or null when total_mb is 0/absent. */
    public static function memoryPercentExpr(string $column = 'memory'): string
    {
        if (self::isSqlite()) {
            $total = "CAST(json_extract({$column}, '$.total_mb') AS REAL)";
            $used = "CAST(json_extract({$column}, '$.used_mb') AS REAL)";

            return "case when {$total} > 0 then {$used} / {$total} * 100 else null end";
        }

        $total = "({$column}->>'total_mb')::numeric";
        $used = "({$column}->>'used_mb')::numeric";

        return "case when {$total} > 0 then {$used} / {$total} * 100 else null end";
    }

    /** SQL expression extracting the first reported filesystem's usage_percent as a number. */
    public static function diskPercentExpr(string $column = 'disk'): string
    {
        return self::isSqlite()
            ? "CAST(json_extract({$column}, '$.filesystems[0].usage_percent') AS REAL)"
            : "({$column}->'filesystems'->0->>'usage_percent')::numeric";
    }
}
