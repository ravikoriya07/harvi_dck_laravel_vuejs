<?php

namespace App\Filament\Admin\Resources\ContactCards\Schemas;

use App\Filament\Support\AvifFileUpload;
use App\Models\ContactCard;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ContactCardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('profile_image')
                    ->label('Profile Image')
                    ->image()
                    ->disk('public')
                    ->directory('contact-cards')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->tap(fn (FileUpload $field) => AvifFileUpload::configure($field))
                    ->required(),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                        if ($operation !== 'create') {
                            return;
                        }
                        $set('slug', Str::slug($state ?? '', '_'));
                    }),

                TextInput::make('designation')
                    ->required()
                    ->maxLength(255),

                TextInput::make('company_name')
                    ->label('Company Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->required()
                    ->maxLength(50),

                TextInput::make('website')
                    ->url()
                    ->required()
                    ->maxLength(255),

                Textarea::make('office_address')
                    ->label('Office Address')
                    ->rows(3)
                    ->required(),

                TextInput::make('slug')
                    ->required()
                    ->unique(ContactCard::class, 'slug', ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Auto-generated from name. Lowercase letters, numbers, hyphens, and underscores only.')
                    ->rules(['regex:/^[a-z0-9_-]+$/']),
            ]);
    }
}
