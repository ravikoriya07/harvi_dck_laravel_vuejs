<?php

namespace App\Filament\Admin\Resources\JobCategories\Pages;

use App\Filament\Admin\Resources\JobCategories\JobCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJobCategories extends ListRecords
{
    protected static string $resource = JobCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
