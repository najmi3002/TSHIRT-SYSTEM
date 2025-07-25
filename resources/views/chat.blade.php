<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight font-sans">
            {{ __('Chat') }}
        </h2>
    </x-slot>
    <div class="py-12 font-sans bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("This is the customer chat page.") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 