<x-guest-layout>
    <div class="flex h-screen w-full bg-white">
        
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-6 sm:px-12 xl:px-20 bg-white overflow-y-auto">
            <div class="w-full max-w-[360px] mx-auto my-auto py-8">
                
                <div class="flex justify-center mb-8">
                    <img src="/images/grit-logo.svg" alt="Grit application tracker logo" class="h-8 w-auto">
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-3xl font-semibold tracking-tight text-brand-dark mb-1.5">Welcome back</h1>
                    <p class="text-sm text-gray-500 font-medium tracking-tight">Enter your details to sign in.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                            class="w-full px-4 py-3 rounded-xl border-0 bg-gray-50 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-brand-orange text-sm font-medium transition-all" placeholder="hello@example.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div x-data="{ show: false }" class="relative">
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" 
                            class="w-full pl-4 pr-12 py-3 rounded-xl border-0 bg-gray-50 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-brand-orange text-sm font-medium transition-all" placeholder="••••••••">
                        
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-brand-orange focus:ring-brand-orange w-4 h-4 cursor-pointer transition-colors shadow-sm">
                            <span class="ml-2 text-xs font-semibold text-gray-500 group-hover:text-brand-dark transition-colors tracking-tight">Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-brand-orange hover:text-[#e26a35] font-semibold transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-brand-orange text-white py-3 rounded-xl font-semibold text-sm tracking-tight hover:bg-[#e26a35] transition-colors duration-200 mt-2 shadow-sm">
                        Sign in
                    </button>
                </form>

                @include('components.google-auth-button', ['action' => 'login'])

                <p class="mt-10 text-center text-sm text-gray-500 font-medium tracking-tight">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-brand-dark hover:text-brand-orange font-semibold transition-colors underline decoration-2 underline-offset-4">Sign up for free</a>
                </p>
            </div>
        </div>

        <div class="hidden lg:block lg:w-1/2 p-4 lg:p-6 bg-white">
            <div class="relative w-full h-full rounded-3xl overflow-hidden bg-brand-orange-light shadow-lg">
                <img src="/images/auth-visual-friendly.jpg" alt="Career growth illustration for job seekers" class="absolute inset-0 w-full h-full object-cover">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

                <div class="absolute bottom-0 left-0 w-full p-12 xl:p-16 z-10 flex flex-col items-center text-center">
                    <h2 class="text-3xl xl:text-4xl font-semibold tracking-tighter leading-tight mb-4 text-white">The best way to predict the <br>future is to create it.</h2>
                    <p class="text-white text-base font-medium tracking-tight opacity-80 max-w-md leading-relaxed">
                        Map out your career trajectory, track your success journey, and analyze your performance.
                    </p>
                </div>
            </div>
        </div>
        
    </div>
</x-guest-layout>