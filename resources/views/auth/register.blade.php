<x-guest-layout>
    <div class="flex h-screen w-full bg-white overflow-hidden">

        <div class="w-full lg:w-1/2 flex flex-col justify-center px-6 sm:px-12 xl:px-20 bg-white overflow-y-auto">
            <div class="w-full max-w-[360px] mx-auto my-auto py-4 lg:py-6">

                <div class="flex justify-center mb-6 lg:mb-8">
                    <img src="{{ asset('images/grit-logo.svg') }}" alt="Grit career tracker platform logo"
                        class="h-12 lg:h-16 w-auto">
                </div>

                <div class="text-center mb-5 lg:mb-6">
                    <h1 class="text-2xl font-semibold tracking-tight text-brand-dark mb-1">Join Grit today</h1>
                    <p class="text-xs text-gray-500 font-medium tracking-tight">Your personal career co-pilot. Let's
                        start tracking your success story!</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf

                    <div class="relative">
                        <label for="name" class="sr-only">Full name</label>
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            autocomplete="name"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-0 bg-gray-50 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-brand-orange text-sm font-medium transition-all"
                            placeholder="Jordan Lee">
                    </div>

                    <div class="relative">
                        <label for="email" class="sr-only">Email address</label>
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="username"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-0 bg-gray-50 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-brand-orange text-sm font-medium transition-all"
                            placeholder="hello@example.com">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        <div x-data="{ show: false }" class="relative">
                            <label for="password" class="sr-only">Password</label>
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required
                                autocomplete="new-password"
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border-0 bg-gray-50 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-brand-orange text-sm font-medium transition-all"
                                placeholder="••••••••">

                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg x-show="!show" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>

                        <div x-data="{ show: false }" class="relative">
                            <label for="password_confirmation" class="sr-only">Confirm password</label>
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <input id="password_confirmation" :type="show ? 'text' : 'password'"
                                name="password_confirmation" required autocomplete="new-password"
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border-0 bg-gray-50 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-brand-orange text-sm font-medium transition-all"
                                placeholder="••••••••">

                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg x-show="!show" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-brand-orange text-white py-2.5 rounded-xl font-semibold text-sm tracking-tight hover:bg-[#e26a35] transition-colors duration-200 mt-4 shadow-sm">
                        Create account
                    </button>
                </form>

                @include('components.google-auth-button', ['action' => 'register'])

                <p class="mt-6 lg:mt-8 text-center text-xs lg:text-sm text-gray-500 font-medium tracking-tight">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="text-brand-orange font-semibold relative inline-block after:block after:absolute after:-bottom-0.5 after:left-0 after:h-[1px] after:w-0 hover:after:w-full after:bg-brand-orange after:transition-all after:duration-300 after:ease-in-out">Sign
                        in here</a>
                </p>
            </div>
        </div>

        <div class="hidden lg:flex lg:w-1/2 relative bg-[#fff5f0] overflow-hidden">
            
            <img src="{{ asset('images/auth-visual-friendly.webp') }}"
                alt="Illustration of career growth and path planning"
                class="absolute inset-0 w-full h-full object-cover object-center mix-blend-multiply opacity-90">

            <div class="absolute inset-x-0 bottom-0 z-10 flex flex-col items-center text-center bg-gradient-to-t from-[#fff5f0] via-[#fff5f0]/95 to-transparent pt-32 pb-12 px-8 xl:pb-16 xl:px-12">
                <h2 class="text-3xl xl:text-4xl font-semibold tracking-tighter leading-tight mb-3 text-black">
                    The best way to predict the <br>future is to create it.
                </h2>
                <p class="text-gray-800 text-base font-medium tracking-tight max-w-md">
                    Map out your career trajectory, track your success journey, and analyze your performance.
                </p>
            </div>
            
        </div>

    </div>
</x-guest-layout>