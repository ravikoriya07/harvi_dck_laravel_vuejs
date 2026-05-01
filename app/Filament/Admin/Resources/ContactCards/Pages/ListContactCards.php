<?php

namespace App\Filament\Admin\Resources\ContactCards\Pages;

use App\Filament\Admin\Resources\ContactCards\ContactCardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactCards extends ListRecords
{
    protected static string $resource = ContactCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
