<?php

namespace App\Filament\Admin\Resources\SocialValues\Pages;

use App\Filament\Admin\Resources\SocialValues\SocialValueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSocialValues extends ListRecords
{
    protected static string $resource = SocialValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
