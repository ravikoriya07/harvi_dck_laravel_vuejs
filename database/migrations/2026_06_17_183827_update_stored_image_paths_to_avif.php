<?php

use App\Support\ImagePaths;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        foreach (config('images.database_columns', []) as $entry) {
            $table = $entry['table'];
            $column = $entry['column'];

            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
                continue;
            }

            foreach (DB::table($table)->whereNotNull($column)->orderBy('id')->cursor() as $row) {
                $original = (string) $row->{$column};

                if ($original === '' || str_ends_with(strtolower($original), '.avif')) {
                    continue;
                }

                $candidate = ImagePaths::toAvif($original);

                if (! $this->avifExistsForPath($candidate) || $candidate === $original) {
                    continue;
                }

                DB::table($table)->where('id', $row->id)->update([$column => $candidate]);
            }
        }
    }

    public function down(): void
    {
        // Irreversible: original raster files may have been archived or removed after conversion.
    }

    private function avifExistsForPath(string $path): bool
    {
        if (str_starts_with($path, '/assets/')) {
            return is_file(public_path(ltrim($path, '/')));
        }

        if (str_starts_with($path, '/storage/')) {
            $relative = ltrim(substr($path, strlen('/storage/')), '/');

            return Storage::disk('public')->exists($relative);
        }

        if (! str_starts_with($path, '/') && ! preg_match('#^https?://#i', $path)) {
            return Storage::disk('public')->exists(ltrim($path, '/'));
        }

        return false;
    }
};
