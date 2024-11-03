<?php

namespace App\Filament\Resources\TrafficSignResource\Pages;

use App\Filament\Resources\TrafficSignResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrafficSign extends EditRecord
{
    protected static string $resource = TrafficSignResource::class;

    protected static ?string $title = 'Edit Data';
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
