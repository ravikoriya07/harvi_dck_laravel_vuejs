<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialValueImage extends Model
{
    protected $fillable = [
        'social_value_id',
        'path',
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
        static::creating(function (SocialValueImage $image): void {
            if ($image->sort_order !== null) {
                return;
            }

            $max = static::query()->where('social_value_id', $image->social_value_id)->max('sort_order');

            $image->sort_order = is_numeric($max) ? ((int) $max + 1) : 0;
        });

        static::deleting(function (SocialValueImage $image): void {
            SocialValue::deleteManagedPublicDiskPath($image->path);
        });
    }

    public function socialValue(): BelongsTo
    {
        return $this->belongsTo(SocialValue::class);
    }

    /**
     * Replace gallery rows for a social value from ordered path list (idempotent).
     * Deletes removed paths row-by-row so model events run (disk cleanup).
     *
     * @param  list<string>  $paths
     */
    public static function syncOrderedPathsForSocialValue(int $socialValueId, array $paths): void
    {
        $normalized = [];
        $seen = [];

        foreach ($paths as $path) {
            if (! is_string($path) || $path === '') {
                continue;
            }

            if (isset($seen[$path])) {
                continue;
            }

            $seen[$path] = true;
            $normalized[] = $path;
        }

        $existingOrdered = static::query()
            ->where('social_value_id', $socialValueId)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('path')
            ->all();

        if ($existingOrdered === $normalized) {
            return;
        }

        if ($normalized === []) {
            foreach (static::query()->where('social_value_id', $socialValueId)->orderBy('id')->cursor() as $row) {
                $row->delete();
            }

            return;
        }

        foreach (
            static::query()
                ->where('social_value_id', $socialValueId)
                ->whereNotIn('path', $normalized)
                ->orderBy('id')
                ->cursor() as $row
        ) {
            $row->delete();
        }

        foreach ($normalized as $index => $path) {
            static::query()->updateOrCreate(
                [
                    'social_value_id' => $socialValueId,
                    'path'            => $path,
                ],
                [
                    'sort_order' => $index,
                ]
            );
        }
    }
}
