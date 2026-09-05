<?php

namespace App\Filament\Admin\Resources\Blogs\Schemas;

use App\Filament\Support\AvifFileUpload;
use App\Enums\BlogStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, ?string $state, Set $set): void {
                        if ($operation === 'create' && $state) {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Auto-generated from title. Used in the public URL.'),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        BlogStatus::Draft->value     => BlogStatus::Draft->label(),
                        BlogStatus::Published->value => BlogStatus::Published->label(),
                    ])
                    ->default(BlogStatus::Draft->value)
                    ->required(),

                DateTimePicker::make('published_at')
                    ->label('Publish Date')
                    ->nullable()
                    ->helperText('Leave blank to publish immediately when status is Published.'),

                TextInput::make('author')
                    ->label('Author')
                    ->required()
                    ->default('Ramil Veliiev')
                    ->maxLength(100),

                TextInput::make('category')
                    ->label('Category')
                    ->required()
                    ->default('YouTube')
                    ->maxLength(100),

                TextInput::make('video_url')
                    ->label('YouTube Video URL')
                    ->url()
                    ->nullable()
                    ->maxLength(500)
                    ->placeholder('https://www.youtube.com/watch?v=...')
                    ->columnSpanFull(),

                FileUpload::make('image_path')
                    ->label('Featured Image')
                    ->image()
                    ->disk('public')
                    ->directory('blogs')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->nullable()
                    ->tap(fn (FileUpload $field) => AvifFileUpload::configure($field))
                    ->columnSpanFull(),

                Textarea::make('excerpt')
                    ->label('Excerpt / Summary')
                    ->nullable()
                    ->rows(3)
                    ->maxLength(1000)
                    ->helperText('Short summary shown on the blog detail page.')
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->label('Full Content')
                    ->nullable()
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'h2', 'h3',
                        'bulletList', 'orderedList', 'blockquote',
                        'link', 'redo', 'undo',
                    ])
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
            ]);
    }
}
