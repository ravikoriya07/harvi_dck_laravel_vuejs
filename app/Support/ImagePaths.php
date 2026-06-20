<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class ImagePaths
{
    public static function toAvif(string $path): string
    {
        if ($path === '' || str_ends_with(strtolower($path), '.avif')) {
            return $path;
        }

        $info = pathinfo($path);
        $dirname = ($info['dirname'] ?? '') !== '.' ? $info['dirname'] . '/' : '';

        return $dirname . ($info['filename'] ?? '') . '.avif';
    }

    public static function preferAvif(string $path): string
    {
        return self::resolveExisting($path, preferAvif: true);
    }

    /**
     * Resolve to the first path that exists on disk (storage or legacy /assets/).
     */
    public static function resolveExisting(string $path, bool $preferAvif = false): string
    {
        $candidates = $preferAvif
            ? array_unique([self::toAvif($path), $path])
            : [$path];

        foreach ($candidates as $candidate) {
            if (self::existsAtPath($candidate)) {
                return $candidate;
            }
        }

        $legacy = self::resolveLegacyAssetByBasename(basename($path));

        return $legacy ?? $path;
    }

    /**
     * Find a legacy static asset by filename under public/assets/images.
     */
    public static function resolveLegacyAssetByBasename(string $basename): ?string
    {
        if ($basename === '') {
            return null;
        }

        $flatCandidates = [
            '/assets/images/' . $basename,
            '/assets/images/' . pathinfo($basename, PATHINFO_FILENAME) . '.avif',
        ];

        foreach (array_unique($flatCandidates) as $candidate) {
            if (self::existsAtPath($candidate)) {
                return $candidate;
            }
        }

        foreach (['projects', 'projects/projects'] as $prefix) {
            $base = public_path('assets/images/' . $prefix);

            if (! is_dir($base)) {
                continue;
            }

            foreach (glob($base . '/*/' . $basename) ?: [] as $absolute) {
                if (! is_file($absolute)) {
                    continue;
                }

                $relative = str_replace('\\', '/', substr($absolute, strlen(public_path())));

                return '/' . ltrim($relative, '/');
            }

            $avifBasename = pathinfo($basename, PATHINFO_FILENAME) . '.avif';

            if ($avifBasename !== $basename) {
                foreach (glob($base . '/*/' . $avifBasename) ?: [] as $absolute) {
                    if (! is_file($absolute)) {
                        continue;
                    }

                    $relative = str_replace('\\', '/', substr($absolute, strlen(public_path())));

                    return '/' . ltrim($relative, '/');
                }
            }
        }

        return null;
    }

    public static function existsAtPath(string $path): bool
    {
        if (str_starts_with($path, '/assets/')) {
            return is_file(public_path(ltrim($path, '/')));
        }

        if (! str_starts_with($path, '/') && ! preg_match('#^https?://#i', $path)) {
            return Storage::disk('public')->exists(ltrim($path, '/'));
        }

        return false;
    }
}
