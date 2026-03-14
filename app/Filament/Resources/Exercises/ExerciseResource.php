<?php

namespace App\Filament\Resources\Exercises;

use App\Filament\Resources\Exercises\Pages\CreateExercise;
use App\Filament\Resources\Exercises\Pages\EditExercise;
use App\Filament\Resources\Exercises\Pages\ListExercises;
use App\Filament\Resources\Exercises\Schemas\ExerciseForm;
use App\Filament\Resources\Exercises\Tables\ExercisesTable;
use App\Models\Exercise;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ExerciseResource extends Resource
{
    protected static ?string $model = Exercise::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Exercise';

    public static function table(Table $table): Table
    {
        return ExercisesTable::configure($table);
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
            'index' => ListExercises::route('/'),
            'create' => CreateExercise::route('/create'),
            'edit' => EditExercise::route('/{record}/edit'),
        ];
    }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('level_id')
                    ->relationship('level', 'name')
                    ->label('Progressive Level'),


                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Exercise Name'),


                TextInput::make('target_sets')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->label('Target Sets'),


                TextInput::make('target_reps')
                    ->numeric()
                    ->nullable()
                    ->label('Target Reps'),


                Textarea::make('description')
                    ->columnSpanFull()
                    ->label('Exercise Guide'),

              
                TextInput::make('media_url')
                    ->url()
                    ->nullable()
                    ->label('Media URL'),
            ]);
    }
}
