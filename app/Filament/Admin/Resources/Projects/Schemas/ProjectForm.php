<?php

namespace App\Filament\Admin\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Forms\Components\FileUpload;
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

                // ── Thumbnail image ───────────────────────────────────────────────
                FileUpload::make('image')
                    ->label('Thumbnail Image')
                    ->image()
                    ->disk('public')
                    ->directory('projects')
                    ->imageEditor()
                    ->maxSize(5120)
                    ->helperText('Upload the project thumbnail. Existing /assets/ paths continue to work on the frontend until replaced here.')
                    ->formatStateUsing(function ($state) {
                        // Legacy absolute paths (/assets/...) are not on the public disk,
                        // so return null to avoid broken preview; they still work on the frontend.
                        if (is_string($state) && str_starts_with($state, '/')) {
                            return null;
                        }
                        return $state;
                    })
                    ->dehydrateStateUsing(function (?string $state, ?Project $record): ?string {
                        // Preserve existing path when no new file is uploaded.
                        return $state ?? $record?->image;
                    })
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
            ]);
    }
}
