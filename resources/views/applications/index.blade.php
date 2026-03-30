<x-app-layout>
    <x-slot:title>Applications</x-slot:title>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Career Pipeline') }}
        </h2>
    </x-slot>

    <div>
        <livewire:application-index />
    </div>
</x-app-layout>