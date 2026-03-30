@props([
    'show',
    'title' => 'Delete Item',
    'description' => 'Are you sure you want to delete this? This action cannot be undone.',
    'onConfirm',
    'onCancel' => null
])

<div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/30 backdrop-blur-sm"
    x-show="{{ $show }}" 
    x-cloak 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" 
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" 
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <div class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl border border-gray-100"
        @click.away="{{ $show }} = false; {{ $onCancel ? '$wire.'.$onCancel.'()' : '' }}" 
        x-show="{{ $show }}"
        x-transition:enter="transition ease-out duration-300 delay-75"
        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 scale-95">

        <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-5 border border-red-100">
            <x-heroicon-o-exclamation-triangle class="w-7 h-7 text-red-500" />
        </div>
        
        <h3 class="text-xl font-extrabold text-center text-gray-900 tracking-tight mb-2">{{ $title }}</h3>
        
        <p class="text-sm text-center font-medium text-gray-500 mb-8">{{ $description }}</p>
        
        <div class="flex gap-4">
            <button type="button" @click="{{ $show }} = false; {{ $onCancel ? '$wire.'.$onCancel.'()' : '' }}"
                class="flex-1 px-4 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button type="button" @click="{{ $show }} = false; $wire.{{ $onConfirm }}()"
                class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition-colors shadow-sm">
                Yes, Delete
            </button>
        </div>
    </div>
</div>