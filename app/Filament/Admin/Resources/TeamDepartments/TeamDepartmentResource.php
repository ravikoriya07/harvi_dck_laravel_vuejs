<?php

namespace App\Filament\Admin\Resources\TeamDepartments;

use App\Filament\Admin\Resources\TeamDepartments\Pages\CreateTeamDepartment;
use App\Filament\Admin\Resources\TeamDepartments\Pages\EditTeamDepartment;
use App\Filament\Admin\Resources\TeamDepartments\Pages\ListTeamDepartments;
use App\Filament\Admin\Resources\TeamDepartments\Schemas\TeamDepartmentForm;
use App\Filament\Admin\Resources\TeamDepartments\Tables\TeamDepartmentsTable;
use App\Models\TeamDepartment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TeamDepartmentResource extends Resource
{
    protected static ?string $model = TeamDepartment::class;

    protected static ?string $navigationLabel = 'Team Groups';

    protected static ?string $modelLabel = 'Team Group';

    protected static ?string $pluralModelLabel = 'Team Groups';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 21;

    public static function form(Schema $schema): Schema
    {
        return TeamDepartmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeamDepartmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeamDepartments::route('/'),
            'create' => CreateTeamDepartment::route('/create'),
            'edit' => EditTeamDepartment::route('/{record}/edit'),
        ];
    }
}
