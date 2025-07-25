<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Gallery') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 flex flex-col">
                        <a href="{{ url('/products', $product->id) }}" class="block">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-56 object-cover">
                        </a>
                        <div class="p-4 text-center flex flex-col flex-grow">
                            <h3 class="text-lg font-semibold text-gray-900 flex-grow">{{ $product->name }}</h3>
                            <p class="text-gray-600 mt-1">RM{{ number_format($product->price, 2) }}</p>
                            <div class="mt-4">
                                <a href="{{ url('/products', $product->id) }}" class="inline-block bg-gray-800 text-white font-bold py-2 px-4 rounded hover:bg-gray-700 transition-colors duration-300">
                                    Choose
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-10">
                        <p class="text-xl">No products available at the moment.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout> 