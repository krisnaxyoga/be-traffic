<?php

namespace App\Filament\Resources\LevelsResource\Pages;

use App\Filament\Resources\LevelsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLevels extends EditRecord
{
    protected static string $resource = LevelsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
