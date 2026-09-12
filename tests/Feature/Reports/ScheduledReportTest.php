<?php

namespace Tests\Feature\Reports;

use App\Models\NotificationSetting;
use App\Models\ReportSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ScheduledReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(now());
        Mail::fake();
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    private function configureEmailSettings(): void
    {
        NotificationSetting::getSettings()->update([
            'smtp_enabled' => true,
            'smtp_host' => 'smtp.example.com',
            'smtp_username' => 'alerts@example.com',
            'alert_email_recipients' => 'ops@example.com',
        ]);
    }

    public function test_disabled_schedule_sends_nothing(): void
    {
        ReportSchedule::getSettings()->update(['enabled' => false]);
        $this->configureEmailSettings();

        $this->artisan('reports:send-scheduled')->assertExitCode(0);

        Mail::assertNothingSent();
    }

    public function test_enabled_schedule_with_no_last_sent_at_sends_immediately(): void
    {
        ReportSchedule::getSettings()->update(['enabled' => true, 'frequency' => 'weekly']);
        $this->configureEmailSettings();

        $this->artisan('reports:send-scheduled')->assertExitCode(0);

        $this->assertNotNull(ReportSchedule::getSettings()->last_sent_at);
    }

    public function test_weekly_schedule_does_not_resend_before_seven_days(): void
    {
        $lastSent = now()->subDays(3);
        ReportSchedule::getSettings()->update(['enabled' => true, 'frequency' => 'weekly', 'last_sent_at' => $lastSent]);
        $this->configureEmailSettings();

        $this->artisan('reports:send-scheduled')->assertExitCode(0);

        $this->assertEqualsWithDelta($lastSent->timestamp, ReportSchedule::getSettings()->last_sent_at->timestamp, 1);
    }

    public function test_weekly_schedule_resends_after_seven_days(): void
    {
        ReportSchedule::getSettings()->update(['enabled' => true, 'frequency' => 'weekly', 'last_sent_at' => now()->subDays(8)]);
        $this->configureEmailSettings();

        $this->artisan('reports:send-scheduled')->assertExitCode(0);

        $this->assertEqualsWithDelta(now()->timestamp, ReportSchedule::getSettings()->last_sent_at->timestamp, 1);
    }

    public function test_missing_smtp_configuration_skips_without_marking_sent(): void
    {
        ReportSchedule::getSettings()->update(['enabled' => true, 'frequency' => 'daily']);
        // No configureEmailSettings() call — SMTP left disabled.

        $this->artisan('reports:send-scheduled')->assertExitCode(0);

        $this->assertNull(ReportSchedule::getSettings()->last_sent_at);
        Mail::assertNothingSent();
    }
}
