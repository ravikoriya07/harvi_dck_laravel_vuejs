<?php

namespace App\Observers;

use App\Models\Blog;
use App\Models\ContactCard;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\SocialValue;
use App\Models\SocialValueImage;
use App\Models\TeamMember;
use App\Services\AvifConversionService;

final class AvifImageObserver
{
    public function __construct(
        private AvifConversionService $converter,
    ) {}

    public function saved(Project|ProjectImage|SocialValue|SocialValueImage|TeamMember|Blog|ContactCard $model): void
    {
        $column = match (true) {
            $model instanceof Project => 'image',
            $model instanceof ProjectImage => 'path',
            $model instanceof SocialValue => 'image',
            $model instanceof SocialValueImage => 'path',
            $model instanceof TeamMember => 'image',
            $model instanceof Blog => 'image_path',
            $model instanceof ContactCard => 'profile_image',
            default => null,
        };

        if ($column === null) {
            return;
        }

        $path = $model->{$column};

        if (! is_string($path) || $path === '' || str_starts_with($path, '/') || preg_match('#^https?://#i', $path)) {
            return;
        }

        if (str_ends_with(strtolower($path), '.avif')) {
            return;
        }

        $avifPath = $this->converter->convertPublicDiskPath($path);

        if ($avifPath === null || $avifPath === $path) {
            return;
        }

        $model->{$column} = $avifPath;
        $model->saveQuietly();
    }
}
