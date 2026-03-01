<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('event_id')
                    ->relationship('event', 'title')
                    ->required(),
                TextInput::make('contact_name')
                    ->required(),
                TextInput::make('contact_email')
                    ->email()
                    ->required(),
                Select::make('status')
                    ->options(['CONFIRMED' => 'C o n f i r m e d', 'CANCELED' => 'C a n c e l e d'])
                    ->default('CONFIRMED')
                    ->required(),
            ]);
    }
}
