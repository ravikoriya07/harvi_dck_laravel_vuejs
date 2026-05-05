<?php

namespace App\Filament\Admin\Resources\JobApplications\Tables;

use App\Models\JobApplication;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job.title')
                    ->label('Job title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('name')
                    ->label('Applicant name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('resume_original_name')
                    ->label('Resume')
                    ->formatStateUsing(fn (string $state): string => 'View Resume')
                    ->url(fn (JobApplication $record): string => route('admin.job-applications.resume.download', $record))
                    ->openUrlInNewTab(),

                TextColumn::make('created_at')
                    ->label('Submitted date')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('job_id')
                    ->label('Job')
                    ->relationship('job', 'title')
                    ->searchable()
                    ->preload(),
                Filter::make('submitted_date')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('To'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
