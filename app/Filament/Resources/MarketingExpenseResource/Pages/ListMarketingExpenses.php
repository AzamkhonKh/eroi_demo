<?php

namespace App\Filament\Resources\MarketingExpenseResource\Pages;

use App\Filament\Resources\MarketingExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarketingExpenses extends ListRecords
{
    protected static string $resource = MarketingExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
