<?php

namespace App\Filament\Admin\Resources\LegalPages;

use App\Filament\Admin\Resources\LegalPages\Pages\EditLegalPage;
use App\Filament\Admin\Resources\LegalPages\Pages\ListLegalPages;
use App\Filament\Admin\Resources\LegalPages\Schemas\LegalPageForm;
use App\Filament\Admin\Resources\LegalPages\Tables\LegalPagesTable;
use App\Models\LegalPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class LegalPageResource extends Resource
{
    protected static ?string $model = LegalPage::class;

    protected static ?string $navigationLabel = 'Legal Pages';

    protected static ?string $modelLabel = 'Legal Page';

    protected static ?string $pluralModelLabel = 'Legal Pages';

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return LegalPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LegalPagesTable::configure($table);
    }

    /** Each page has a fixed public route, so admins edit the seeded rows only. */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLegalPages::route('/'),
            'edit' => EditLegalPage::route('/{record}/edit'),
        ];
    }
}
