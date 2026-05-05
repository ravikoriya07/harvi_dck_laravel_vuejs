<?php

namespace App\Filament\Admin\Resources\JobApplications;

use App\Filament\Admin\Resources\JobApplications\Pages\ListJobApplications;
use App\Filament\Admin\Resources\JobApplications\Pages\ViewJobApplication;
use App\Filament\Admin\Resources\JobApplications\Schemas\JobApplicationInfolist;
use App\Filament\Admin\Resources\JobApplications\Tables\JobApplicationsTable;
use App\Models\JobApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Job application';

    protected static ?string $pluralModelLabel = 'Job applications';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Jobs';

    protected static ?int $navigationSort = 35;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('job');
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobApplications::route('/'),
            'view' => ViewJobApplication::route('/{record}'),
        ];
    }
}
