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
}
