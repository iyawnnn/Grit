<section>
    <header>
        <h2 class="text-xl font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __("Update your account's profile name.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email (Cannot be changed)')" />
            <x-text-input 
                id="email" 
                type="email" 
                class="mt-1 block w-full bg-gray-100 border-gray-200 text-gray-500 cursor-not-allowed rounded-md shadow-sm" 
                :value="$user->email" 
                disabled
            />
            
            <p class="mt-2 text-sm text-gray-400 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span>Your email address is permanently linked to your account.</span>
            </p>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand-orange border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Save Changes') }}
            </button>
        </div>
    </form>
</section>