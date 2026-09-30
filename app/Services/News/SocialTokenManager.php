<?php

namespace App\Services\News;

use App\Enums\SocialPlatform;
use App\Models\SocialAccessToken;

/**
 * Keeps each platform's current OAuth token.
 *
 * The .env token is the seed. Once a client refreshes it, the rotated token is
 * stored (encrypted) and used from then on. Putting new credentials in .env
 * (e.g. after re-authorising the app) re-seeds the stored token automatically.
 */
final class SocialTokenManager
{
    public function resolve(SocialPlatform $platform, string $accessToken, ?string $refreshToken = null): SocialAccessToken
    {
        $seedHash = hash('sha256', $accessToken . '|' . ($refreshToken ?? ''));

        $token = SocialAccessToken::query()->where('platform', $platform)->first();

        if ($token && hash_equals($token->seed_hash, $seedHash)) {
            return $token;
        }

        $token ??= new SocialAccessToken(['platform' => $platform]);
        $token->fill([
            'access_token'             => $accessToken,
            'refresh_token'            => $refreshToken,
            'expires_at'               => null,
            'refresh_token_expires_at' => null,
            'seed_hash'                => $seedHash,
            'last_refreshed_at'        => null,
            'last_refresh_attempt_at'  => null,
        ])->save();

        return $token;
    }

    /**
     * Refresh when close to expiry, or when the expiry is unknown (freshly
     * seeded from .env). Failed attempts back off so a token that cannot be
     * refreshed yet (Instagram: younger than 24h) isn't retried every run.
     */
    public function shouldRefresh(SocialAccessToken $token): bool
    {
        $retryAfter = now()->subHours((int) config('news.tokens.retry_refresh_after_hours', 12));

        if ($token->last_refresh_attempt_at?->gt($retryAfter)) {
            return false;
        }

        return $token->expires_at === null
            || $token->expires_at->lte(now()->addDays((int) config('news.tokens.refresh_days_before_expiry', 10)));
    }

    public function recordRefresh(
        SocialAccessToken $token,
        string $accessToken,
        ?int $expiresIn,
        ?string $refreshToken = null,
        ?int $refreshTokenExpiresIn = null,
    ): void {
        $token->fill([
            'access_token'            => $accessToken,
            'expires_at'              => $expiresIn ? now()->addSeconds($expiresIn) : null,
            'last_refreshed_at'       => now(),
            'last_refresh_attempt_at' => now(),
        ]);

        if ($refreshToken !== null) {
            $token->refresh_token = $refreshToken;
            $token->refresh_token_expires_at = $refreshTokenExpiresIn ? now()->addSeconds($refreshTokenExpiresIn) : null;
        }

        $token->save();
    }

    public function recordFailedRefresh(SocialAccessToken $token): void
    {
        $token->forceFill(['last_refresh_attempt_at' => now()])->save();
    }
}
