<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Traffic_sign;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TrafficSignResource\Pages;
use App\Filament\Resources\TrafficSignResource\RelationManagers;

class TrafficSignResource extends Resource
{
    protected static ?string $model = Traffic_sign::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'rambu lalulintas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('sign_name')
                    ->label('Nama Rambu')
                    ->helperText('Nama rambu lalulintas')->required()->maxLength(255),

                Select::make('sign_category')->label('kategori')
                    ->options([
                        'Rambu peringatan' => 'Rambu peringatan',
                        'Rambu larangan' => 'Rambu larangan',
                        'Rambu perintah' => 'Rambu perintah',
                        'Rambu petunjuk' => 'Rambu petunjuk',
                    ])
                    ->helperText('Kategori rambu lalulintas')->required(),
                Textarea::make('description')->label('Deskripsi')
                    ->helperText('Deskripsi rambu lalulintas')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('sign_image')->image()->disk('public'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('sign_image'),
                Tables\Columns\TextColumn::make('sign_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sign_category')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTrafficSigns::route('/'),
            'create' => Pages\CreateTrafficSign::route('/create'),
            'edit' => Pages\EditTrafficSign::route('/{record}/edit'),
        ];
    }
}
