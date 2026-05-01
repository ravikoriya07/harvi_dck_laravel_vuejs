<?php

namespace App\Filament\Admin\Resources\ContactCards\Pages;

use App\Filament\Admin\Resources\ContactCards\ContactCardResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactCard extends CreateRecord
{
    protected static string $resource = ContactCardResource::class;
}
