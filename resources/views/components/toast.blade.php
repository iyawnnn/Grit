@php
    $initialMessage = session('success') ?? session('status') ?? session('error') ?? '';
    $initialType = session('error') || $errors->any() ? 'error' : 'success';
    
    if (!$initialMessage && $errors->any()) {
        $initialMessage = $errors->first();
    }
@endphp

<div x-data="{ 
        show: false, 
        message: @js($initialMessage),
        type: @js($initialType),
        timeout: null
    }" 
    x-init="
        if (message !== '') { 
            show = true; 
            timeout = setTimeout(() => show = false, 5000); 
        }
    " 
    @toast.window="
        clearTimeout(timeout);
        let detail = $event.detail;
        message = detail.message || (detail[0] && detail[0].message) || detail;
        let incomingType = detail.type || (detail[0] && detail[0].type) || 'success';
        type = (incomingType === 'error' || detail.isError) ? 'error' : 'success';
        show = true; 
        timeout = setTimeout(() => show = false, 5000);
    " 
    x-show="show" x-cloak 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
    class="fixed bottom-6 right-6 z-[100] flex items-center p-4 text-gray-800 bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-200/80"
    role="alert" style="display: none;">

    <div x-show="type !== 'error'" class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-[#e26a35] bg-[#fff5f0] border border-[#e26a35]/20 rounded-lg">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
    </div>

    <div x-show="type === 'error'" class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-600 bg-red-50 border border-red-100 rounded-lg">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </div>

    <div class="ml-3 text-sm font-bold text-gray-700 pr-4" x-text="message"></div>

    <button type="button" @click="show = false"
        class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-50 transition-colors inline-flex items-center justify-center h-8 w-8">
        <span class="sr-only">Close Notification</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>