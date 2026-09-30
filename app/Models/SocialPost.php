<?php

namespace App\Models;

use App\Enums\SocialPlatform;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * A LinkedIn / Instagram post mirrored by `news:sync` for the News page.
 *
 * Rows are owned by the sync: posts removed on the platform are soft-deleted
 * (hidden from the site, kept for audit) and restored if they reappear.
 */
class SocialPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'platform',
        'external_id',
        'permalink',
        'caption',
        'media_type',
        'media_key',
        'image_path',
        'image_source_url',
        'image_alt',
        'content_hash',
        'published_at',
        'source_updated_at',
        'last_synced_at',
    ];

    protected $casts = [
        'platform'          => SocialPlatform::class,
        'published_at'      => 'datetime',
        'source_updated_at' => 'datetime',
        'last_synced_at'    => 'datetime',
    ];

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeNewestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }

    public function scopeForPlatform(Builder $query, SocialPlatform $platform): Builder
    {
        return $query->where('platform', $platform);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Local copy when available; otherwise the last remote URL from the platform
     * (may expire — the News card falls back to a placeholder if it fails).
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            $disk = config('news.media.disk', 'public');

            return $disk === 'public'
                ? asset('storage/' . $this->image_path)
                : Storage::disk($disk)->url($this->image_path);
        }

        return $this->image_source_url ?: null;
    }

    public function getImageAltTextAttribute(): string
    {
        if (filled($this->image_alt)) {
            return Str::limit(trim($this->image_alt), 250);
        }

        $label = "{$this->platform->label()} post by DCK Construction";
        $excerpt = Str::limit(trim(preg_replace('/\s+/u', ' ', (string) $this->caption)), 100);

        return $excerpt !== '' ? "{$label}: {$excerpt}" : $label;
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->published_at?->format('d M Y') ?? '';
    }
}
