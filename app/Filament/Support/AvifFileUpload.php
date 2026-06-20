<?php

namespace App\Filament\Support;

use App\Services\AvifConversionService;
use Filament\Forms\Components\BaseFileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

final class AvifFileUpload
{
    public static function configure(BaseFileUpload $field): BaseFileUpload
    {
        return $field->saveUploadedFileUsing(function (BaseFileUpload $component, TemporaryUploadedFile $file): ?string {
            if (! $file->exists()) {
                return null;
            }

            return app(AvifConversionService::class)->storeUploadedAsAvif(
                $file,
                $component->getDirectory() ?? '',
                $component->getDiskName(),
            );
        });
    }
}
