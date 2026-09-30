<?php

namespace App\Services\News;

use App\Models\SocialPost;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Local copies of post preview images.
 *
 * Instagram CDN URLs and LinkedIn download URLs are signed and expire (days to
 * weeks), so hot-linking them would leave broken images on the News page.
 * Files are removed when the post is removed from the platform.
 */
final class SocialMediaStore
{
    private const EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/jpg'  => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        'image/avif' => 'avif',
    ];

    /**
     * Download `$url` and store it for `$post`. Returns the stored path, or
     * null when the download is not a usable image (retried on the next sync).
     */
    public function store(SocialPost $post, string $url): ?string
    {
        if (! preg_match('#^https://#i', $url)) {
            return null;
        }

        try {
            $response = Http::timeout((int) config('news.sync.http_timeout', 20))
                ->connectTimeout(10)
                ->get($url);
        } catch (ConnectionException) {
            $this->logFailure($post, 'connection failed');

            return null;
        }

        $mime = strtolower(trim(explode(';', (string) $response->header('Content-Type'))[0]));
        $extension = self::EXTENSIONS[$mime] ?? null;
        $body = $response->body();

        if (! $response->successful() || $extension === null || $body === '') {
            $this->logFailure($post, "HTTP {$response->status()}, {$mime}");

            return null;
        }

        if (strlen($body) > (int) config('news.media.max_bytes')) {
            $this->logFailure($post, 'file too large');

            return null;
        }

        // Content hash in the name: a replaced image gets a new URL (no stale browser cache)
        $path = sprintf(
            '%s/%s/%s-%s.%s',
            trim((string) config('news.media.directory', 'news'), '/'),
            $post->platform->value,
            substr(sha1($post->external_id), 0, 20),
            substr(sha1($body), 0, 12),
            $extension,
        );

        return $this->disk()->put($path, $body) ? $path : null;
    }

    public function exists(?string $path): bool
    {
        return $path !== null && $path !== '' && $this->disk()->exists($path);
    }

    public function delete(?string $path): void
    {
        if ($this->exists($path)) {
            $this->disk()->delete($path);
        }
    }

    private function disk(): Filesystem
    {
        return Storage::disk(config('news.media.disk', 'public'));
    }

    private function logFailure(SocialPost $post, string $detail): void
    {
        Log::notice('News sync: could not store post image; will retry next sync.', [
            'platform'    => $post->platform->value,
            'external_id' => $post->external_id,
            'detail'      => $detail,
        ]);
    }
}
