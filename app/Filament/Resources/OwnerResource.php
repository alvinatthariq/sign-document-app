<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Models\Owner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\ViewField;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Component;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Components\Section;



class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('employee_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('position')
                    ->required()
                    ->maxLength(255),
                ViewField::make('signature')
                    ->view('forms.components.range-slider')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('employee_number')->searchable(),
                Tables\Columns\TextColumn::make('position')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Info')->schema([
                    Infolists\Components\TextEntry::make('name'),
                    Infolists\Components\TextEntry::make('employee_number'),
                    Infolists\Components\TextEntry::make('position'),
                ]),
                Section::make('General')->schema([
                    ViewEntry::make('status')
                    ->view('forms.components.document-preview')
                ]),
            ]);
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
            'index' => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'edit' => Pages\EditOwner::route('/{record}/edit'),
        ];
    }
}
