<?php

namespace App\Models;

use App\Support\ImagePaths;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'image_alt',
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
        static::saving(function (Service $service): void {
            if (blank($service->slug) && filled($service->title)) {
                $service->slug = Str::slug($service->title);
            }
        });

        static::deleting(function (Service $service): void {
            self::deleteManagedPublicDiskPath($service->image ?? '');
        });
    }

    public static function deleteManagedPublicDiskPath(string $path): void
    {
        if ($path === '' || str_starts_with($path, '/') || preg_match('#\.\.#', $path)) {
            return;
        }

        if (! str_starts_with($path, 'services/')) {
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

    public function getImageUrlAttribute(): string
    {
        return static::absoluteMediaUrl($this->image ?? '');
    }

    public function getDetailHrefAttribute(): string
    {
        return '/services/' . $this->slug;
    }

    /**
     * @return array{title: string, href: string, desc: string, image: string, alt: string}
     */
    public function toListingArray(): array
    {
        return [
            'title' => $this->title,
            'href'  => $this->detail_href,
            'desc'  => $this->description,
            'image' => $this->image_url,
            'alt'   => $this->image_alt ?: $this->title,
        ];
    }
}
