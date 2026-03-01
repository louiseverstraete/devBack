<?php

namespace App\Filament\Resources\Invits\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InvitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('event_id')
                    ->relationship('event', 'title')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('name'),
                TextInput::make('token')
                    ->disabled()  
                    ->dehydrated(false)
                    ->default(fn () => \Illuminate\Support\Str::random(64))
                    ->visible(fn ($operation) => $operation === 'edit'),
                DateTimePicker::make('sent_at'),
                DateTimePicker::make('registered_at'),
                DateTimePicker::make('expires_at'),
                Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }
}