<?php

namespace App\Console\Commands;

use App\Services\AvifConversionService;
use App\Services\ImageReferenceUpdater;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConvertImagesToAvif extends Command
{
    protected $signature = 'images:convert-avif
                            {--homepage-only : Convert only homepage static images}
                            {--path= : Convert a single file or directory (relative to project root)}
                            {--dry-run : Report actions without writing files or updating references}
                            {--skip-references : Convert files only; do not update code or database}
                            {--skip-database : Do not update database image path columns}
                            {--keep-originals : Keep source files after conversion (no archive/delete)}';

    protected $description = 'Convert JPG/JPEG/PNG/WebP images to AVIF and update project references';

    public function handle(AvifConversionService $converter, ImageReferenceUpdater $updater): int
    {
        if ($limit = config('images.avif.memory_limit')) {
            ini_set('memory_limit', (string) $limit);
        }

        if (! $converter->isEnabled()) {
            $this->error('AVIF conversion is not available. Ensure PHP GD is compiled with AVIF support.');

            return self::FAILURE;
        }

        $dryRun = (bool) $this->option('dry-run');
        $keepOriginals = (bool) $this->option('keep-originals');

        if ($keepOriginals) {
            config(['images.archive_originals' => false]);
        }

        $files = $this->resolveSourceFiles();

        if ($files === []) {
            $this->warn('No convertible image files found.');

            return self::SUCCESS;
        }

        $this->info(sprintf('Found %d image(s) to process.', count($files)));

        $conversions = [];
        $skipped = [];
        $failed = [];
        $totalSourceBytes = 0;
        $totalDestBytes = 0;

        $bar = $this->output->createProgressBar(count($files));
        $bar->start();

        foreach ($files as $absolutePath) {
            $bar->advance();

            if ($converter->shouldSkipPath($absolutePath)) {
                $skipped[] = $absolutePath;

                continue;
            }

            $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
            if (! $converter->isConvertibleExtension($extension)) {
                $skipped[] = $absolutePath;

                continue;
            }

            $destination = $converter->avifPathFor($absolutePath);

            if ($dryRun) {
                $conversions[] = [
                    'source' => $absolutePath,
                    'destination' => $destination,
                    'source_size' => is_file($absolutePath) ? (int) filesize($absolutePath) : 0,
                    'destination_size' => is_file($destination) ? (int) filesize($destination) : 0,
                ];

                continue;
            }

            if (is_file($destination) && filesize($destination) > 0 && filemtime($destination) >= filemtime($absolutePath)) {
                $conversions[] = [
                    'source' => $absolutePath,
                    'destination' => $destination,
                    'source_size' => (int) filesize($absolutePath),
                    'destination_size' => (int) filesize($destination),
                ];

                if (! $keepOriginals && is_file($absolutePath)) {
                    $converter->archiveAndDeleteOriginal($absolutePath);
                }

                continue;
            }

            $result = $converter->convertAbsolutePath($absolutePath, $destination);

            if ($result === null) {
                $failed[] = $absolutePath;

                continue;
            }

            $conversions[] = $result;
            $totalSourceBytes += $result['source_size'];
            $totalDestBytes += $result['destination_size'];

            if (! $keepOriginals) {
                $converter->archiveAndDeleteOriginal($absolutePath);
            }

            unset($result);
            gc_collect_cycles();
        }

        $bar->finish();
        $this->newLine(2);

        $this->displayConversionSummary($conversions, $skipped, $failed, $totalSourceBytes, $totalDestBytes);

        if ($dryRun) {
            $this->comment('Dry run complete — no files or references were modified.');

            return self::SUCCESS;
        }

        if ($this->option('skip-references') || $conversions === []) {
            return self::SUCCESS;
        }

        $replacements = $updater->buildReplacementMap($conversions);

        $this->info('Updating code references...');
        $fileUpdates = $updater->updateFiles($replacements);

        foreach ($fileUpdates as $update) {
            $this->line("  {$update['file']}: {$update['replacements']} replacement(s)");
        }

        if (! $this->option('skip-database')) {
            $this->info('Updating database image paths...');
            $dbResult = $updater->updateDatabase($replacements);

            foreach ($dbResult['tables'] as $table => $count) {
                $this->line("  {$table}: {$count} row(s) updated");
            }

            if ($dbResult['total'] === 0) {
                $this->line('  No database rows required updates.');
            }
        }

        $this->newLine();
        $this->info('AVIF conversion completed successfully.');

        return self::SUCCESS;
    }

    /**
     * @return list<string>
     */
    private function resolveSourceFiles(): array
    {
        if ($path = $this->option('path')) {
            $absolute = base_path(ltrim((string) $path, '/'));

            if (is_file($absolute)) {
                return [$absolute];
            }

            if (is_dir($absolute)) {
                return $this->collectImagesInDirectory($absolute);
            }

            $this->error("Path not found: {$path}");

            return [];
        }

        if ($this->option('homepage-only')) {
            $converter = app(AvifConversionService::class);
            $files = [];

            foreach (config('images.homepage_images', []) as $webPath) {
                $absolute = $converter->resolvePublicAssetAbsolute($webPath);
                if ($absolute !== null && is_file($absolute)) {
                    $files[] = $absolute;
                }
            }

            return array_values(array_unique($files));
        }

        $files = [];

        foreach (config('images.scan_paths', []) as $relative) {
            $absolute = base_path($relative);

            if (is_dir($absolute)) {
                $files = array_merge($files, $this->collectImagesInDirectory($absolute));
            }
        }

        return array_values(array_unique($files));
    }

    /**
     * @return list<string>
     */
    private function collectImagesInDirectory(string $directory): array
    {
        $extensions = config('images.convertible_extensions', []);
        $files = [];

        foreach (File::allFiles($directory) as $file) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, $extensions, true)) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    /**
     * @param  list<array{source: string, destination: string, source_size: int, destination_size: int}>  $conversions
     * @param  list<string>  $skipped
     * @param  list<string>  $failed
     */
    private function displayConversionSummary(
        array $conversions,
        array $skipped,
        array $failed,
        int $totalSourceBytes,
        int $totalDestBytes,
    ): void {
        $this->table(
            ['Metric', 'Value'],
            [
                ['Converted / existing AVIF', (string) count($conversions)],
                ['Skipped', (string) count($skipped)],
                ['Failed', (string) count($failed)],
                ['Source bytes', $this->formatBytes($totalSourceBytes)],
                ['AVIF bytes', $this->formatBytes($totalDestBytes)],
                ['Reduction', $this->formatReduction($totalSourceBytes, $totalDestBytes)],
            ]
        );

        if ($this->output->isVerbose()) {
            $this->newLine();
            $this->info('Converted files:');

            foreach ($conversions as $conversion) {
                $this->line(sprintf(
                    '  %s → %s (%s → %s)',
                    basename($conversion['source']),
                    basename($conversion['destination']),
                    $this->formatBytes($conversion['source_size']),
                    $this->formatBytes($conversion['destination_size']),
                ));
            }
        }
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        }

        if ($bytes < 1048576) {
            return round($bytes / 1024, 1) . ' KB';
        }

        return round($bytes / 1048576, 2) . ' MB';
    }

    private function formatReduction(int $source, int $dest): string
    {
        if ($source === 0) {
            return 'n/a';
        }

        $pct = round((1 - ($dest / $source)) * 100, 1);

        return $pct . '%';
    }
}
