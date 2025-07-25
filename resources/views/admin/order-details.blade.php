<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Details for ID: {{ $design->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Back Button -->
                    <div class="mb-6 flex justify-between items-center">
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            &larr; Back to All Orders
                        </a>
                        
                        @if(!$design->invoice)
                            <a href="{{ route('admin.invoices.create') }}?design_id={{ $design->id }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Create Invoice
                            </a>
                        @else
                            <a href="{{ route('admin.invoices.show', $design->invoice) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                View Invoice
                            </a>
                        @endif
                    </div>

                    <!-- Customer Details -->
                    <div class="mb-8">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Customer Details
                        </h3>
                        <div class="mt-2 border-t border-gray-200 pt-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ optional($design->user)->name ?? 'User Deleted' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ optional($design->user)->phone ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ optional($design->user)->address ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Order Details
                        </h3>
                        <div class="mt-2 border-t border-gray-200 pt-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Product</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $design->product_name ?? (optional($design->product)->name ?? 'Product Deleted') }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Total Quantity</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $design->total_qty }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Total Price</dt>
                                    <dd class="mt-1 text-sm text-gray-900">RM{{ number_format($design->total_price, 2) }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Design Specifications</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <div class="space-y-2">
                                            <div>
                                                <strong>Collar Types:</strong>
                                                <ul class="list-disc list-inside">
                                                @forelse($design->collar_type ?? [] as $item)
                                                    <li>{{ $item['name'] }} (Qty: {{ $item['quantity'] }})</li>
                                                @empty
                                                    <li>-</li>
                                                @endforelse
                                                </ul>
                                            </div>
                                            <div>
                                                <strong>Fabric Types:</strong>
                                                <ul class="list-disc list-inside">
                                                @forelse($design->fabric_type ?? [] as $item)
                                                    <li>{{ $item['name'] }} (Qty: {{ $item['quantity'] }})</li>
                                                @empty
                                                    <li>-</li>
                                                @endforelse
                                                </ul>
                                            </div>
                                            <div>
                                                <strong>Sleeve Types:</strong>
                                                <ul class="list-disc list-inside">
                                                @forelse($design->sleeve_type ?? [] as $item)
                                                    <li>{{ $item['name'] }} (Qty: {{ $item['quantity'] }})</li>
                                                @empty
                                                    <li>-</li>
                                                @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout> 