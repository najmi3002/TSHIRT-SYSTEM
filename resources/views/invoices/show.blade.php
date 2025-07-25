<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invoice #{{ $invoice->invoice_number }}
            </h2>
            <a href="{{ route('admin.invoices.pdf', $invoice) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Download PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Invoice Header -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">INVOICE</h1>
                                <p class="text-gray-600 mt-2">Invoice #{{ $invoice->invoice_number }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-600">Invoice Date</div>
                                <div class="text-lg font-semibold">{{ $invoice->invoice_date->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-600 mt-2">Due Date</div>
                                <div class="text-lg font-semibold {{ $invoice->isOverdue() ? 'text-red-600' : '' }}">
                                    {{ $invoice->due_date->format('M d, Y') }}
                                    @if($invoice->isOverdue())
                                        <span class="text-red-600">(Overdue)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Bill To:</h3>
                            <div class="text-gray-700">
                                <p class="font-semibold">{{ $invoice->customer_name }}</p>
                                <p>{{ $invoice->customer_email }}</p>
                                <p>{{ $invoice->customer_phone }}</p>
                                <p class="mt-2">{{ $invoice->customer_address }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">From:</h3>
                            <div class="text-gray-700">
                                <p class="font-semibold">T-SHIRT SYSTEM SDN BHD</p>
                                <p>123 Business Street</p>
                                <p>Kuala Lumpur, Malaysia</p>
                                <p>Phone: +60 3-1234 5678</p>
                                <p>Email: info@tshirtsystem.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Items -->
                    <div class="mb-8">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $invoice->product_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        {{ $invoice->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        RM{{ number_format($invoice->unit_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        RM{{ number_format($invoice->subtotal, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Invoice Totals -->
                    <div class="flex justify-end">
                        <div class="w-64">
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span class="font-semibold">RM{{ number_format($invoice->subtotal, 2) }}</span>
                                </div>
                                @if($invoice->tax_amount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tax:</span>
                                        <span class="font-semibold">RM{{ number_format($invoice->tax_amount, 2) }}</span>
                                    </div>
                                @endif
                                @if($invoice->discount_amount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Discount:</span>
                                        <span class="font-semibold text-green-600">-RM{{ number_format($invoice->discount_amount, 2) }}</span>
                                    </div>
                                @endif
                                <div class="border-t border-gray-200 pt-2">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-semibold">Total:</span>
                                        <span class="text-lg font-bold">RM{{ number_format($invoice->total_amount, 2) }}</span>
                                    </div>
                                </div>
                                @if($invoice->deposit_amount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Deposit Paid:</span>
                                        <span class="font-semibold text-green-600">RM{{ number_format($invoice->deposit_amount, 2) }}</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-2">
                                        <div class="flex justify-between">
                                            <span class="text-lg font-semibold">Balance Due:</span>
                                            <span class="text-lg font-bold text-red-600">RM{{ number_format($invoice->balance_amount, 2) }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                        <h4 class="text-lg font-semibold text-gray-900">Payment Status</h4>
                        <p class="text-gray-600">Current status: 
                            <span class="font-semibold 
                                @if($invoice->payment_status === 'paid') text-green-600
                                @elseif($invoice->payment_status === 'partial') text-yellow-600
                                @else text-red-600 @endif">
                                {{ ucfirst($invoice->payment_status) }}
                            </span>
                        </p>
                    </div>

                    <!-- Notes -->
                    @if($invoice->notes)
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Notes</h4>
                            <p class="text-gray-700">{{ $invoice->notes }}</p>
                        </div>
                    @endif

                    <!-- Terms & Conditions -->
                    @if($invoice->terms_conditions)
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Terms & Conditions</h4>
                            <p class="text-gray-700 text-sm">{{ $invoice->terms_conditions }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout> 