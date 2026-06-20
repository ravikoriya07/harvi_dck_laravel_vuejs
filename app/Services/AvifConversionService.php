<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class AvifConversionService
{
    /** @var list<string> */
    private array $convertibleExtensions;

    public function __construct()
    {
        $this->convertibleExtensions = array_map(
            'strtolower',
            config('images.convertible_extensions', ['jpg', 'jpeg', 'png', 'webp', 'gif'])
        );
    }

    public function isEnabled(): bool
    {
        return (bool) config('images.avif.enabled', true)
            && function_exists('imageavif')
            && (gd_info()['AVIF Support'] ?? false);
    }

    public function isConvertibleExtension(string $extension): bool
    {
        return in_array(strtolower($extension), $this->convertibleExtensions, true);
    }

    public function shouldSkipPath(string $path): bool
    {
        $basename = strtolower(basename($path));

        foreach (config('images.skip_patterns', []) as $pattern) {
            if (str_contains($basename, strtolower($pattern))) {
                return true;
            }
        }

        return false;
    }

    public function avifPathFor(string $path): string
    {
        $info = pathinfo($path);

        return ($info['dirname'] !== '.' ? $info['dirname'] . '/' : '') . ($info['filename'] ?? '') . '.avif';
    }

    public function avifWebPath(string $webPath): string
    {
        $parsed = parse_url($webPath);
        $path = $parsed['path'] ?? $webPath;
        $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
        $fragment = isset($parsed['fragment']) ? '#' . $parsed['fragment'] : '';

        $avifPath = $this->avifPathFor($path);

        if (isset($parsed['scheme'], $parsed['host'])) {
            $port = isset($parsed['port']) ? ':' . $parsed['port'] : '';

            return $parsed['scheme'] . '://' . $parsed['host'] . $port . $avifPath . $query . $fragment;
        }

        return $avifPath . $query . $fragment;
    }

    /**
     * @return array{source: string, destination: string, source_size: int, destination_size: int}|null
     */
    public function convertAbsolutePath(string $absolutePath, ?string $destinationPath = null): ?array
    {
        if (! $this->isEnabled()) {
            Log::warning('AvifConversionService: AVIF conversion is disabled or unsupported by GD.');

            return null;
        }

        if (! is_readable($absolutePath)) {
            return null;
        }

        $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));

        if (! $this->isConvertibleExtension($extension)) {
            return null;
        }

        if ($this->shouldSkipPath($absolutePath)) {
            return null;
        }

        $destination = $destinationPath ?? $this->avifPathFor($absolutePath);

        $destinationDir = dirname($destination);
        if (! is_dir($destinationDir)) {
            File::ensureDirectoryExists($destinationDir);
        }

        $image = $this->createImageResource($absolutePath, $extension);
        if ($image === null) {
            Log::warning('AvifConversionService: could not load image', ['path' => $absolutePath]);

            return null;
        }

        $quality = (int) config('images.avif.quality', 60);
        $speed = (int) config('images.avif.speed', 6);

        $success = @imageavif($image, $destination, $quality, $speed);
        imagedestroy($image);

        if (! $success || ! is_file($destination) || filesize($destination) === 0) {
            if (is_file($destination)) {
                File::delete($destination);
            }

            Log::warning('AvifConversionService: imageavif() failed or produced empty file', ['path' => $absolutePath]);

            return null;
        }

        return [
            'source' => $absolutePath,
            'destination' => $destination,
            'source_size' => (int) filesize($absolutePath),
            'destination_size' => (int) filesize($destination),
        ];
    }

    /**
     * Convert a file on the public disk and return the new storage-relative path.
     */
    public function convertPublicDiskPath(string $relativePath): ?string
    {
        $relativePath = ltrim($relativePath, '/');

        if ($relativePath === '' || str_ends_with(strtolower($relativePath), '.avif')) {
            return $relativePath ?: null;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($relativePath)) {
            return null;
        }

        $absolute = $disk->path($relativePath);
        $avifRelative = ltrim($this->avifPathFor($relativePath), '/');

        if ($disk->exists($avifRelative)) {
            $this->archiveAndDeleteOriginal($absolute, $relativePath);

            return $avifRelative;
        }

        $result = $this->convertAbsolutePath($absolute, $disk->path($avifRelative));
        if ($result === null) {
            return null;
        }

        $this->archiveAndDeleteOriginal($absolute, $relativePath);

        return $avifRelative;
    }

    /**
     * Store an uploaded file on the public disk as AVIF.
     */
    public function storeUploadedAsAvif(
        UploadedFile $file,
        string $directory = '',
        string $disk = 'public',
        ?string $filename = null,
    ): string {
        $directory = trim($directory, '/');
        $filename = $filename ?? Str::uuid()->toString();
        $filename = pathinfo($filename, PATHINFO_FILENAME) . '.avif';

        $relative = $directory === '' ? $filename : $directory . '/' . $filename;
        $absolute = Storage::disk($disk)->path($relative);

        File::ensureDirectoryExists(dirname($absolute));

        $extension = strtolower($file->getClientOriginalExtension());
        $tempPath = $file->getRealPath() ?: $file->getPathname();

        if ($this->isEnabled() && $this->isConvertibleExtension($extension)) {
            $result = $this->convertAbsolutePath($tempPath, $absolute);
            if ($result !== null) {
                return $relative;
            }
        }

        $fallbackName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        $fallbackRelative = $directory === '' ? $fallbackName : $directory . '/' . $fallbackName;
        Storage::disk($disk)->putFileAs($directory, $file, $fallbackName);

        return $fallbackRelative;
    }

    /**
     * @return array{source: string, destination: string, source_size: int, destination_size: int}|null
     */
    public function convertPublicAsset(string $webPath): ?array
    {
        $absolute = $this->resolvePublicAssetAbsolute($webPath);
        if ($absolute === null) {
            return null;
        }

        $avifAbsolute = $this->avifPathFor($absolute);

        if (is_file($avifAbsolute)) {
            return [
                'source' => $absolute,
                'destination' => $avifAbsolute,
                'source_size' => (int) filesize($absolute),
                'destination_size' => (int) filesize($avifAbsolute),
            ];
        }

        return $this->convertAbsolutePath($absolute, $avifAbsolute);
    }

    public function resolvePublicAssetAbsolute(string $path): ?string
    {
        $path = trim($path);
        if ($path === '' || preg_match('#^https?://#i', $path)) {
            return null;
        }

        $relative = ltrim($path, '/');

        $candidates = [public_path($relative)];

        if (preg_match('#^assets/images/projects/(\d+)/(.*)$#', $relative, $matches)) {
            $candidates[] = public_path("assets/images/projects/projects/{$matches[1]}/{$matches[2]}");
        }

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    public function archiveAndDeleteOriginal(string $absolutePath, ?string $relativePath = null): void
    {
        if (! is_file($absolutePath)) {
            return;
        }

        if (config('images.archive_originals', true)) {
            $archiveRoot = base_path(config('images.archive_path', 'storage/app/image-originals-archive'));
            $relative = $relativePath ?? str_replace(base_path() . DIRECTORY_SEPARATOR, '', $absolutePath);
            $archiveTarget = $archiveRoot . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relative);

            File::ensureDirectoryExists(dirname($archiveTarget));

            if (! is_file($archiveTarget)) {
                File::copy($absolutePath, $archiveTarget);
            }
        }

        File::delete($absolutePath);
    }

    /**
     * @return \GdImage|resource|null
     */
    private function createImageResource(string $absolutePath, string $extension): mixed
    {
        $image = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($absolutePath),
            'png' => @imagecreatefrompng($absolutePath),
            'webp' => @imagecreatefromwebp($absolutePath),
            'gif' => @imagecreatefromgif($absolutePath),
            default => null,
        };

        if ($image === false) {
            return null;
        }

        return $this->normalizeImageForAvif($image);
    }

    /**
     * @param  \GdImage|resource  $image
     * @return \GdImage|resource
     */
    private function normalizeImageForAvif(mixed $image): mixed
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $maxDimension = (int) config('images.avif.max_dimension', 2560);

        if ($maxDimension > 0 && ($width > $maxDimension || $height > $maxDimension)) {
            $ratio = min($maxDimension / $width, $maxDimension / $height);
            $targetWidth = max(1, (int) round($width * $ratio));
            $targetHeight = max(1, (int) round($height * $ratio));

            $scaled = imagescale($image, $targetWidth, $targetHeight, IMG_BILINEAR_FIXED);
            imagedestroy($image);

            if ($scaled === false) {
                throw new \RuntimeException('Failed to scale image for AVIF conversion.');
            }

            $image = $scaled;
            $width = $targetWidth;
            $height = $targetHeight;
        }

        $canvas = imagecreatetruecolor($width, $height);

        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);

        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, $width, $height, $transparent);

        imagealphablending($canvas, true);
        imagecopy($canvas, $image, 0, 0, 0, 0, $width, $height);
        imagedestroy($image);

        imagealphablending($canvas, true);
        imagesavealpha($canvas, true);

        return $canvas;
    }
}
