<?php

namespace App\Filament\Admin\Resources\JobApplications\Pages;

use App\Filament\Admin\Resources\JobApplications\JobApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJobApplication extends ViewRecord
{
    protected static string $resource = JobApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
