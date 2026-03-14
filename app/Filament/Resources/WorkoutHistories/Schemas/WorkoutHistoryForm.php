<?php

namespace App\Filament\Resources\WorkoutHistories\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WorkoutHistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('User'),

                Select::make('exercise_id')
                    ->relationship('exercise', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Exercise'),

                TextInput::make('completed_sets')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->label('Completed Sets'),

                Select::make('status')
                    ->options([
                        'completed' => 'Completed',
                        'partial' => 'Partial',
                        'skipped' => 'Skipped',
                    ])
                    ->required()
                    ->label('Status'),

                DateTimePicker::make('completed_at')
                    ->label('Completed At')
                    ->default(now()),
            ]);
    }
}
