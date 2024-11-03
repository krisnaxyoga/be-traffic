<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Questions;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\QuestionsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuestionsResource\RelationManagers;

class QuestionsResource extends Resource
{
    protected static ?string $model = Questions::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'Soal Pertanyaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('id_level')->relationship('level', 'level_number')->searchable()->preload()->required()->label('Level'),
                Select::make('id_sign')->label('rambu lalulintas')->relationship('sign', 'sign_name')->searchable()->preload()->required(),

                Forms\Components\Textarea::make('question_text')
                    ->nullable()
                    ->label('Question Text'),

                Forms\Components\TextInput::make('option_a')
                    ->nullable()
                    ->label('Option A'),

                Forms\Components\TextInput::make('option_b')
                    ->nullable()
                    ->label('Option B'),

                Forms\Components\TextInput::make('option_c')
                    ->nullable()
                    ->label('Option C'),

                Forms\Components\TextInput::make('option_d')
                    ->nullable()
                    ->label('Option D'),

                Forms\Components\Select::make('correct_option')
                    ->options([
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D',
                    ])
                    ->nullable()
                    ->label('Correct Option'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('level.level_number')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('question_text')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('correct_option')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sign.sign_name')->searchable()->sortable(),
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestions::route('/create'),
            'edit' => Pages\EditQuestions::route('/{record}/edit'),
        ];
    }
}
