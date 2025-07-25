<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pastel-purple leading-tight font-sans">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12 font-sans bg-pastel-gray min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as admin!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 