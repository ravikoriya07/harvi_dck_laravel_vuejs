<?php

namespace App\Models;

use Database\Factories\JobFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Job extends Model
{
    /** @use HasFactory<JobFactory> */
    use HasFactory;

    protected $table = 'job_listings';

    /** @var list<string> */
    protected $fillable = [
        'title',
        'slug',
        'job_category_id',
        'description',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Job $job): void {
            if (empty($job->slug)) {
                $job->slug = static::uniqueSlug($job->title);
            }
        });

        static::updating(function (Job $job): void {
            if (empty($job->slug)) {
                $job->slug = static::uniqueSlug($job->title, $job->id);
            }
        });
    }

    protected static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base  = Str::slug($title) ?: 'job';
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

    public function jobCategory(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * HTML for the public job detail page.
     * Rich-editor tags are preserved; text entities like &#039; and &amp; are decoded.
     */
    public function htmlDescription(): string
    {
        $description = $this->description ?? '';

        if (trim($description) === '') {
            return '';
        }

        if ($this->containsHtmlTags($description)) {
            return $this->decodeEntitiesInTextNodes($description);
        }

        $decoded = $this->fullyDecodeEntities($description);

        if ($this->containsHtmlTags($decoded)) {
            return $decoded;
        }

        return nl2br(e($decoded, doubleEncode: false), false);
    }

    /**
     * Plain-text preview for job cards (HTML tags stripped).
     */
    public function plainExcerpt(int $limit = 160): string
    {
        $plain = $this->fullyDecodeEntities(strip_tags($this->description ?? ''));
        $plain = trim((string) preg_replace('/\s+/u', ' ', $plain));

        if ($plain === '' || mb_strlen($plain) <= $limit) {
            return $plain;
        }

        return rtrim(mb_substr($plain, 0, $limit)).'…';
    }

    private function containsHtmlTags(string $value): bool
    {
        return preg_match('/<[a-z][\s\S]*>/i', $value) === 1;
    }

    /**
     * Decode &amp; / &#039; in text only so <p>, <ul>, <a href> stay valid HTML.
     */
    private function decodeEntitiesInTextNodes(string $html): string
    {
        $decoded = preg_replace_callback(
            '/(^|>)([^<]*)(<|$)/',
            fn (array $matches): string => $matches[1].$this->fullyDecodeEntities($matches[2]).$matches[3],
            $html
        );

        return $decoded ?? $html;
    }

    private function fullyDecodeEntities(string $value): string
    {
        $previous = null;
        $decoded = $value;
        $passes = 0;

        while ($decoded !== $previous && $passes < 3) {
            $previous = $decoded;
            $decoded = html_entity_decode($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $passes++;
        }

        return $decoded;
    }
}
