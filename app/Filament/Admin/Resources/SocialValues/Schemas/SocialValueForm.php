<?php

namespace App\Filament\Admin\Resources\SocialValues\Schemas;

use App\Filament\Support\ManagedImageUpload;
use App\Models\SocialValue;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SocialValueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                        if ($operation !== 'create') {
                            return;
                        }
                        $set('slug', Str::slug($state ?? ''));
                    }),

                TextInput::make('slug')
                    ->required()
                    ->unique(SocialValue::class, 'slug', ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Detail page URL: /social-values/{slug}'),

                TextInput::make('category')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Community, Sustainability'),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Lower numbers appear first on the listing.'),

                ManagedImageUpload::configure(
                    FileUpload::make('image')
                        ->label('Thumbnail Image')
                        ->image()
                        ->disk('public')
                        ->directory('social-values')
                        ->imageEditor()
                        ->maxSize(5120)
                        ->helperText('Upload the thumbnail. Images are stored as AVIF automatically.')
                        ->columnSpanFull(),
                ),

                TextInput::make('value')
                    ->label('Value')
                    ->maxLength(255)
                    ->placeholder('e.g. £3.5 million')
                    ->helperText('Displayed in the properties bar on the detail page.'),

                TextInput::make('date')
                    ->label('Date')
                    ->maxLength(255)
                    ->placeholder('e.g. November 2023'),

                TextInput::make('status')
                    ->label('Status')
                    ->maxLength(255)
                    ->placeholder('e.g. Completed in 2024'),

                TextInput::make('client')
                    ->label('Client')
                    ->maxLength(255)
                    ->placeholder('e.g. London Borough of Haringey'),

                Textarea::make('scope')
                    ->label('Scope Summary')
                    ->rows(3)
                    ->maxLength(1000)
                    ->helperText('Short one-line scope shown prominently under the gallery.')
                    ->columnSpanFull(),

                RichEditor::make('description')
                    ->label('Description')
                    ->nullable()
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'h2', 'h3',
                        'bulletList', 'orderedList', 'blockquote',
                        'link', 'redo', 'undo',
                    ])
                    ->helperText('Full description shown on the detail page.')
                    ->columnSpanFull(),
            ]);
    }
}
