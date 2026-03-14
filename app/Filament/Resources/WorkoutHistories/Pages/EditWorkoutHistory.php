<?php

namespace App\Filament\Resources\WorkoutHistories\Pages;

use App\Filament\Resources\WorkoutHistories\WorkoutHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkoutHistory extends EditRecord
{
    protected static string $resource = WorkoutHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
