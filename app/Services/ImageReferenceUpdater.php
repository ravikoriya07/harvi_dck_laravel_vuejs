<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

final class ImageReferenceUpdater
{
    public function __construct(
        private AvifConversionService $converter,
    ) {}

    /**
     * @param  array<string, string>  $replacements  old fragment => new fragment
     * @return list<array{file: string, replacements: int}>
     */
    public function updateFiles(array $replacements, ?array $scanPaths = null): array
    {
        if ($replacements === []) {
            return [];
        }

        $scanPaths ??= config('images.reference_scan_paths', []);
        $updated = [];

        foreach ($scanPaths as $relativePath) {
            $absolute = base_path($relativePath);

            if (is_file($absolute)) {
                $count = $this->replaceInFile($absolute, $replacements);
                if ($count > 0) {
                    $updated[] = ['file' => $relativePath, 'replacements' => $count];
                }

                continue;
            }

            if (! is_dir($absolute)) {
                continue;
            }

            foreach (File::allFiles($absolute) as $file) {
                $ext = strtolower($file->getExtension());
                if (! in_array($ext, ['php', 'vue', 'js', 'css', 'blade.php', 'json'], true)) {
                    continue;
                }

                $path = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $path = str_replace('\\', '/', $path);

                $count = $this->replaceInFile($file->getPathname(), $replacements);
                if ($count > 0) {
                    $updated[] = ['file' => $path, 'replacements' => $count];
                }
            }
        }

        return $updated;
    }

    /**
     * @param  array<string, string>  $replacements
     */
    public function replaceInFile(string $absolutePath, array $replacements): int
    {
        $contents = file_get_contents($absolutePath);
        if ($contents === false) {
            return 0;
        }

        $original = $contents;
        $count = 0;

        foreach ($replacements as $from => $to) {
            $newContents = str_replace($from, $to, $contents, $replaceCount);
            if ($replaceCount > 0) {
                $contents = $newContents;
                $count += $replaceCount;
            }
        }

        if ($contents !== $original) {
            file_put_contents($absolutePath, $contents);
        }

        return $count;
    }

    /**
     * Build replacement map from converted file pairs.
     *
     * @param  list<array{source: string, destination: string}>  $conversions
     * @return array<string, string>
     */
    public function buildReplacementMap(array $conversions): array
    {
        $map = [];

        foreach ($conversions as $conversion) {
            $source = $conversion['source'];
            $destination = $conversion['destination'];

            $sourceBasename = basename($source);
            $destBasename = basename($destination);

            $map[$sourceBasename] = $destBasename;

            $sourceWeb = $this->toWebPath($source);
            $destWeb = $this->toWebPath($destination);

            if ($sourceWeb !== null && $destWeb !== null) {
                $map[$sourceWeb] = $destWeb;
                $map[ltrim($sourceWeb, '/')] = ltrim($destWeb, '/');
                $map['"' . $sourceWeb . '"'] = '"' . $destWeb . '"';
                $map["'" . $sourceWeb . "'"] = "'" . $destWeb . "'";
                $map['url(' . $sourceWeb . ')'] = 'url(' . $destWeb . ')';
                $map['url("' . ltrim($sourceWeb, '/') . '")'] = 'url("' . ltrim($destWeb, '/') . '")';
                $map["url('" . ltrim($sourceWeb, '/') . "')"] = "url('" . ltrim($destWeb, '/') . "')";
                $map['url(' . ltrim($sourceWeb, '/') . ' )'] = 'url(' . ltrim($destWeb, '/') . ' )';
            }
        }

        uksort($map, fn (string $a, string $b): int => strlen($b) <=> strlen($a));

        return $map;
    }

    /**
     * @return array{tables: array<string, int>, total: int}
     */
    public function updateDatabase(array $replacements): array
    {
        $tables = [];
        $total = 0;

        foreach (config('images.database_columns', []) as $entry) {
            $table = $entry['table'];
            $column = $entry['column'];

            if (! $this->tableHasColumn($table, $column)) {
                continue;
            }

            $rows = DB::table($table)->whereNotNull($column)->get([$column, 'id']);

            foreach ($rows as $row) {
                $original = (string) $row->{$column};
                $updated = $this->applyReplacements($original, $replacements);

                if ($updated !== $original) {
                    DB::table($table)->where('id', $row->id)->update([$column => $updated]);
                    $tables[$table] = ($tables[$table] ?? 0) + 1;
                    $total++;
                }
            }
        }

        return ['tables' => $tables, 'total' => $total];
    }

    /**
     * @param  array<string, string>  $replacements
     */
    public function applyReplacements(string $value, array $replacements): string
    {
        foreach ($replacements as $from => $to) {
            $value = str_replace($from, $to, $value);
        }

        return $value;
    }

    private function toWebPath(string $absolutePath): ?string
    {
        $public = str_replace('\\', '/', public_path());
        $storagePublic = str_replace('\\', '/', storage_path('app/public'));
        $normalized = str_replace('\\', '/', $absolutePath);

        if (str_starts_with($normalized, $public . '/')) {
            return '/' . ltrim(substr($normalized, strlen($public)), '/');
        }

        if (str_starts_with($normalized, $storagePublic . '/')) {
            return '/storage/' . ltrim(substr($normalized, strlen($storagePublic)), '/');
        }

        return null;
    }

    private function tableHasColumn(string $table, string $column): bool
    {
        try {
            return DB::getSchemaBuilder()->hasTable($table)
                && DB::getSchemaBuilder()->hasColumn($table, $column);
        } catch (\Throwable) {
            return false;
        }
    }
}
