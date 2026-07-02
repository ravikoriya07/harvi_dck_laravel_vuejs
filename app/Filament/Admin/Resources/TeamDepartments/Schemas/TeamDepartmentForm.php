<?php

namespace App\Filament\Admin\Resources\TeamDepartments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeamDepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Group name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Senior Management Team'),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Lower numbers appear first on the About page.'),
            ]);
    }
}
