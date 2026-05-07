<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

final class ProjectImageMigrationService
{
    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    public function __construct(
        private Filesystem $disk,
    ) {}

    public static function usingPublicDisk(): self
    {
        return new self(Storage::disk('public'));
    }

    /**
     * Migrate thumbnail + gallery for every project (idempotent).
     */
    public function migrateAllProjects(): void
    {
        Project::query()->orderBy('sort_order')->each(function (Project $project): void {
            $this->migrateProject($project);
        });
    }

    /**
     * Copy assets into storage/projects/{slug}/ and update thumbnail + project_images paths.
     */
    public function migrateProject(Project $project): void
    {
        $slug = $project->slug;

        $thumbStorage = $this->migratePathForProject($slug, $project->image ?? '');
        $galleryStorage = $this->resolveGalleryPaths($project);

        $dirty = false;

        if ($thumbStorage !== null && $thumbStorage !== ($project->image ?? '')) {
            $project->image = $thumbStorage;
            $dirty = true;
        }

        if ($dirty) {
            $project->save();
        }

        if ($galleryStorage !== null) {
            ProjectImage::syncOrderedPathsForProject($project->id, array_values($galleryStorage));
        }
    }

    /**
     * @return list<string>|null
     */
    private function resolveGalleryPaths(Project $project): ?array
    {
        $discover = config('project_images.discover_galleries.' . $project->slug);

        if (is_array($discover) && isset($discover['directory'])) {
            return $this->discoverAndMigrateGallery(
                $project,
                (string) $discover['directory'],
                ($discover['sort'] ?? 'natural') === 'natural'
            );
        }

        return $this->migrateGalleryFromRelation($project);
    }

    /**
     * @return list<string>|null
     */
    private function migrateGalleryFromRelation(Project $project): ?array
    {
        $paths = $project->galleryImages()->orderBy('sort_order')->orderBy('id')->pluck('path')->all();

        if ($paths === []) {
            return null;
        }

        $out = [];
        $seen = [];

        foreach ($paths as $webPath) {
            if (! is_string($webPath) || $webPath === '') {
                continue;
            }

            $stored = $this->migratePathForProject($project->slug, $webPath);
            if ($stored === null) {
                continue;
            }

            if (! isset($seen[$stored])) {
                $seen[$stored] = true;
                $out[] = $stored;
            }
        }

        return $out === [] ? null : $out;
    }

    /**
     * @return list<string>|null
     */
    private function discoverAndMigrateGallery(Project $project, string $directoryRelativeToAssetsImages, bool $naturalSort): ?array
    {
        $slug = $project->slug;
        $base = public_path('assets/images/' . trim($directoryRelativeToAssetsImages, '/'));

        if (! is_dir($base)) {
            Log::warning('ProjectImageMigrationService: gallery directory missing, falling back to existing DB paths', [
                'path' => $base,
                'slug' => $slug,
            ]);

            return $this->migrateGalleryFromRelation($project);
        }

        $files = [];

        foreach (File::files($base) as $fileInfo) {
            $ext = strtolower($fileInfo->getExtension());
            if (! in_array($ext, self::IMAGE_EXTENSIONS, true)) {
                continue;
            }

            $files[] = $fileInfo->getPathname();
        }

        if ($files === []) {
            Log::warning('ProjectImageMigrationService: no images in gallery directory, falling back to existing DB paths', [
                'path' => $base,
                'slug' => $slug,
            ]);

            return $this->migrateGalleryFromRelation($project);
        }

        if ($naturalSort) {
            usort($files, fn (string $a, string $b): int => strnatcasecmp(basename($a), basename($b)));
        }

        $out = [];
        $seen = [];

        foreach ($files as $absolute) {
            $stored = $this->copyIntoProjectStorage($slug, $absolute, basename($absolute));
            if ($stored === null) {
                continue;
            }
            if (! isset($seen[$stored])) {
                $seen[$stored] = true;
                $out[] = $stored;
            }
        }

        return $out === [] ? null : $out;
    }

    /**
     * Migrate a single web-relative or storage-relative path into projects/{slug}/.
     */
    public function migratePathForProject(string $slug, string $path): ?string
    {
        $path = trim($path);
        if ($path === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            return null;
        }

        if ($this->isStorageRelativeProjectPath($path)) {
            $normalized = ltrim($path, '/');
            if ($this->disk->exists($normalized)) {
                return $normalized;
            }

            Log::warning('ProjectImageMigrationService: storage path missing on disk', ['path' => $normalized]);

            return null;
        }

        $absolute = $this->resolvePublicAssetAbsolutePath($path);
        if ($absolute === null || ! is_readable($absolute)) {
            Log::warning('ProjectImageMigrationService: source file not found', ['path' => $path]);

            return null;
        }

        return $this->copyIntoProjectStorage($slug, $absolute, basename($absolute));
    }

    private function isStorageRelativeProjectPath(string $path): bool
    {
        $t = ltrim($path, '/');

        return ! str_starts_with($path, '/assets/')
            && ! str_starts_with($path, 'assets/')
            && ! str_starts_with($path, '/')
            && str_starts_with($t, 'projects/');
    }

    /**
     * Resolve /assets/... paths to public disk; handles legacy …/projects/N/… vs …/projects/projects/N/… layout.
     */
    public function resolvePublicAssetAbsolutePath(string $path): ?string
    {
        $relative = ltrim($path, '/');

        $candidates = [
            public_path($relative),
        ];

        if (preg_match('#^assets/images/projects/(\d+)/(.*)$#', $relative, $m)) {
            $candidates[] = public_path("assets/images/projects/projects/{$m[1]}/{$m[2]}");
        }

        foreach ($candidates as $abs) {
            if (is_file($abs)) {
                return $abs;
            }
        }

        return null;
    }

    private function copyIntoProjectStorage(string $slug, string $sourceAbsolute, string $filename): ?string
    {
        $filename = basename($filename);
        if ($filename === '' || str_contains($filename, '..')) {
            return null;
        }

        $relative = 'projects/' . $slug . '/' . $filename;

        if ($this->disk->exists($relative)) {
            return $relative;
        }

        try {
            $stream = fopen($sourceAbsolute, 'rb');
            if ($stream === false) {
                return null;
            }

            // writeStream closes the stream when finished.
            $this->disk->writeStream($relative, $stream);
        } catch (\Throwable $e) {
            Log::error('ProjectImageMigrationService: copy failed', [
                'slug' => $slug,
                'from' => $sourceAbsolute,
                'to' => $relative,
                'error' => $e->getMessage(),
            ]);

            return null;
        }

        return $relative;
    }
}
