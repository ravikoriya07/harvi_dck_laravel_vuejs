<?php

namespace App\Filament\Admin\Resources\Jobs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JobInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('Title'),

                TextEntry::make('jobCategory.name')
                    ->label('Category')
                    ->placeholder('—'),

                TextEntry::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->placeholder('—'),

                TextEntry::make('created_at')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
