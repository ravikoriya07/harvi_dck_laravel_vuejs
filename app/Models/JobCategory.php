<?php

namespace App\Models;

use App\Enums\JobCategoryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => JobCategoryStatus::class,
        ];
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'job_category_id');
    }

    protected static function booted(): void
    {
        static::saving(function (JobCategory $category): void {
            if (blank($category->slug) && filled($category->name)) {
                $category->slug = Str::slug($category->name);

                return;
            }

            if (filled($category->slug)) {
                $category->slug = Str::slug($category->slug);
            }
        });
    }
}
