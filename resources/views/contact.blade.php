<x-guest-layout>
    <x-slot:title>Contact Support</x-slot:title>
    <div class="font-sans relative min-h-screen bg-gray-50 selection:bg-[#e26a35] selection:text-white pb-24">

        <div class="absolute top-0 left-0 right-0 h-[60vh] bg-[#e26a35] overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none z-0">
                <h1 class="text-[25vw] font-black text-white opacity-[0.04] whitespace-nowrap tracking-tighter mix-blend-overlay uppercase">
                    SUPPORT
                </h1>
            </div>
            <div class="absolute inset-0 z-0 opacity-[0.04] bg-[url('{{ asset('images/landing/rough-ink-dots.png') }}')] mix-blend-multiply pointer-events-none"></div>
        </div>

        @if (session('status') || $errors->any())
        <div x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-6 right-6 z-50 max-w-sm w-full bg-white shadow-2xl rounded-2xl border-l-8 {{ session('status') ? 'border-[#e26a35]' : 'border-red-500' }} p-5">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-0.5">
                    @if(session('status'))
                    <svg class="h-6 w-6 text-[#e26a35]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    @else
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    @endif
                </div>
                <div class="ml-4 w-0 flex-1 pt-0.5">
                    <p class="text-base font-black text-gray-900 tracking-tight">
                        {{ session('status') ? 'Message Sent!' : 'Oops, an error occurred.' }}
                    </p>
                    <p class="mt-1 text-sm text-gray-500 font-medium">
                        {{ session('status') ?? 'Please check the highlighted fields below and try again.' }}
                    </p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e26a35]">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div class="relative z-10 flex flex-col items-center pt-20 px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-10 max-w-3xl mx-auto">
                <h1 class="text-5xl sm:text-6xl md:text-7xl font-black text-white tracking-tight leading-[1.05] drop-shadow-sm">
                    How can we help?
                </h1>
                <p class="mt-6 text-lg sm:text-xl text-white/90 font-medium max-w-2xl mx-auto">
                    Hit a snag, need advice on beating the ATS, or just want to share a success story? Drop us a message and we will respond quickly.
                </p>
            </div>

            <div class="w-full max-w-2xl bg-white rounded-[2rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] p-8 sm:p-12">

                <form method="POST" action="{{ route('contact.submit') }}" class="space-y-8">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-extrabold text-gray-900 uppercase tracking-wider mb-3">Full Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                            class="block w-full px-6 py-4 bg-gray-50 border-2 {{ $errors->has('name') ? 'border-red-300 focus:border-red-500' : 'border-gray-100 focus:border-[#e26a35]' }} rounded-2xl text-gray-900 font-medium text-lg focus:bg-white focus:ring-0 transition-colors duration-200"
                            placeholder="John Doe" />
                        @error('name')
                        <p class="mt-2 text-sm font-bold text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-extrabold text-gray-900 uppercase tracking-wider mb-3">Email Address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                            class="block w-full px-6 py-4 bg-gray-50 border-2 {{ $errors->has('email') ? 'border-red-300 focus:border-red-500' : 'border-gray-100 focus:border-[#e26a35]' }} rounded-2xl text-gray-900 font-medium text-lg focus:bg-white focus:ring-0 transition-colors duration-200"
                            placeholder="hello@example.com" />
                        @error('email')
                        <p class="mt-2 text-sm font-bold text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-extrabold text-gray-900 uppercase tracking-wider mb-3">Your Message</label>
                        <textarea id="message" name="message" rows="5" required
                            class="block w-full px-6 py-4 bg-gray-50 border-2 {{ $errors->has('message') ? 'border-red-300 focus:border-red-500' : 'border-gray-100 focus:border-[#e26a35]' }} rounded-2xl text-gray-900 font-medium text-lg focus:bg-white focus:ring-0 resize-y transition-colors duration-200"
                            placeholder="What is on your mind?">{{ old('message') }}</textarea>
                        @error('message')
                        <p class="mt-2 text-sm font-bold text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="group relative w-full inline-flex justify-center items-center px-8 py-5 bg-[#e26a35] text-white font-extrabold rounded-full hover:bg-[#c95b2c] transition-all duration-300 hover:scale-[1.02] shadow-[0_10px_20px_rgba(226,106,53,0.3)] hover:shadow-[0_15px_30px_rgba(226,106,53,0.4)] text-xl z-20 focus:outline-none focus:ring-4 focus:ring-[#e26a35]/30">
                            Send Message
                            <svg class="ml-3 w-6 h-6 transform transition-transform duration-300 group-hover:translate-x-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>