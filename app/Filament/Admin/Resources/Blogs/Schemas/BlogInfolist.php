<?php

namespace App\Filament\Admin\Resources\Blogs\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BlogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('title')
                    ->label('Title')
                    ->columnSpanFull(),

                TextEntry::make('slug')
                    ->label('Slug'),

                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => $state?->value === 'published' ? 'success' : 'gray'),

                TextEntry::make('author')
                    ->label('Author'),

                TextEntry::make('category')
                    ->label('Category'),

                TextEntry::make('published_at')
                    ->label('Publish Date')
                    ->dateTime()
                    ->placeholder('—'),

                TextEntry::make('video_url')
                    ->label('Video URL')
                    ->placeholder('—')
                    ->columnSpanFull(),

                ImageEntry::make('image_path')
                    ->label('Featured Image')
                    ->disk('public')
                    ->placeholder('No image')
                    ->columnSpanFull(),

                TextEntry::make('excerpt')
                    ->label('Excerpt')
                    ->placeholder('—')
                    ->columnSpanFull(),

                TextEntry::make('content')
                    ->label('Content')
                    ->html()
                    ->placeholder('—')
                    ->columnSpanFull(),

                TextEntry::make('sort_order')
                    ->label('Sort Order'),

                TextEntry::make('created_at')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
