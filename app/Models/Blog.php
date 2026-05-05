<?php

namespace App\Models;

use App\Enums\BlogStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image_path',
        'video_url',
        'excerpt',
        'content',
        'author',
        'category',
        'status',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status'       => BlogStatus::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Blog $blog): void {
            if (empty($blog->slug)) {
                $blog->slug = static::uniqueSlug($blog->title);
            }
        });

        static::updating(function (Blog $blog): void {
            if (empty($blog->slug)) {
                $blog->slug = static::uniqueSlug($blog->title, $blog->id);
            }
        });
    }

    protected static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base  = Str::slug($title) ?: 'blog';
        $slug  = $base;
        $count = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', BlogStatus::Published)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        // Paths starting with / are served directly from public/
        if (str_starts_with($this->image_path, '/')) {
            return $this->image_path;
        }

        return Storage::disk('public')->url($this->image_path);
    }

    public function getFormattedDateAttribute(): string
    {
        $date = $this->published_at ?? $this->created_at;

        return $date?->format('d M Y') ?? '';
    }
}
