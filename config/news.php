<?php

/**
 * News page — LinkedIn + Instagram auto-feed.
 *
 * Posts are pulled by the scheduled `news:sync` command into the `social_posts`
 * table and served to the News page from the database, so visitors never hit
 * the social APIs and API credentials never reach the browser. Platform
 * credentials live in config/services.php (linkedin / instagram).
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Scheduled synchronisation
    |--------------------------------------------------------------------------
    | `schedule` runs a regular sync of the latest `limit` posts per platform.
    | `deep_schedule` runs a larger sync so deletions of older posts (outside
    | the regular window) are also detected. Set either cron to an empty value
    | to disable it.
    |
    | Every 30 minutes keeps LinkedIn inside its Development tier allowance
    | (100 API calls per member per day): ~48 feed calls plus image lookups
    | for new posts. On that tier LinkedIn is left out of the deep sync, whose
    | first run would need ~300 image lookups (see services.linkedin.tier).
    */
    'sync' => [
        'enabled'       => (bool) env('NEWS_SYNC_ENABLED', true),
        'schedule'      => env('NEWS_SYNC_SCHEDULE', '*/30 * * * *'),
        'limit'         => (int) env('NEWS_SYNC_LIMIT', 30),
        'deep_schedule' => env('NEWS_SYNC_DEEP_SCHEDULE', '15 3 * * *'),
        'deep_limit'    => (int) env('NEWS_SYNC_DEEP_LIMIT', 300),
        'http_timeout'  => (int) env('NEWS_SYNC_HTTP_TIMEOUT', 20),
        'lock_seconds'  => (int) env('NEWS_SYNC_LOCK_SECONDS', 900),
    ],

    /*
    |--------------------------------------------------------------------------
    | Delete safeguards
    |--------------------------------------------------------------------------
    | A sync that would remove more than `max_delete_percent` of a platform's
    | stored posts, or that returns no posts at all while posts are stored, is
    | treated as suspicious. It is only applied once the exact same result has
    | been seen on `suspicious_confirmations` consecutive syncs (0 = never
    | apply suspicious deletions automatically).
    */
    'safeguards' => [
        'max_delete_percent'       => (int) env('NEWS_SYNC_MAX_DELETE_PERCENT', 50),
        'suspicious_confirmations' => (int) env('NEWS_SYNC_SUSPICIOUS_CONFIRMATIONS', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Local media copies
    |--------------------------------------------------------------------------
    | Instagram CDN URLs and LinkedIn download URLs are signed and expire, so
    | each post's preview image is copied to this disk during sync.
    */
    'media' => [
        'disk'      => 'public',
        'directory' => 'news',
        'max_bytes' => (int) env('NEWS_MEDIA_MAX_BYTES', 10 * 1024 * 1024),
    ],

    /*
    |--------------------------------------------------------------------------
    | Access token refresh
    |--------------------------------------------------------------------------
    | Tokens are refreshed this many days before they expire. Refreshed tokens
    | are stored encrypted in `social_access_tokens`.
    */
    'tokens' => [
        'refresh_days_before_expiry' => (int) env('NEWS_TOKEN_REFRESH_DAYS', 10),
        'retry_refresh_after_hours'  => 12,
    ],

    /*
    |--------------------------------------------------------------------------
    | Public profile links (News page "follow us" call to action)
    |--------------------------------------------------------------------------
    */
    'profiles' => [
        'linkedin'  => env('NEWS_LINKEDIN_PROFILE_URL', 'https://www.linkedin.com/company/53510973/'),
        'instagram' => env('NEWS_INSTAGRAM_PROFILE_URL', 'https://www.instagram.com/thedckconstruction/'),
    ],

];
