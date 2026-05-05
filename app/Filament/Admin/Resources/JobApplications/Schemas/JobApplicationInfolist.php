<?php

namespace App\Filament\Admin\Resources\JobApplications\Schemas;

use App\Models\JobApplication;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JobApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('job.title')
                    ->label('Job title')
                    ->columnSpanFull(),

                TextEntry::make('name')
                    ->label('Applicant name'),

                TextEntry::make('email')
                    ->copyable(),

                TextEntry::make('phone'),

                TextEntry::make('created_at')
                    ->label('Submitted date')
                    ->dateTime('d M Y, h:i A'),

                TextEntry::make('resume_original_name')
                    ->label('Resume')
                    ->formatStateUsing(fn (string $state): string => $state)
                    ->url(fn (JobApplication $record): string => route('admin.job-applications.resume.download', $record))
                    ->openUrlInNewTab()
                    ->columnSpanFull(),

                TextEntry::make('cover_letter')
                    ->label('Cover letter')
                    ->columnSpanFull()
                    ->placeholder('—'),
            ]);
    }
}
