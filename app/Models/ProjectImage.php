<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    protected $fillable = [
        'project_id',
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
        static::creating(function (ProjectImage $image): void {
            if ($image->sort_order !== null) {
                return;
            }

            $max = static::query()->where('project_id', $image->project_id)->max('sort_order');

            $image->sort_order = is_numeric($max) ? ((int) $max + 1) : 0;
        });

        static::deleting(function (ProjectImage $image): void {
            Project::deleteManagedPublicDiskPath($image->path);
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Replace gallery rows for a project from ordered path list (idempotent).
     * Deletes removed paths row-by-row so model events run (disk cleanup).
     *
     * @param  list<string>  $paths
     */
    public static function syncOrderedPathsForProject(int $projectId, array $paths): void
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
            ->where('project_id', $projectId)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('path')
            ->all();

        if ($existingOrdered === $normalized) {
            return;
        }

        if ($normalized === []) {
            foreach (static::query()->where('project_id', $projectId)->orderBy('id')->cursor() as $row) {
                $row->delete();
            }

            return;
        }

        foreach (
            static::query()
                ->where('project_id', $projectId)
                ->whereNotIn('path', $normalized)
                ->orderBy('id')
                ->cursor() as $row
        ) {
            $row->delete();
        }

        foreach ($normalized as $index => $path) {
            static::query()->updateOrCreate(
                [
                    'project_id' => $projectId,
                    'path'       => $path,
                ],
                [
                    'sort_order' => $index,
                ]
            );
        }
    }
}
