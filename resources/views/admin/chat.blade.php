<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pastel-purple leading-tight font-sans">
            {{ __('Admin Chat') }}
        </h2>
        <a href="/admin" class="bg-pastel-blue text-pastel-purple px-4 py-2 rounded-full font-semibold font-sans shadow hover:bg-pastel-purple hover:text-pastel-blue transition">Back to Dashboard</a>
    </x-slot>
    <div class="py-12 font-sans bg-pastel-gray min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("This is the admin chat page.") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 