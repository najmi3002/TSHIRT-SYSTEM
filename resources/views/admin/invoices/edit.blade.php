<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Invoice') }} #{{ $invoice->invoice_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('admin.invoices.show', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            &larr; Back to Invoice
                        </a>
                    </div>

                    <form method="POST" action="{{ route('admin.invoices.update', $invoice) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Invoice Date -->
                            <div>
                                <x-input-label for="invoice_date" :value="__('Invoice Date')" />
                                <x-text-input id="invoice_date" class="block mt-1 w-full" type="date" name="invoice_date" :value="old('invoice_date', $invoice->invoice_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('invoice_date')" class="mt-2" />
                            </div>

                            <!-- Due Date -->
                            <div>
                                <x-input-label for="due_date" :value="__('Due Date')" />
                                <x-text-input id="due_date" class="block mt-1 w-full" type="date" name="due_date" :value="old('due_date', $invoice->due_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>

                            <!-- Payment Status -->
                            <div>
                                <x-input-label for="payment_status" :value="__('Payment Status')" />
                                <select id="payment_status" name="payment_status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="pending" {{ $invoice->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="partial" {{ $invoice->payment_status === 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="paid" {{ $invoice->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                                <x-input-error :messages="$errors->get('payment_status')" class="mt-2" />
                            </div>

                            <!-- Invoice Status -->
                            <div>
                                <x-input-label for="invoice_status" :value="__('Invoice Status')" />
                                <select id="invoice_status" name="invoice_status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="draft" {{ $invoice->invoice_status === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="sent" {{ $invoice->invoice_status === 'sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="paid" {{ $invoice->invoice_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="overdue" {{ $invoice->invoice_status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    <option value="cancelled" {{ $invoice->invoice_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <x-input-error :messages="$errors->get('invoice_status')" class="mt-2" />
                            </div>

                            <!-- Tax Amount -->
                            <div>
                                <x-input-label for="tax_amount" :value="__('Tax Amount (RM)')" />
                                <x-text-input id="tax_amount" class="block mt-1 w-full" type="number" name="tax_amount" :value="old('tax_amount', $invoice->tax_amount)" step="0.01" min="0" />
                                <x-input-error :messages="$errors->get('tax_amount')" class="mt-2" />
                            </div>

                            <!-- Discount Amount -->
                            <div>
                                <x-input-label for="discount_amount" :value="__('Discount Amount (RM)')" />
                                <x-text-input id="discount_amount" class="block mt-1 w-full" type="number" name="discount_amount" :value="old('discount_amount', $invoice->discount_amount)" step="0.01" min="0" />
                                <x-input-error :messages="$errors->get('discount_amount')" class="mt-2" />
                            </div>

                            <!-- Deposit Amount -->
                            <div>
                                <x-input-label for="deposit_amount" :value="__('Deposit Amount (RM)')" />
                                <x-text-input id="deposit_amount" class="block mt-1 w-full" type="number" name="deposit_amount" :value="old('deposit_amount', $invoice->deposit_amount)" step="0.01" min="0" />
                                <x-input-error :messages="$errors->get('deposit_amount')" class="mt-2" />
                            </div>

                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <x-input-label for="notes" :value="__('Notes (Optional)')" />
                            <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $invoice->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="mt-6">
                            <x-input-label for="terms_conditions" :value="__('Terms & Conditions (Optional)')" />
                            <textarea id="terms_conditions" name="terms_conditions" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('terms_conditions', $invoice->terms_conditions) }}</textarea>
                            <x-input-error :messages="$errors->get('terms_conditions')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <form method="POST" action="{{ route('admin.invoices.destroy', $invoice) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete Invoice
                                </button>
                            </form>
                            <x-primary-button>
                                {{ __('Update Invoice') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 