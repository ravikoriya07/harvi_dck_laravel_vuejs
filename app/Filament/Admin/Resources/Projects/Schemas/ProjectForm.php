<?php

namespace App\Filament\Admin\Resources\Projects\Schemas;

use App\Models\Project;
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
                    ->helperText('Used in the future project detail URL: /works/{slug}'),

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
                    ->label('Image')
                    ->required()
                    ->maxLength(2048)
                    ->helperText('Public site path (e.g. /assets/images/...) or full URL. Upload files into public/ or storage via your usual workflow, then paste the path here.')
                    ->columnSpanFull(),
            ]);
    }
}
