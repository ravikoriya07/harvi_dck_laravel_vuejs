<?php

namespace App\Filament\Admin\Resources\Blogs\Tables;

use App\Enums\BlogStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BlogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->width(80)
                    ->height(48)
                    ->defaultImageUrl(null),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('category')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('author')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (BlogStatus $state) => match ($state) {
                        BlogStatus::Published => 'success',
                        BlogStatus::Draft     => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        BlogStatus::Draft->value     => BlogStatus::Draft->label(),
                        BlogStatus::Published->value => BlogStatus::Published->label(),
                    ]),

                SelectFilter::make('category')
                    ->searchable()
                    ->options(fn () => \App\Models\Blog::query()
                        ->distinct()
                        ->orderBy('category')
                        ->pluck('category', 'category')
                        ->toArray()
                    ),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
