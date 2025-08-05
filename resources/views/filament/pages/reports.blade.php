<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Charts Section --}}
        @if($this->startDate && $this->endDate)
            @livewire(\App\Filament\Widgets\ReportsExpenseChart::class, [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate
            ], key($this->startDate . '-' . $this->endDate))
        @endif

        {{-- Date Range Form --}}
        <x-filament::section>
            <x-slot name="heading">
                Select Date Range
            </x-slot>
            <x-slot name="description">
                Choose the date range for your marketing expenses report
            </x-slot>

            <form wire:submit="$refresh" class="space-y-4">
                {{ $this->form }}

                <div class="flex justify-end">
                    <x-filament::button type="submit">
                        Update Report
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- Summary Table --}}
        @if($this->startDate && $this->endDate)
        <x-filament::section
            :collapsible="true"
            :collapsed="!$showExpenses">
            <x-slot name="heading">
                <div class="flex items-center space-x-2">
                    <x-heroicon-o-table-cells class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                    <span>Detailed Expenses</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        ({{ $this->totalRecords }} records)
                    </span>
                </div>
            </x-slot>

            <x-slot name="description">
                Individual expense records for the selected date range
            </x-slot>

            @if ($showExpenses)
            @livewire('expenses-table', [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            ])
            @else
            <div class="flex items-center justify-center py-12">
                <div class="text-center">
                    <x-heroicon-o-table-cells class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Detailed Expenses</h3>
                    <p class="text-gray-500 text-sm mb-4">Click "Update Report" to load detailed expense records</p>
                    <x-filament::button
                        wire:click="loadExpenses"
                        color="gray"
                        size="sm">
                        Load Expenses
                    </x-filament::button>
                </div>
            </div>
            @endif
        </x-filament::section>
        @endif

        @unless($this->startDate && $this->endDate)
        <x-filament::section>
            <x-slot name="heading">
                No Date Range Selected
            </x-slot>

            <p class="text-gray-500">Please select a date range above to view your marketing expenses report.</p>
        </x-filament::section>
        @endunless
    </div>
</x-filament-panels::page>