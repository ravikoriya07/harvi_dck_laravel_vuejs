<?php

namespace App\Filament\Admin\Resources\LegalPages\Pages;

use App\Filament\Admin\Resources\LegalPages\LegalPageResource;
use App\Filament\Admin\Resources\LegalPages\Tables\LegalPagesTable;
use Filament\Resources\Pages\EditRecord;

class EditLegalPage extends EditRecord
{
    protected static string $resource = LegalPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LegalPagesTable::viewPageAction(),
        ];
    }
}
