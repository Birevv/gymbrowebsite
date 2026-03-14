<?php

namespace App\Filament\Resources\WorkoutHistories\Pages;

use App\Filament\Resources\WorkoutHistories\WorkoutHistoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkoutHistories extends ListRecords
{
    protected static string $resource = WorkoutHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
