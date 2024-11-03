<?php

namespace App\Filament\Resources\TrafficSignResource\Pages;

use App\Filament\Resources\TrafficSignResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrafficSigns extends ListRecords
{
    protected static string $resource = TrafficSignResource::class;
    protected static ?string $title = 'Daftar Rambu Lalulintas';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Buat Data Baru'),
        ];
    }
}
