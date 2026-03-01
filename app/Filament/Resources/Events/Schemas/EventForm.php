<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('organizer_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                DateTimePicker::make('event_date')
                    ->required(),
                TextInput::make('location')
                    ->required(),
                FileUpload::make('image_url')
                    ->image(),
                Select::make('visibility')
                    ->options(['PUBLIC' => 'P u b l i c', 'PRIVATE' => 'P r i v a t e'])
                    ->default('PUBLIC')
                    ->required(),
                TextInput::make('max_capacity')
                    ->numeric(),
                Select::make('status')
                    ->options(['DRAFT' => 'D r a f t', 'PUBLISHED' => 'P u b l i s h e d', 'CANCELLED' => 'C a n c e l l e d'])
                    ->default('DRAFT')
                    ->required(),
            ]);
    }
}
