<?php

namespace App\Filament\Resources\Invits;

use App\Filament\Resources\Invits\Pages\CreateInvit;
use App\Filament\Resources\Invits\Pages\EditInvit;
use App\Filament\Resources\Invits\Pages\ListInvits;
use App\Filament\Resources\Invits\Schemas\InvitForm;
use App\Filament\Resources\Invits\Tables\InvitsTable;
use App\Models\Invit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvitResource extends Resource
{
    protected static ?string $model = Invit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return InvitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvits::route('/'),
            'create' => CreateInvit::route('/create'),
            'edit' => EditInvit::route('/{record}/edit'),
        ];
    }
}