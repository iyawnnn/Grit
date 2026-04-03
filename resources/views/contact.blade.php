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
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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

    <x-footer />
</x-guest-layout>