<?php

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Project::query()->orderBy('id')->each(function (Project $project): void {
            $raw = $project->getAttributes()['gallery'] ?? null;
            $decoded = json_decode(is_string($raw) ? $raw : 'null', true);

            if (! is_array($decoded)) {
                $decoded = [];
            }

            $paths = [];

            foreach ($decoded as $path) {
                if (is_string($path) && $path !== '') {
                    $paths[] = $path;
                }
            }

            ProjectImage::syncOrderedPathsForProject($project->id, $paths);
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn('gallery');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->json('gallery')->nullable()->after('description');
        });

        Project::query()->with(['galleryImages' => fn ($q) => $q->orderBy('sort_order')->orderBy('id')])->each(function (Project $project): void {
            $paths = $project->galleryImages->pluck('path')->filter(fn ($p) => is_string($p) && $p !== '')->values()->all();

            DB::table('projects')->where('id', $project->id)->update([
                'gallery' => json_encode(array_values($paths)),
            ]);
        });
    }
};
