<?php

namespace App\Filament\Admin\Resources\JobCategories\Pages;

use App\Filament\Admin\Resources\JobCategories\JobCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJobCategory extends ViewRecord
{
    protected static string $resource = JobCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
