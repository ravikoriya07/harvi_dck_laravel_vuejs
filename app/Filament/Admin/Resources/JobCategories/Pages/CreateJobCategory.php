<?php

namespace App\Filament\Admin\Resources\JobCategories\Pages;

use App\Filament\Admin\Resources\JobCategories\JobCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJobCategory extends CreateRecord
{
    protected static string $resource = JobCategoryResource::class;
}
