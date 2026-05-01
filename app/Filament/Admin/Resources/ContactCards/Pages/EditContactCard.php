<?php

namespace App\Filament\Admin\Resources\ContactCards\Pages;

use App\Filament\Admin\Resources\ContactCards\ContactCardResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactCard extends EditRecord
{
    protected static string $resource = ContactCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
