<?php

namespace App\Filament\Admin\Resources\ContactCards;

use App\Filament\Admin\Resources\ContactCards\Pages\CreateContactCard;
use App\Filament\Admin\Resources\ContactCards\Pages\EditContactCard;
use App\Filament\Admin\Resources\ContactCards\Pages\ListContactCards;
use App\Filament\Admin\Resources\ContactCards\Schemas\ContactCardForm;
use App\Filament\Admin\Resources\ContactCards\Tables\ContactCardsTable;
use App\Models\ContactCard;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ContactCardResource extends Resource
{
    protected static ?string $model = ContactCard::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static string|UnitEnum|null $navigationGroup = 'Contact Cards';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return ContactCardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactCardsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactCards::route('/'),
            'create' => CreateContactCard::route('/create'),
            'edit' => EditContactCard::route('/{record}/edit'),
        ];
    }
}
