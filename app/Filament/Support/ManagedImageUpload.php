<?php

namespace App\Filament\Support;

use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Model;

final class ManagedImageUpload
{
    public static function configure(FileUpload $field, string $column = 'image'): FileUpload
    {
        return $field
            ->tap(fn (FileUpload $upload) => AvifFileUpload::configure($upload))
            ->dehydrateStateUsing(function (?string $state, ?Model $record) use ($column): ?string {
                return $state ?? $record?->getAttribute($column);
            });
    }
}
