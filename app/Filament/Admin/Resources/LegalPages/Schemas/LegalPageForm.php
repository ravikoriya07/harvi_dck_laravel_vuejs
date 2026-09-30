<?php

namespace App\Filament\Admin\Resources\LegalPages\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LegalPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Page details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Shown in the page banner and the browser tab.'),

                        DatePicker::make('last_updated_at')
                            ->label('Last updated')
                            ->required()
                            ->native(false)
                            ->displayFormat('j F Y')
                            ->helperText('Shown at the top of the page. Change it whenever the policy changes, not for typo fixes.'),

                        Textarea::make('meta_description')
                            ->label('Search engine description')
                            ->rows(2)
                            ->maxLength(160)
                            ->helperText('Optional. Short summary shown in Google search results (up to 160 characters).')
                            ->columnSpanFull(),

                        RichEditor::make('intro')
                            ->label('Introduction')
                            ->toolbarButtons([
                                'bold', 'italic', 'link',
                                'undo', 'redo',
                            ])
                            ->fileAttachments(false)
                            ->helperText('Optional. Shown above the numbered sections.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Sections')
                    ->description('Each section becomes a numbered heading on the page and an entry in its "On this page" menu. Numbers are added automatically. Drag sections to reorder them.')
                    ->schema([
                        Repeater::make('sections')
                            ->hiddenLabel()
                            ->schema([
                                TextInput::make('heading')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Without a number, e.g. "Your rights".'),

                                RichEditor::make('body')
                                    ->label('Content')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold', 'italic', 'underline', 'link',
                                        'h3',
                                        'bulletList', 'orderedList', 'blockquote',
                                        'undo', 'redo',
                                    ])
                                    ->fileAttachments(false),
                            ])
                            ->itemLabel(fn (array $state, ?int $index): string => ($index !== null ? ($index + 1) . '. ' : '')
                                . (filled($state['heading'] ?? null) ? $state['heading'] : 'New section'))
                            ->collapsible()
                            ->collapsed()
                            ->minItems(1)
                            ->addActionLabel('Add section'),
                    ]),
            ]);
    }
}
