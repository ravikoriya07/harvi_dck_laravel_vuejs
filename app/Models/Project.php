<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'gallery',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'gallery'    => 'array',
        ];
    }

    /**
     * Public URL for the listing thumbnail.
     */
    public function getImageUrlAttribute(): string
    {
        return $this->resolveUrl($this->image ?? '');
    }

    /**
     * Array of public URLs for the gallery carousel.
     * Falls back to the main image when gallery is empty.
     */
    public function getGalleryUrlsAttribute(): array
    {
        $paths = $this->gallery ?? [];

        if (empty($paths) && ($this->image ?? '') !== '') {
            $paths = [$this->image];
        }

        return array_values(array_filter(array_map(fn (string $p) => $this->resolveUrl($p), $paths)));
    }

    public function getDetailHrefAttribute(): string
    {
        return '/works/' . $this->slug;
    }

    private function resolveUrl(string $path): string
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
}
