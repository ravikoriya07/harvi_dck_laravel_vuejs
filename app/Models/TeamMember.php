<?php

namespace App\Models;

use App\Support\ImagePaths;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'team_department_id',
        'image',
        'description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (TeamMember $member): void {
            self::deleteManagedPublicDiskPath($member->image ?? '');
        });
    }

    public static function deleteManagedPublicDiskPath(string $path): void
    {
        if ($path === '' || str_starts_with($path, '/') || preg_match('#\.\.#', $path)) {
            return;
        }

        if (! str_starts_with($path, 'team-members/')) {
            return;
        }

        $disk = Storage::disk('public');

        if ($disk->exists($path)) {
            $disk->delete($path);
        }
    }

    public static function absoluteMediaUrl(string $path): string
    {
        if ($path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return asset(ImagePaths::preferAvif($path));
        }

        $resolved = ImagePaths::preferAvif($path);

        if (Storage::disk('public')->exists($resolved)) {
            return asset('storage/' . $resolved);
        }

        $legacy = ImagePaths::resolveLegacyAssetByBasename(basename($path));

        if ($legacy !== null) {
            return $legacy;
        }

        return asset('storage/' . $path);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(TeamDepartment::class, 'team_department_id');
    }

    public function getImageUrlAttribute(): string
    {
        return static::absoluteMediaUrl($this->image ?? '');
    }
}
