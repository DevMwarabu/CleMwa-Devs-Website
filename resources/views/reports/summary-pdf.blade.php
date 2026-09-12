<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: sans-serif; font-size: 12px; color: #1f2937; }
    h1 { font-size: 18px; margin-bottom: 0; }
    .range { color: #6b7280; margin-top: 2px; margin-bottom: 20px; }
    h2 { font-size: 13px; margin-top: 24px; margin-bottom: 6px; border-bottom: 1px solid #e5e7eb; padding-bottom: 4px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { text-align: left; padding: 4px 6px; border-bottom: 1px solid #e5e7eb; }
    th { color: #6b7280; font-size: 10px; text-transform: uppercase; }
    .stat { display: inline-block; width: 32%; margin-bottom: 12px; }
    .stat .value { font-size: 20px; font-weight: bold; }
    .stat .label { color: #6b7280; font-size: 10px; text-transform: uppercase; }
</style>
</head>
<body>
    <h1>Monitoring Report</h1>
    <p class="range">{{ $summary['range']['from'] }} &mdash; {{ $summary['range']['to'] }}</p>

    <div>
        <div class="stat">
            <div class="value">{{ $summary['uptime']['overall_percent'] !== null ? $summary['uptime']['overall_percent'].'%' : 'N/A' }}</div>
            <div class="label">Uptime</div>
        </div>
        <div class="stat">
            <div class="value">{{ $summary['incidents']['count'] }}</div>
            <div class="label">Incidents</div>
        </div>
        <div class="stat">
            <div class="value">{{ $summary['incidents']['mttr_seconds'] !== null ? gmdate('H:i:s', $summary['incidents']['mttr_seconds']) : 'N/A' }}</div>
            <div class="label">MTTR</div>
        </div>
    </div>

    <h2>Alerts by Severity</h2>
    <table>
        <thead><tr><th>Severity</th><th>Count</th></tr></thead>
        <tbody>
            @forelse ($summary['alerts_by_severity'] as $severity => $count)
                <tr><td>{{ ucfirst($severity) }}</td><td>{{ $count }}</td></tr>
            @empty
                <tr><td colspan="2">No alerts fired in this range.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Top Problem Servers</h2>
    <table>
        <thead><tr><th>Server</th><th>Alert Count</th></tr></thead>
        <tbody>
            @forelse ($summary['top_problem_servers'] as $row)
                <tr><td>{{ $row['server_name'] }}</td><td>{{ $row['alert_count'] }}</td></tr>
            @empty
                <tr><td colspan="2">No firing alerts in this range.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Uptime Detail</h2>
    <table>
        <tbody>
            <tr><td>Total checks</td><td>{{ $summary['uptime']['total_checks'] }}</td></tr>
            <tr><td>Failed checks</td><td>{{ $summary['uptime']['failed_checks'] }}</td></tr>
        </tbody>
    </table>
</body>
</html>
