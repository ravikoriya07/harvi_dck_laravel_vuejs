<?php

namespace App\Models;

use App\Enums\SocialPlatform;
use Illuminate\Database\Eloquent\Model;

/**
 * Current OAuth token per platform.
 *
 * Seeded from .env, then rotated by the sync (LinkedIn refresh tokens,
 * Instagram long-lived token refresh). `.env` cannot be rewritten at runtime,
 * so rotated tokens are persisted here, encrypted with APP_KEY.
 */
class SocialAccessToken extends Model
{
    protected $fillable = [
        'platform',
        'access_token',
        'refresh_token',
        'expires_at',
        'refresh_token_expires_at',
        'seed_hash',
        'last_refreshed_at',
        'last_refresh_attempt_at',
    ];

    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    protected $casts = [
        'platform'                 => SocialPlatform::class,
        'access_token'             => 'encrypted',
        'refresh_token'            => 'encrypted',
        'expires_at'               => 'datetime',
        'refresh_token_expires_at' => 'datetime',
        'last_refreshed_at'        => 'datetime',
        'last_refresh_attempt_at'  => 'datetime',
    ];
}
