<?php

namespace App\Filament\Admin\Resources\JobCategories;

use App\Filament\Admin\Resources\JobCategories\Pages\CreateJobCategory;
use App\Filament\Admin\Resources\JobCategories\Pages\EditJobCategory;
use App\Filament\Admin\Resources\JobCategories\Pages\ListJobCategories;
use App\Filament\Admin\Resources\JobCategories\Pages\ViewJobCategory;
use App\Filament\Admin\Resources\JobCategories\Schemas\JobCategoryForm;
use App\Filament\Admin\Resources\JobCategories\Schemas\JobCategoryInfolist;
use App\Filament\Admin\Resources\JobCategories\Tables\JobCategoriesTable;
use App\Models\JobCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JobCategoryResource extends Resource
{
    protected static ?string $model = JobCategory::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = 'Jobs';

    protected static ?int $navigationSort = 15;

    public static function form(Schema $schema): Schema
    {
        return JobCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobCategories::route('/'),
            'create' => CreateJobCategory::route('/create'),
            'view' => ViewJobCategory::route('/{record}'),
            'edit' => EditJobCategory::route('/{record}/edit'),
        ];
    }
}
