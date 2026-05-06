<?php

namespace App\Filament\Admin\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
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
                    ->unique(Project::class, 'slug', ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Detail page URL: /works/{slug}'),

                TextInput::make('category')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Construction, Refurbishment'),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Lower numbers appear first on the listing.'),

                TextInput::make('image')
                    ->label('Thumbnail Image')
                    ->required()
                    ->maxLength(2048)
                    ->helperText('Public path (e.g. /assets/images/...) or full URL.')
                    ->columnSpanFull(),

                // ── Detail page fields ───────────────────────────────────────────

                TextInput::make('value')
                    ->label('Project Value')
                    ->maxLength(255)
                    ->placeholder('e.g. £3.5 million')
                    ->helperText('Displayed in the properties bar on the detail page.'),

                TextInput::make('date')
                    ->label('Project Date')
                    ->maxLength(255)
                    ->placeholder('e.g. November 2023'),

                TextInput::make('status')
                    ->label('Project Status')
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

                Textarea::make('description')
                    ->label('Project Description (HTML)')
                    ->rows(12)
                    ->helperText('Full project description. HTML tags are supported (e.g. <h3>, <p>).')
                    ->columnSpanFull(),

                Textarea::make('gallery')
                    ->label('Gallery Images')
                    ->rows(6)
                    ->helperText('Enter one image path per line (e.g. /assets/images/photo.jpg). These appear in the detail-page carousel.')
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n", $state) : '')
                    ->dehydrateStateUsing(
                        fn ($state) => array_values(
                            array_filter(array_map('trim', explode("\n", $state ?? '')))
                        )
                    )
                    ->columnSpanFull(),
            ]);
    }
}
