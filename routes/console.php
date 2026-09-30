<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
| News page: mirror LinkedIn + Instagram posts (new, edited and deleted) into
| the database. Needs the scheduler cron on the server:
|   * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
| The deep run fetches further back so deletions of older posts are caught too.
*/
$newsSyncEnabled = fn (): bool => (bool) config('news.sync.enabled');
$newsLockMinutes = (int) ceil(config('news.sync.lock_seconds', 900) / 60);

if (filled(config('news.sync.schedule'))) {
    Schedule::command('news:sync')
        ->cron(config('news.sync.schedule'))
        ->when($newsSyncEnabled)
        ->withoutOverlapping($newsLockMinutes);
}

// LinkedIn's Development tier (100 API calls a day) can't afford the deep sync's image lookups
$deepSyncPlatforms = strtolower(trim((string) config('services.linkedin.tier', 'development'))) === 'standard' ? [] : ['--platform' => 'instagram'];

if (filled(config('news.sync.deep_schedule'))) {
    Schedule::command('news:sync', ['--limit' => (int) config('news.sync.deep_limit', 300)] + $deepSyncPlatforms)
        ->cron(config('news.sync.deep_schedule'))
        ->when($newsSyncEnabled)
        ->withoutOverlapping($newsLockMinutes);
}
