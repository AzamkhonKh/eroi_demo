<?php

namespace App\Filament\Widgets;

use App\Models\MarketingExpense;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ReportsExpenseChart extends ChartWidget
{
    protected static ?string $heading = 'Marketing Expenses Distribution';

    protected int|string|array $columnSpan = 'full';

    public ?string $startDate = null;

    public ?string $endDate = null;

    public function getHeading(): ?string
    {
        $baseHeading = 'Marketing Expenses Distribution';

        if ($this->startDate && $this->endDate) {
            $startDate = Carbon::parse($this->startDate)->format('M j, Y');
            $endDate = Carbon::parse($this->endDate)->format('M j, Y');

            return $baseHeading.' ('.$startDate.' - '.$endDate.')';
        }

        return $baseHeading;
    }

    public function getDescription(): ?string
    {
        return 'Hover over pie segments to see detailed expense information';
    }

    protected function getFooter(): ?string
    {
        $startDate = $this->startDate ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $this->endDate ?? now()->format('Y-m-d');

        $totalExpenses = MarketingExpense::whereDate('expense_date', '>=', $startDate)
            ->whereDate('expense_date', '<=', $endDate)
            ->count();
        $totalAmount = MarketingExpense::whereDate('expense_date', '>=', $startDate)
            ->whereDate('expense_date', '<=', $endDate)
            ->sum('amount');

        return $totalExpenses > 0
            ? "Total: {$totalExpenses} expenses worth $".number_format($totalAmount, 2)
            : 'No expenses found for selected date range';
    }

    protected function getData(): array
    {
        $startDate = $this->startDate ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $this->endDate ?? now()->format('Y-m-d');

        $data = MarketingExpense::with('trafficSource')
            ->whereDate('expense_date', '>=', $startDate)
            ->whereDate('expense_date', '<=', $endDate)
            ->selectRaw('traffic_source_id, SUM(amount) as total_amount, COUNT(*) as expense_count')
            ->groupBy('traffic_source_id')
            ->orderBy('total_amount', 'desc')
            ->get();

        if ($data->isEmpty()) {
            return [
                'datasets' => [
                    [
                        'label' => 'Marketing Expenses',
                        'data' => [1],
                        'backgroundColor' => ['#E5E7EB'],
                    ],
                ],
                'labels' => ['No Data'],
            ];
        }

        $chartData = [];
        $labels = [];
        $colors = [];

        // Calculate total for percentages
        $total = $data->sum('total_amount');

        foreach ($data as $item) {
            $chartData[] = $item->total_amount;
            $percentage = $total > 0 ? round(($item->total_amount / $total) * 100, 1) : 0;
            $labels[] = $item->trafficSource->name.' ('.$percentage.'%)';
            $colors[] = $item->trafficSource->color ?? '#3B82F6';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Marketing Expenses',
                    'data' => $chartData,
                    'backgroundColor' => $colors,
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'right',
                    'labels' => [
                        'usePointStyle' => true,
                        'padding' => 20,
                        'boxWidth' => 12,
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'nearest',
                    'intersect' => true,
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'titleColor' => '#ffffff',
                    'bodyColor' => '#ffffff',
                    'cornerRadius' => 6,
                    'padding' => 12,
                    'displayColors' => true,
                ],
            ],
            'elements' => [
                'arc' => [
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                    'hoverBorderWidth' => 3,
                    'hoverBorderColor' => '#4F46E5',
                    'hoverOffset' => 4,
                ],
            ],
            'hover' => [
                'animationDuration' => 200,
            ],
        ];
    }
}
