<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</dt>
            <dd class="text-sm text-gray-900 dark:text-white">{{ $expense->expense_date->format('F j, Y') }}</dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount</dt>
            <dd class="text-sm text-gray-900 dark:text-white font-semibold">${{ number_format($expense->amount, 2) }}</dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Traffic Source</dt>
            <dd class="text-sm text-gray-900 dark:text-white">
                <div class="flex items-center space-x-2">
                    <div 
                        class="w-3 h-3 rounded-full border border-gray-300 dark:border-gray-600" 
                        style="background-color: {{ $expense->trafficSource->color }};"
                    ></div>
                    <span>{{ $expense->trafficSource->name }}</span>
                </div>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created By</dt>
            <dd class="text-sm text-gray-900 dark:text-white">{{ $expense->creator?->name ?: 'Unknown' }}</dd>
        </div>
    </div>
    
    @if($expense->notes)
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Notes</dt>
            <dd class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 p-3 rounded-md">
                {{ $expense->notes }}
            </dd>
        </div>
    @endif
    
    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
            <dd class="text-sm text-gray-900 dark:text-white">{{ $expense->created_at->format('M j, Y g:i A') }}</dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Updated</dt>
            <dd class="text-sm text-gray-900 dark:text-white">{{ $expense->updated_at->format('M j, Y g:i A') }}</dd>
        </div>
    </div>
</div>
