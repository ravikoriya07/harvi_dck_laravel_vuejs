<?php

namespace App\Services\News;

use App\Enums\SocialPlatform;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use RuntimeException;

/**
 * A platform API call that did not produce trustworthy data. Any of these
 * aborts the platform's sync for the run: stored posts are kept and no
 * deletions are processed.
 *
 * Messages are redacted — they end up in logs and must never carry tokens.
 */
final class SocialFeedException extends RuntimeException
{
    public const AUTH         = 'auth';
    public const RATE_LIMITED = 'rate_limited';
    public const TIMEOUT      = 'timeout';
    public const MALFORMED    = 'malformed';
    public const HTTP         = 'http_error';

    /** Instagram Graph API error codes: invalid/expired token, and throttling. */
    private const META_AUTH_CODES = [102, 190];
    private const META_RATE_LIMIT_CODES = [4, 17, 32, 613];

    public function __construct(
        public readonly string $reason,
        string $message,
        public readonly ?int $status = null,
    ) {
        parent::__construct(self::redact($message));
    }

    public static function fromResponse(SocialPlatform $platform, Response $response, string $context): self
    {
        $status = $response->status();
        $body = is_array($response->json()) ? $response->json() : [];
        // Graph API: {"error": {"code", "message"}}; LinkedIn: {"serviceErrorCode", "message"}
        $error = is_array($body['error'] ?? null) ? $body['error'] : [];
        $apiCode = $error['code'] ?? $body['serviceErrorCode'] ?? null;
        $apiMessage = $error['message'] ?? $body['message'] ?? null;

        $reason = match (true) {
            $status === 401,
            $status === 403,
            in_array($apiCode, self::META_AUTH_CODES, true) => self::AUTH,
            $status === 429,
            in_array($apiCode, self::META_RATE_LIMIT_CODES, true) => self::RATE_LIMITED,
            default => self::HTTP,
        };

        $message = sprintf('%s %s failed (HTTP %d%s)', $platform->label(), $context, $status, $apiCode !== null ? ", code {$apiCode}" : '');

        if (is_string($apiMessage) && $apiMessage !== '') {
            $message .= ': ' . mb_substr($apiMessage, 0, 200);
        }

        if ($reason === self::AUTH) {
            $message .= ' — the access token is invalid, expired or missing permissions; re-authorise the app and update the token in .env.';
        }

        return new self($reason, $message, $status);
    }

    public static function fromConnection(SocialPlatform $platform, ConnectionException $exception, string $context): self
    {
        return new self(
            self::TIMEOUT,
            sprintf('%s %s timed out or could not connect: %s', $platform->label(), $context, $exception->getMessage()),
        );
    }

    public static function malformed(SocialPlatform $platform, string $context): self
    {
        return new self(self::MALFORMED, sprintf('%s %s returned an unexpected response.', $platform->label(), $context));
    }

    /**
     * Strip anything token-like: URL query strings (Graph API tokens travel as
     * ?access_token=…), key=value credentials and bearer headers.
     */
    public static function redact(string $message): string
    {
        $message = preg_replace('~(https?://[^\s?"\']+)\?[^\s"\']*~i', '$1?[redacted]', $message) ?? '';
        $message = preg_replace('~\b(access_token|refresh_token|client_secret|code)=[^&\s"\']+~i', '$1=[redacted]', $message) ?? '';

        return preg_replace('#Bearer\s+[A-Za-z0-9._~+/-]+=*#i', 'Bearer [redacted]', $message) ?? '';
    }
}
