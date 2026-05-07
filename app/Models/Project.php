<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'image',
        'sort_order',
        'value',
        'date',
        'status',
        'client',
        'scope',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Project $project): void {
            $project->galleryImages()->get()->each(fn (ProjectImage $image) => $image->delete());

            self::deleteManagedPublicDiskPath($project->image ?? '');
        });
    }

    /**
     * Delete storage-backed files under the public disk (projects/* only).
     * Legacy absolute URLs (/assets/…) and remote URLs are skipped.
     */
    public static function deleteManagedPublicDiskPath(string $path): void
    {
        if ($path === '' || str_starts_with($path, '/') || preg_match('#\.\.#', $path)) {
            return;
        }

        if (! str_starts_with($path, 'projects/')) {
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
            return $path;
        }

        return asset('storage/' . $path);
    }

    /** @return HasMany<ProjectImage, $this> */
    public function galleryImages(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function getImageUrlAttribute(): string
    {
        return static::absoluteMediaUrl($this->image ?? '');
    }

    /**
     * Ordered gallery URLs for the detail carousel (project_images only).
     */
    public function getGalleryUrlsAttribute(): array
    {
        $paths = $this->relationalGalleryPathsOrdered();

        if ($paths === [] && ($this->image ?? '') !== '') {
            $paths = [$this->image];
        }

        return array_values(array_filter(array_map(fn (string $p) => static::absoluteMediaUrl($p), $paths)));
    }

    /**
     * @return list<string>
     */
    protected function relationalGalleryPathsOrdered(): array
    {
        if ($this->relationLoaded('galleryImages')) {
            return $this->galleryImages
                ->pluck('path')
                ->filter(fn ($p) => is_string($p) && $p !== '')
                ->values()
                ->all();
        }

        if (! $this->exists) {
            return [];
        }

        return $this->galleryImages()
            ->pluck('path')
            ->filter(fn ($p) => is_string($p) && $p !== '')
            ->values()
            ->all();
    }

    public function getDetailHrefAttribute(): string
    {
        return '/works/' . $this->slug;
    }
}
