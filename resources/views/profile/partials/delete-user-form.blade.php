<section class="space-y-6">
    <header>
        <h2 class="text-xl font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="inline-flex items-center px-4 py-2 bg-white border border-red-200 rounded-md font-medium text-xs text-red-600 uppercase tracking-widest hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-xl font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                {{ __('This action cannot be undone. All of your data will be permanently removed.') }}
            </p>

            @if(is_null(Auth::user()->google_id))
                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm"
                        placeholder="{{ __('Enter your password to confirm') }}"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            @endif

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>