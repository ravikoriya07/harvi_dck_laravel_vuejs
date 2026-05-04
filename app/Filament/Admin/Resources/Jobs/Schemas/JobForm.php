<?php

namespace App\Filament\Admin\Resources\Jobs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JobForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Slug')
                    ->maxLength(255)
                    ->nullable()
                    ->helperText('Auto-generated from title if left blank. Used in the public URL.'),

                Select::make('job_category_id')
                    ->label('Category')
                    ->relationship('jobCategory', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Select the job category that best describes this role.'),

                Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->rows(10)
                    ->maxLength(65000)
                    ->columnSpanFull(),
            ]);
    }
}
