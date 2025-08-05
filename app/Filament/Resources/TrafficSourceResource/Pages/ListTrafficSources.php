<?php

namespace App\Filament\Resources\TrafficSourceResource\Pages;

use App\Filament\Resources\TrafficSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrafficSources extends ListRecords
{
    protected static string $resource = TrafficSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
