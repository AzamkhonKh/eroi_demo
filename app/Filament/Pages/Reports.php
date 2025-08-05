<?php

namespace App\Filament\Pages;

use App\Models\MarketingExpense;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class Reports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationGroup = 'Marketing Management';

    protected static string $view = 'filament.pages.reports';

    public ?array $data = [];

    public $startDate = null;

    public $endDate = null;

    public $showExpenses = false;

    public function mount(): void
    {
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->showExpenses = false; // Don't auto-load expenses

        $this->form->fill([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Date Range')
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->required()
                            ->maxDate(now())
                            ->live()
                            ->afterStateUpdated(function ($state) {
                                $this->startDate = $state;
                                $this->dispatch('dateRangeUpdated');
                            }),

                        Forms\Components\DatePicker::make('end_date')
                            ->required()
                            ->maxDate(now())
                            ->afterOrEqual('start_date')
                            ->live()
                            ->afterStateUpdated(function ($state) {
                                $this->endDate = $state;
                                $this->dispatch('dateRangeUpdated');
                            }),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function loadExpenses(): void
    {
        $this->showExpenses = true;
    }

    public function refresh(): void
    {
        // Update dates from form state
        $formState = $this->form->getState();
        $this->startDate = $formState['start_date'] ?? $this->startDate;
        $this->endDate = $formState['end_date'] ?? $this->endDate;

        // Load expenses when user explicitly clicks "Update Report"
        $this->showExpenses = true;

        // Dispatch event to update chart
        $this->dispatch('dateRangeUpdated');
    }

    public function getTotalRecordsProperty(): int
    {
        $startDate = $this->startDate ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $this->endDate ?? now()->format('Y-m-d');

        return MarketingExpense::whereDate('expense_date', '>=', $startDate)
            ->whereDate('expense_date', '<=', $endDate)
            ->count();
    }

    public function getSummaryData()
    {
        $startDate = $this->startDate ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $this->endDate ?? now()->format('Y-m-d');

        $data = MarketingExpense::with('trafficSource')
            ->whereDate('expense_date', '>=', $startDate)
            ->whereDate('expense_date', '<=', $endDate)
            ->selectRaw('
                traffic_source_id,
                SUM(amount) as total_amount,
                COUNT(*) as expense_count
            ')
            ->groupBy('traffic_source_id')
            ->get()
            ->map(function ($item) {
                return [
                    'traffic_source' => $item->trafficSource,
                    'total_amount' => $item->total_amount,
                    'expense_count' => $item->expense_count,
                ];
            });

        $totalAmount = $data->sum('total_amount');

        return $data->map(function ($item) use ($totalAmount) {
            $item['percentage'] = $totalAmount > 0 ? ($item['total_amount'] / $totalAmount) * 100 : 0;

            return $item;
        });
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    public function getReportData(): array
    {
        $startDate = $this->startDate ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $this->endDate ?? now()->format('Y-m-d');

        $data = MarketingExpense::with('trafficSource')
            ->whereDate('expense_date', '>=', $startDate)
            ->whereDate('expense_date', '<=', $endDate)
            ->selectRaw('
                traffic_source_id,
                SUM(amount) as total_amount,
                COUNT(*) as expense_count
            ')
            ->groupBy('traffic_source_id')
            ->get()
            ->map(function ($item) {
                return [
                    'traffic_source' => $item->trafficSource,
                    'total_amount' => $item->total_amount,
                    'expense_count' => $item->expense_count,
                ];
            });

        $totalAmount = $data->sum('total_amount');

        return $data->map(function ($item) use ($totalAmount) {
            $item['percentage'] = $totalAmount > 0 ? ($item['total_amount'] / $totalAmount) * 100 : 0;

            return $item;
        })->toArray();
    }

    protected function getTableQueryStringKey(): string
    {
        return 'summary';
    }

    public function getExpensesTableQueryStringKey(): string
    {
        return 'expenses';
    }
}
