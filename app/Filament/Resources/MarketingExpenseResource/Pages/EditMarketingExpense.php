<?php

namespace App\Filament\Resources\MarketingExpenseResource\Pages;

use App\Filament\Resources\MarketingExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketingExpense extends EditRecord
{
    protected static string $resource = MarketingExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
