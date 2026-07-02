<?php

namespace App\Filament\Admin\Resources\Services\Schemas;

use App\Filament\Support\ManagedImageUpload;
use App\Models\Service;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(debounce: 400)
                    ->afterStateUpdated(function (string $operation, ?string $state, Set $set): void {
                        if ($operation === 'create' && filled($state)) {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(Service::class, 'slug', ignoreRecord: true)
                    ->alphaDash()
                    ->helperText('Used in the public URL, e.g. /services/general-build'),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Lower numbers appear first on the Services and Home pages.'),

                TextInput::make('image_alt')
                    ->label('Image alt text')
                    ->maxLength(255)
                    ->helperText('Optional. Defaults to the service title.'),

                ManagedImageUpload::configure(
                    FileUpload::make('image')
                        ->label('Service image')
                        ->image()
                        ->disk('public')
                        ->directory('services')
                        ->imageEditor()
                        ->maxSize(5120)
                        ->required()
                        ->helperText('Shown on the Services page and Home page carousel.')
                        ->columnSpanFull(),
                ),

                Textarea::make('description')
                    ->required()
                    ->rows(5)
                    ->maxLength(5000)
                    ->helperText('Shown on the Services page and in the Home page carousel hover overlay.')
                    ->columnSpanFull(),
            ]);
    }
}
