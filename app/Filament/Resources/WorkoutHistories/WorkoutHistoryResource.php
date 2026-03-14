<?php

namespace App\Filament\Resources\WorkoutHistories;

use App\Filament\Resources\WorkoutHistories\Pages\CreateWorkoutHistory;
use App\Filament\Resources\WorkoutHistories\Pages\EditWorkoutHistory;
use App\Filament\Resources\WorkoutHistories\Pages\ListWorkoutHistories;
use App\Filament\Resources\WorkoutHistories\Schemas\WorkoutHistoryForm;
use App\Filament\Resources\WorkoutHistories\Tables\WorkoutHistoriesTable;
use App\Models\WorkoutHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WorkoutHistoryResource extends Resource
{
    protected static ?string $model = WorkoutHistory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Workout History';

    public static function form(Schema $schema): Schema
    {
        return WorkoutHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkoutHistoriesTable::configure($table);
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
            'index' => ListWorkoutHistories::route('/'),
            'create' => CreateWorkoutHistory::route('/create'),
            'edit' => EditWorkoutHistory::route('/{record}/edit'),
        ];
    }
}
