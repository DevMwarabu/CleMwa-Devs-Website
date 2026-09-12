<?php

namespace App\Console\Commands;

use App\Models\NotificationSetting;
use App\Models\ReportSchedule;
use App\Support\NotificationDispatcher;
use App\Support\ReportBuilder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;

class SendScheduledReports extends Command
{
    protected $signature = 'reports:send-scheduled';

    protected $description = 'Email the periodic monitoring report to configured recipients, if a schedule is enabled and due';

    public function handle(): int
    {
        $schedule = ReportSchedule::getSettings();

        if (! $schedule->enabled) {
            $this->info('Scheduled reports are disabled.');

            return self::SUCCESS;
        }

        if (! $this->isDue($schedule)) {
            $this->info('Not due yet.');

            return self::SUCCESS;
        }

        $to = now();
        $from = $schedule->frequency === 'daily' ? $to->copy()->subDay() : $to->copy()->subWeek();

        $settings = NotificationSetting::first();
        if (! $settings || ! $settings->smtp_enabled || ! $settings->alert_email_recipients) {
            $this->warn('SMTP is not configured or no recipients are set — skipping this run.');

            return self::SUCCESS;
        }

        $summary = ReportBuilder::summary($from, $to);
        $pdf = Pdf::loadView('reports.summary-pdf', ['summary' => $summary])->output();
        $recipients = array_filter(array_map('trim', explode(',', (string) $settings->alert_email_recipients)));

        NotificationDispatcher::sendEmail(
            $settings,
            $recipients,
            'Monitoring Report — '.$from->toDateString().' to '.$to->toDateString(),
            'Your scheduled monitoring report is attached.',
            null,
            [['data' => $pdf, 'name' => 'monitoring-report.pdf', 'options' => ['mime' => 'application/pdf']]]
        );

        $schedule->update(['last_sent_at' => now()]);
        $this->info('Scheduled report sent to '.implode(', ', $recipients));

        return self::SUCCESS;
    }

    private function isDue(ReportSchedule $schedule): bool
    {
        if (! $schedule->last_sent_at) {
            return true;
        }

        $intervalDays = $schedule->frequency === 'daily' ? 1 : 7;

        return $schedule->last_sent_at->diffInDays(now()) >= $intervalDays;
    }
}
