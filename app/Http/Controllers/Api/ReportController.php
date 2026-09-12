<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReportSchedule;
use App\Support\ReportBuilder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function summary(Request $request)
    {
        [$from, $to] = $this->range($request);

        return response()->json(ReportBuilder::summary($from, $to));
    }

    public function export(Request $request)
    {
        [$from, $to] = $this->range($request);
        $summary = ReportBuilder::summary($from, $to);

        if ($request->string('format', 'csv')->toString() === 'pdf') {
            return Pdf::loadView('reports.summary-pdf', ['summary' => $summary])->download('monitoring-report.pdf');
        }

        return response()->streamDownload(function () use ($summary) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['metric', 'value']);
            fputcsv($out, ['range_from', $summary['range']['from']]);
            fputcsv($out, ['range_to', $summary['range']['to']]);
            fputcsv($out, ['uptime_percent', $summary['uptime']['overall_percent']]);
            fputcsv($out, ['total_checks', $summary['uptime']['total_checks']]);
            fputcsv($out, ['failed_checks', $summary['uptime']['failed_checks']]);
            foreach ($summary['alerts_by_severity'] as $severity => $count) {
                fputcsv($out, ["alerts_{$severity}", $count]);
            }
            fputcsv($out, ['incident_count', $summary['incidents']['count']]);
            fputcsv($out, ['incident_resolved_count', $summary['incidents']['resolved_count']]);
            fputcsv($out, ['mttr_seconds', $summary['incidents']['mttr_seconds']]);
            fputcsv($out, ['mtbf_seconds', $summary['incidents']['mtbf_seconds']]);
            fputcsv($out, []);
            fputcsv($out, ['top_problem_server', 'alert_count']);
            foreach ($summary['top_problem_servers'] as $row) {
                fputcsv($out, [$row['server_name'], $row['alert_count']]);
            }
            fclose($out);
        }, 'monitoring-report.csv', ['Content-Type' => 'text/csv']);
    }

    public function schedule()
    {
        return response()->json(ReportSchedule::getSettings());
    }

    public function updateSchedule(Request $request)
    {
        $validated = $request->validate([
            'enabled' => 'required|boolean',
            'frequency' => 'required|string|in:daily,weekly',
        ]);

        $schedule = ReportSchedule::getSettings();
        $schedule->update($validated);

        return response()->json($schedule);
    }

    private function range(Request $request): array
    {
        // Validated up front so a malformed from/to returns a clean 422
        // rather than an uncaught Carbon\Exceptions\InvalidFormatException.
        $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
        ]);

        $to = $request->filled('to') ? Carbon::parse($request->string('to')->toString())->endOfDay() : now();
        $from = $request->filled('from') ? Carbon::parse($request->string('from')->toString())->startOfDay() : $to->copy()->subDays(7)->startOfDay();

        return [$from, $to];
    }
}
