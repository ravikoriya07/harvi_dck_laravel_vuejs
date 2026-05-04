<?php

namespace App\Filament\Admin\Resources\Jobs;

use App\Filament\Admin\Resources\Jobs\Pages\CreateJob;
use App\Filament\Admin\Resources\Jobs\Pages\EditJob;
use App\Filament\Admin\Resources\Jobs\Pages\ListJobs;
use App\Filament\Admin\Resources\Jobs\Pages\ViewJob;
use App\Filament\Admin\Resources\Jobs\Schemas\JobForm;
use App\Filament\Admin\Resources\Jobs\Schemas\JobInfolist;
use App\Filament\Admin\Resources\Jobs\Tables\JobsTable;
use App\Models\Job;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Job listing';

    protected static ?string $pluralModelLabel = 'Job listings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|UnitEnum|null $navigationGroup = 'Jobs';

    protected static ?int $navigationSort = 25;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('jobCategory');
    }

    public static function form(Schema $schema): Schema
    {
        return JobForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobs::route('/'),
            'create' => CreateJob::route('/create'),
            'view' => ViewJob::route('/{record}'),
            'edit' => EditJob::route('/{record}/edit'),
        ];
    }
}
