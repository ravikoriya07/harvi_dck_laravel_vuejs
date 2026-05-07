<?php

namespace Database\Seeders;

use App\Services\ProjectImageMigrationService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ProjectImageSeeder extends Seeder
{
    /**
     * Copy project thumbnails and gallery assets into storage/app/public/projects/{slug}/,
     * normalize thumbnail paths on Project.image, and update ordered project_images.path rows.
     *
     * Idempotent: skips existing destination files; sync avoids unnecessary DB writes when unchanged.
     */
    public function run(): void
    {
        ProjectImageMigrationService::usingPublicDisk()->migrateAllProjects();

        if (! File::exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }
    }
}
