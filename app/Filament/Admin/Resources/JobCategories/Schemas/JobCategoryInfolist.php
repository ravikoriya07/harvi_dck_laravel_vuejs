<?php

namespace App\Filament\Admin\Resources\JobCategories\Schemas;

use App\Enums\JobCategoryStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JobCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Category name'),

                TextEntry::make('slug')
                    ->copyable(),

                TextEntry::make('status')
                    ->badge()
                    ->formatStateUsing(fn (JobCategoryStatus $state): string => $state->label())
                    ->color(fn (JobCategoryStatus $state): string => match ($state) {
                        JobCategoryStatus::Active => 'success',
                        JobCategoryStatus::Inactive => 'gray',
                    }),

                TextEntry::make('created_at')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
