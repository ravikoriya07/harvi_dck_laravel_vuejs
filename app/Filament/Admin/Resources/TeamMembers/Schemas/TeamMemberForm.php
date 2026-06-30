<?php

namespace App\Filament\Admin\Resources\TeamMembers\Schemas;

use App\Filament\Support\ManagedImageUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('position')
                    ->label('Position / Title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Project Manager'),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Lower numbers appear first in the team grid.'),

                ManagedImageUpload::configure(
                    FileUpload::make('image')
                        ->label('Portrait Image')
                        ->image()
                        ->disk('public')
                        ->directory('team-members')
                        ->imageEditor()
                        ->maxSize(5120)
                        ->helperText('Upload a portrait photo. Images are stored as AVIF automatically.')
                        ->columnSpanFull(),
                ),

                Textarea::make('description')
                    ->label('Description (optional)')
                    ->rows(4)
                    ->maxLength(2000)
                    ->helperText('Shown on the card hover overlay when provided.')
                    ->columnSpanFull(),
            ]);
    }
}
