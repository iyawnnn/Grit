<div x-data="{ 
        show: false, 
        message: '{{ session('success') ?? '' }}' 
    }" x-init="
        if (message) { 
            show = true; 
            setTimeout(() => show = false, 4000); 
        }
    " @notify.window="
        message = $event.detail.message; 
        show = true; 
        setTimeout(() => show = false, 4000);
    " x-show="show" x-cloak x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
    class="fixed bottom-6 right-6 z-[100] flex items-center p-4 text-gray-800 bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-gray-100"
    role="alert" style="display: none;">

    <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-[#e26a35] bg-[#e26a35]/10 rounded-lg">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
        </svg>
    </div>

    <div class="ml-3 text-sm font-medium pr-4" x-text="message"></div>

    <button type="button" @click="show = false"
        class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-50 transition-colors inline-flex items-center justify-center h-8 w-8">
        <span class="sr-only">Close Notification</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>