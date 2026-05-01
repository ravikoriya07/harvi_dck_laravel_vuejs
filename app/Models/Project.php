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
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /**
     * Public URL for the listing thumbnail: absolute /assets paths, full URLs, or storage-relative paths.
     */
    public function getImageUrlAttribute(): string
    {
        $image = $this->image ?? '';

        if ($image === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $image)) {
            return $image;
        }

        if (str_starts_with($image, '/')) {
            return $image;
        }

        return asset('storage/'.$image);
    }

    public function getDetailHrefAttribute(): string
    {
        return '/works/'.$this->slug;
    }
}
