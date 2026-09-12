<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('metrics:prune')->daily();
Schedule::command('alerts:evaluate')->everyMinute();
Schedule::command('uptime:check')->everyMinute();
Schedule::command('reports:send-scheduled')->daily();
