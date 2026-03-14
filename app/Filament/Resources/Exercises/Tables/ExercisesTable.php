<?php

namespace App\Filament\Resources\Exercises\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExercisesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Exercise Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('level.name')
                    ->label('Level')
                    ->sortable()
                    ->badge(),

                TextColumn::make('target_sets')
                    ->label('Target Sets')
                    ->sortable(),

                TextColumn::make('target_reps')
                    ->label('Target Reps')
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
