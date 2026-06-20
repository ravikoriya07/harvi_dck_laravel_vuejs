<?php

namespace App\Support;

use Illuminate\Http\Request;

final class PageAssets
{
    /**
     * @return list<string>
     */
    public static function stylesheetsForRequest(Request $request): array
    {
        $path = trim($request->path(), '/');

        foreach (config('page_assets.bundles', []) as $pattern => $files) {
            if ($pattern === '/' && $path === '') {
                return $files;
            }

            if ($pattern !== '/' && $request->is($pattern)) {
                return $files;
            }
        }

        return [];
    }

    /**
     * @return list<array{href: string, media?: string}>
     */
    public static function preloadImagesForRequest(Request $request): array
    {
        $path = trim($request->path(), '/');

        foreach (config('page_assets.preload_images', []) as $pattern => $images) {
            if ($pattern === '/' && $path === '') {
                return $images;
            }

            if ($pattern !== '/' && $request->is($pattern)) {
                return $images;
            }
        }

        return [];
    }

    /**
     * All unique page-specific stylesheet filenames.
     *
     * @return list<string>
     */
    public static function allStylesheetBundles(): array
    {
        $files = [];

        foreach (config('page_assets.bundles', []) as $bundle) {
            foreach ($bundle as $file) {
                $files[$file] = true;
            }
        }

        return array_keys($files);
    }
}
