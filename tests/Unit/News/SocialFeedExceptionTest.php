<?php

namespace Tests\Unit\News;

use App\Services\News\SocialFeedException;
use PHPUnit\Framework\TestCase;

class SocialFeedExceptionTest extends TestCase
{
    public function test_tokens_are_redacted_from_messages(): void
    {
        $message = SocialFeedException::redact(
            'cURL error 28 for https://graph.instagram.com/v25.0/me/media?fields=id&access_token=IGQVJ-secret-123 '
            . 'refresh_token=AQX-secret client_secret=shh Authorization: Bearer AQV_secret.token-456'
        );

        foreach (['IGQVJ-secret-123', 'AQX-secret', 'shh', 'AQV_secret.token-456'] as $secret) {
            $this->assertStringNotContainsString($secret, $message);
        }

        $this->assertStringContainsString('https://graph.instagram.com/v25.0/me/media?[redacted]', $message);
        $this->assertStringContainsString('Bearer [redacted]', $message);
    }

    public function test_constructor_redacts_the_message(): void
    {
        $exception = new SocialFeedException(SocialFeedException::HTTP, 'failed: access_token=abc123');

        $this->assertSame('failed: access_token=[redacted]', $exception->getMessage());
    }
}
