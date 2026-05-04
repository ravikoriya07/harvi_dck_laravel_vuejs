<?php

namespace App\Filament\Admin\Resources\JobCategories\Schemas;

use App\Enums\JobCategoryStatus;
use App\Models\JobCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class JobCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Category name')
                    ->required()
                    ->maxLength(255)
                    ->live(debounce: 400)
                    ->afterStateUpdated(function (string $operation, ?string $state, Set $set): void {
                        $set('slug', Str::slug($state ?? ''));
                    }),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(JobCategory::class, 'slug', ignoreRecord: true)
                    ->alphaDash()
                    ->helperText('Auto-generated from the category name as you type. You can change it; use lowercase letters, numbers, and hyphens only.'),

                Select::make('status')
                    ->label('Status')
                    ->options(collect(JobCategoryStatus::cases())->mapWithKeys(
                        fn (JobCategoryStatus $status): array => [$status->value => $status->label()]
                    ))
                    ->required()
                    ->default(JobCategoryStatus::Active->value)
                    ->native(false),
            ]);
    }
}
