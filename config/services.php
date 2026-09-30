<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    | News page auto-feed (see config/news.php). Server-side only — never
    | expose these through VITE_* variables.
    |
    | LinkedIn: Community Management API, scopes r_organization_social +
    | w_organization_social (needed to read post images/videos). The refresh
    | token and client credentials are optional and enable automatic refresh.
    */
    'linkedin' => [
        'organization_id' => env('LINKEDIN_ORGANIZATION_ID'),
        'access_token' => env('LINKEDIN_ACCESS_TOKEN'),
        'refresh_token' => env('LINKEDIN_REFRESH_TOKEN'),
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'api_version' => env('LINKEDIN_API_VERSION', '202609'),
        // 'development' (100 API calls per member per day; no LinkedIn deep sync) until LinkedIn approves 'standard'
        'tier' => env('LINKEDIN_API_TIER', 'development'),
    ],

    /*
    | Instagram API with Instagram Login (Professional account), scope
    | instagram_business_basic. Long-lived tokens are refreshed automatically.
    */
    'instagram' => [
        'access_token' => env('INSTAGRAM_ACCESS_TOKEN'),
        'graph_version' => env('INSTAGRAM_GRAPH_VERSION', 'v25.0'),
    ],

];
