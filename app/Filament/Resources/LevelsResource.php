<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelsResource\Pages;
use App\Filament\Resources\LevelsResource\RelationManagers;
use App\Models\Levels;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LevelsResource extends Resource
{
    protected static ?string $model = Levels::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('level_number')->numeric()
                    ->required(),
                Forms\Components\TextInput::make('difficulty')->label('Kesulitan')
                    ->required(),
                Forms\Components\TextInput::make('target_score')->numeric()->required(),
                Forms\Components\Textarea::make('level_desc'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('level_number')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('difficulty')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('target_score')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('level_desc')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevels::route('/create'),
            'edit' => Pages\EditLevels::route('/{record}/edit'),
        ];
    }
}
