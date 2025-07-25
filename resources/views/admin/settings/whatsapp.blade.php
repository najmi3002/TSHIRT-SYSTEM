<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pastel-purple leading-tight font-sans">
            Kemaskini WhatsApp Admin
        </h2>
    </x-slot>

    <div class="py-12 font-sans bg-pastel-gray min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8 border border-gray-200">
                @if(session('success'))
                    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-200 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.settings.whatsapp.update') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp Admin</label>
                        <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-pastel-purple focus:ring focus:ring-pastel-purple/30" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $whatsapp_number) }}" required>
                        @error('whatsapp_number')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="whatsapp_message" class="block text-sm font-medium text-gray-700 mb-1">Pesan Default</label>
                        <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-pastel-purple focus:ring focus:ring-pastel-purple/30" id="whatsapp_message" name="whatsapp_message" value="{{ old('whatsapp_message', $whatsapp_message) }}" required>
                        @error('whatsapp_message')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-pastel-purple text-white font-semibold rounded shadow hover:bg-pastel-blue hover:text-pastel-purple transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 