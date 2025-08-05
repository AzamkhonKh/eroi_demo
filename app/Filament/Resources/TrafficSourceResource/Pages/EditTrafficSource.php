<?php

namespace App\Filament\Resources\TrafficSourceResource\Pages;

use App\Filament\Resources\TrafficSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrafficSource extends EditRecord
{
    protected static string $resource = TrafficSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
