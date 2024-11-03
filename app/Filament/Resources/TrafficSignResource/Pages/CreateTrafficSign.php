<?php

namespace App\Filament\Resources\TrafficSignResource\Pages;

use App\Filament\Resources\TrafficSignResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrafficSign extends CreateRecord
{
    protected static ?string $title = 'Buat Data';
    protected static string $resource = TrafficSignResource::class;
}
