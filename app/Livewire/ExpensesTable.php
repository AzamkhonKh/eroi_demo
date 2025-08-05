<?php

namespace App\Livewire;

use App\Models\MarketingExpense;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ExpensesTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public ?string $startDate = null;

    public ?string $endDate = null;

    public function mount($startDate = null, $endDate = null): void
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('expense_date')
                    ->label('Date')
                    ->date('M j, Y')
                    ->sortable(),

                TextColumn::make('trafficSource.name')
                    ->label('Traffic Source')
                    ->formatStateUsing(function ($record) {
                        return view('components.traffic-source-badge', [
                            'name' => $record->trafficSource->name,
                            'color' => $record->trafficSource->color,
                        ]);
                    })
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }

                        return $state;
                    })
                    ->searchable(),

                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('traffic_source_id')
                    ->label('Traffic Source')
                    ->relationship('trafficSource', 'name')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalContent(fn (MarketingExpense $record): \Illuminate\Contracts\View\View => view(
                        'filament.expense-detail',
                        ['expense' => $record]
                    )),
            ])
            ->defaultSort('expense_date', 'desc')
            ->paginated(true)
            ->defaultPaginationPageOption(25)
            ->paginationPageOptions([10, 25, 50, 100])
            ->striped()
            ->searchable();
    }

    protected function getTableQuery(): Builder
    {
        $startDate = $this->startDate ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $this->endDate ?? now()->format('Y-m-d');

        return MarketingExpense::with(['trafficSource', 'creator'])
            ->whereDate('expense_date', '>=', $startDate)
            ->whereDate('expense_date', '<=', $endDate);
    }

    public function render()
    {
        return view('livewire.expenses-table');
    }
}
