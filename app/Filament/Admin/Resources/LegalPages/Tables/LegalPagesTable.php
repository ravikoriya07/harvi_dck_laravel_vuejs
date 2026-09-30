<?php

namespace App\Filament\Admin\Resources\LegalPages\Tables;

use App\Models\LegalPage;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LegalPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('path')
                    ->label('Public URL')
                    ->url(fn (LegalPage $record): string => url($record->path), shouldOpenInNewTab: true)
                    ->color('primary'),

                TextColumn::make('last_updated_at')
                    ->label('Last updated (shown on page)')
                    ->date('j M Y')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Last edited')
                    ->since()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('title')
            ->paginated(false)
            ->recordActions([
                self::viewPageAction(),
                EditAction::make(),
            ]);
    }

    public static function viewPageAction(): Action
    {
        return Action::make('viewPage')
            ->label('View page')
            ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
            ->color('gray')
            ->url(fn (LegalPage $record): string => url($record->path), shouldOpenInNewTab: true);
    }
}
