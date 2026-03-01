<?php

namespace App\Filament\Resources\Guests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GuestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('registration_id')
                    ->relationship('registration', 'registration_id')
                    ->required(),
                TextInput::make('invited_by_id')
                    ->numeric(),
                TextInput::make('full_name')
                    ->required(),
                TextInput::make('dietary_notes'),
                Toggle::make('is_primary')
                    ->required(),
            ]);
    }
}
