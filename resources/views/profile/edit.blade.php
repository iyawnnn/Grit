<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-brand-dark leading-tight tracking-tight">
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8 tracking-tight">
            
            <div class="p-6 sm:p-8 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            @if(is_null($user->google_id))
            <div class="p-6 sm:p-8 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            @endif

            <div class="p-6 sm:p-8 bg-white border border-red-100 rounded-xl shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>