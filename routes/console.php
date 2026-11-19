<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jadwal Backup Otomatis Database PPID setiap hari pukul 02:00 WIB
Schedule::command('ppid:backup')->dailyAt('02:00');

