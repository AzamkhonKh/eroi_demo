<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ $this->getHeading() }}
        </x-slot>

        @if($this->getDescription())
            <x-slot name="description">
                {{ $this->getDescription() }}
            </x-slot>
        @endif

        <div class="relative w-full" style="height: 300px;">
            <canvas
                ax-load
                ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('chart', 'filament/widgets') }}"
                x-data="chart({
                    type: @js($this->getType()),
                    data: @js($this->getData()),
                    options: @js($this->getOptions()),
                })"
                class="w-full h-full"
            ></canvas>
        </div>

        @if($this->getFooter())
            <div class="mt-3 px-3 py-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 text-center font-medium">
                    {{ $this->getFooter() }}
                </p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
