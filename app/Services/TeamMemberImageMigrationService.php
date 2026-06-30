<?php

namespace App\Services;

use App\Models\TeamMember;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class TeamMemberImageMigrationService
{
    public function __construct(
        private AvifConversionService $avifConverter,
    ) {}

    public function migrateAllTeamMembers(): void
    {
        TeamMember::query()->orderBy('sort_order')->each(function (TeamMember $member): void {
            $this->migrateTeamMember($member);
        });
    }

    public function migrateTeamMember(TeamMember $member): void
    {
        $storagePath = $this->migrateLegacyPath($member->image ?? '', $member->name);

        if ($storagePath === null || $storagePath === $member->image) {
            return;
        }

        $member->forceFill(['image' => $storagePath])->saveQuietly();
    }

    /**
     * Copy a legacy /assets/... path into storage/team-members/ and return the disk-relative path.
     */
    public function migrateLegacyPath(string $path, string $nameSlugSource): ?string
    {
        $path = trim($path);

        if ($path === '') {
            return null;
        }

        if ($this->isStorageRelativePath($path)) {
            $normalized = ltrim($path, '/');

            return Storage::disk('public')->exists($normalized) ? $normalized : null;
        }

        if (! str_starts_with($path, '/assets/')) {
            return null;
        }

        $absolute = public_path(ltrim($path, '/'));

        if (! is_file($absolute)) {
            return null;
        }

        $extension = pathinfo($absolute, PATHINFO_EXTENSION) ?: 'avif';
        $filename = Str::slug($nameSlugSource) . '.' . strtolower($extension);
        $relative = 'team-members/' . $filename;
        $disk = Storage::disk('public');

        if (! $disk->exists($relative)) {
            $disk->put($relative, File::get($absolute));
            $relative = $this->avifConverter->convertPublicDiskPath($relative) ?? $relative;
        }

        return $relative;
    }

    private function isStorageRelativePath(string $path): bool
    {
        $normalized = ltrim($path, '/');

        return ! str_starts_with($path, '/assets/')
            && ! str_starts_with($path, '/')
            && str_starts_with($normalized, 'team-members/');
    }
}
