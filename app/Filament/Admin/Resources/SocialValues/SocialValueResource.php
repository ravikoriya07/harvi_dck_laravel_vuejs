<?php

namespace App\Filament\Admin\Resources\SocialValues;

use App\Filament\Admin\Resources\SocialValues\Pages\CreateSocialValue;
use App\Filament\Admin\Resources\SocialValues\Pages\EditSocialValue;
use App\Filament\Admin\Resources\SocialValues\Pages\ListSocialValues;
use App\Filament\Admin\Resources\SocialValues\RelationManagers\GalleryImagesRelationManager;
use App\Filament\Admin\Resources\SocialValues\Schemas\SocialValueForm;
use App\Filament\Admin\Resources\SocialValues\Tables\SocialValuesTable;
use App\Models\SocialValue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SocialValueResource extends Resource
{
    protected static ?string $model = SocialValue::class;

    protected static ?string $navigationLabel = 'Social Values';

    protected static ?string $modelLabel = 'Social Value';

    protected static ?string $pluralModelLabel = 'Social Values';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 21;

    public static function form(Schema $schema): Schema
    {
        return SocialValueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SocialValuesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            GalleryImagesRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSocialValues::route('/'),
            'create' => CreateSocialValue::route('/create'),
            'edit' => EditSocialValue::route('/{record}/edit'),
        ];
    }
}
