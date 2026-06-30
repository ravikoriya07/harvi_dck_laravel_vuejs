<?php

namespace App\Filament\Admin\Resources\SocialValues\RelationManagers;

use App\Filament\Support\AvifFileUpload;
use App\Models\SocialValue;
use App\Models\SocialValueImage;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GalleryImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'galleryImages';

    protected static ?string $title = 'Gallery images';

    protected static bool $shouldSkipAuthorization = true;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('path')
                ->label('Image')
                ->image()
                ->disk('public')
                ->directory('social-values/gallery')
                ->visibility('public')
                ->maxSize(5120)
                ->helperText('Images are stored as AVIF on the public disk and listed on the detail carousel in this order.')
                ->tap(fn (FileUpload $field) => AvifFileUpload::configure($field))
                ->formatStateUsing(function ($state): mixed {
                    if (is_string($state) && str_starts_with($state, '/')) {
                        return null;
                    }

                    return $state;
                })
                ->dehydrateStateUsing(fn (?string $state, ?SocialValueImage $record): ?string => $state ?? $record?->path)
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('path')
            ->columns([
                ImageColumn::make('thumb')
                    ->label('Preview')
                    ->getStateUsing(fn (SocialValueImage $record): string => SocialValue::absoluteMediaUrl($record->path))
                    ->height(56)
                    ->checkFileExistence(false),

                TextColumn::make('path')
                    ->wrap()
                    ->limit(80),

                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
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
