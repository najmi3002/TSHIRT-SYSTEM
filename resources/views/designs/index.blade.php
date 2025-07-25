<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight font-sans">
            {{ __('Own Design') }}
        </h2>
    </x-slot>
    <div x-data="designForm({
        collars: {{ json_encode($collarOptions) }},
        fabrics: {{ json_encode($fabricOptions) }},
        sleeves: {{ json_encode($sleeveOptions) }}
    })" class="py-12 font-sans bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <button @click="showDesignModal = true" class="inline-block bg-white text-black font-bold py-2 px-4 rounded border border-gray-300">
                    Your Design
                </button>
            </div>
            <div class="bg-[#d3d3d3] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Your Own Design Selections</h3>
                    @if(session('success'))
                        <div class="mb-4 text-green-600">{{ session('success') }}</div>
                    @endif
                    <table class="min-w-full bg-white border border-black rounded">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border border-black">ID</th>
                                <th class="px-4 py-2 border border-black">Product</th>
                                <th class="px-4 py-2 border border-black">Collar</th>
                                <th class="px-4 py-2 border border-black">Fabric</th>
                                <th class="px-4 py-2 border border-black">Sleeve</th>
                                <th class="px-4 py-2 border border-black">Total Quantity</th>
                                <th class="px-4 py-2 border border-black">Total Price (RM)</th>
                                <th class="px-4 py-2 border border-black">Deposit</th>
                                <th class="px-4 py-2 border border-black">Full Payment</th>
                                <th class="px-4 py-2 border border-black">Status</th>
                                <th class="px-4 py-2 border border-black">Invoice</th>
                                <th class="px-4 py-2 border border-black">Chat</th>
                                <th class="px-4 py-2 border border-black">Created At</th>
                                <th class="px-4 py-2 border border-black">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($designs as $design)
                                <tr>
                                    <td class="px-4 py-2 border border-black text-center">{{ $design->id }}</td>
                                    <td class="px-4 py-2 border border-black">
                                        {{ $design->product_name ?? ($design->product->name ?? 'Custom Design') }}
                                        @if($design->design_path)
                                            <a href="{{ asset('storage/' . $design->design_path) }}" target="_blank" class="text-blue-500 text-xs block">(View Design)</a>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border border-black">
                                        <ul class="list-disc list-inside">
                                            @forelse($design->collar_type ?? [] as $item)
                                                <li>{{ $item['name'] }} ({{ $item['quantity'] }})</li>
                                            @empty
                                                <li>-</li>
                                            @endforelse
                                        </ul>
                                    </td>
                                    <td class="px-4 py-2 border border-black">
                                        <ul class="list-disc list-inside">
                                            @forelse($design->fabric_type ?? [] as $item)
                                                <li>{{ $item['name'] }} ({{ $item['quantity'] }})</li>
                                            @empty
                                                <li>-</li>
                                            @endforelse
                                        </ul>
                                    </td>
                                    <td class="px-4 py-2 border border-black">
                                        <ul class="list-disc list-inside">
                                            @forelse($design->sleeve_type ?? [] as $item)
                                                <li>{{ $item['name'] }} ({{ $item['quantity'] }})</li>
                                            @empty
                                                <li>-</li>
                                            @endforelse
                                        </ul>
                                    </td>
                                    <td class="px-4 py-2 border border-black text-center">{{ $design->total_qty }}</td>
                                    <td class="px-4 py-2 border border-black text-center">{{ number_format($design->total_price, 2) }}</td>
                                    <td class="px-4 py-2 border border-black text-center">
                                        @php $depositAmount = $design->total_price / 2; @endphp
                                        @if($design->deposit)
                                            {{ number_format($design->deposit, 2) }}
                                            @if($design->deposit_proof_path)
                                                <a href="{{ asset('storage/' . $design->deposit_proof_path) }}" target="_blank" class="text-blue-500 text-xs">(View Proof)</a>
                                            @endif
                                        @else
                                            <span class="font-semibold">RM {{ number_format($depositAmount, 2) }}</span>
                                            <button @click="openModal('deposit', {{ $design->id }}, {{ $depositAmount }})" class="bg-blue-500 text-black px-2 py-1 rounded text-xs ml-2">Pay Deposit</button>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border border-black text-center">
                                        @if($design->deposit)
                                            @php $fullPayment = $design->total_price - $design->deposit; @endphp
                                            @if($design->fullpayment)
                                                {{ number_format($design->fullpayment, 2) }}
                                                @if($design->fullpayment_proof_path)
                                                    <a href="{{ asset('storage/' . $design->fullpayment_proof_path) }}" target="_blank" class="text-blue-500 text-xs">(View Proof)</a>
                                                @endif
                                            @else
                                                <span class="font-semibold">RM {{ number_format($fullPayment, 2) }}</span>
                                                <button @click="openModal('fullpayment', {{ $design->id }}, {{ $fullPayment }})" class="bg-green-500 text-white px-2 py-1 rounded text-xs ml-2">Pay Full</button>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border border-black text-center">{{ ucfirst($design->status) }}</td>
                                    <td class="px-4 py-2 border border-black text-center">
                                        @if($design->invoice)
                                            <a href="{{ route('invoices.show', $design->invoice->id) }}" class="text-white bg-blue-500 hover:bg-blue-700 px-2 py-1 rounded text-xs font-bold">
                                                View
                                            </a>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border border-black text-center">
                                        @php
                                            $adminPhone = \App\Models\Setting::get('whatsapp_number', '60136561726');
                                            $msg = 'Hello admin, saya ingin bertanya tentang design saya. ID: ' . $design->id . ', Nama Baju: ' . ($design->product_name ?? ($design->product->name ?? 'Custom Design'));
                                            $defaultMessage = urlencode($msg);
                                        @endphp
                                        <a href="https://wa.me/{{ $adminPhone }}?text={{ $defaultMessage }}" target="_blank" class="text-green-600 hover:underline font-bold">Chat</a>
                                    </td>
                                    <td class="px-4 py-2 border border-black text-center">{{ $design->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-2 border border-black text-center">
                                        <form action="{{ route('designs.destroy', $design->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this design?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-xs">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="13" class="text-center py-4 border border-black">No designs found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payment Modal -->
        <div x-show="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" style="display: none;">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Upload Payment Proof</h3>
                    <div class="mt-2 px-7 py-3">
                        <div class="text-sm text-gray-500 text-left">
                            <p>Please make payment to the following account:</p>
                            @php
                                $bank_name = \App\Models\Setting::get('bank_name', 'Maybank');
                                $account_name = \App\Models\Setting::get('account_name', 'T-SHIRT SYSTEM SDN BHD');
                                $account_number = \App\Models\Setting::get('account_number', '51234567890');
                            @endphp
                            <ul class="list-disc list-inside my-2">
                                <li><strong>Bank:</strong> {{ $bank_name }}</li>
                                <li><strong>Account Name:</strong> {{ $account_name }}</li>
                                <li><strong>Account Number:</strong> {{ $account_number }}</li>
                            </ul>
                        </div>
                        <form action="{{ route('designs.payment.upload') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <input type="hidden" name="design_id" :value="designId">
                            <input type="hidden" name="payment_type" :value="paymentType">
                            <div>
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700 text-left">Payment Receipt</label>
                                <input type="file" name="payment_proof" id="payment_proof" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" required>
                                @error('payment_proof')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="items-center px-4 py-3">
                                <button type="submit" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                                    Upload
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button @click="showModal = false" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your Design Modal -->
        <div x-show="showDesignModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" style="display: none;">
            <div class="relative top-10 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 text-center mb-6">Create Your Own Design</h3>
                    <form action="{{ route('designs.store.custom') }}" @submit="submitDesignForm" method="POST" enctype="multipart/form-data" class="space-y-6" x-ref="designForm">
                        @csrf
                        <input type="hidden" name="collar_type" :value="JSON.stringify(collar_types.map(c => ({ name: c.name, quantity: c.quantity })))">
                        <input type="hidden" name="fabric_type" :value="JSON.stringify(fabric_types.map(f => ({ name: f.name, quantity: f.quantity })))">
                        <input type="hidden" name="sleeve_type" :value="JSON.stringify(sleeve_types.map(s => ({ name: s.name, quantity: s.quantity })))">
                        <input type="hidden" name="total_qty" :value="totalQty">
                        <input type="hidden" name="total_price" :value="totalPrice">

                        <!-- Product Name -->
                        <div>
                            <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                            <input type="text" name="product_name" id="product_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>

                        <!-- Design Image Upload -->
                        <div>
                            <label for="design_image" class="block text-sm font-medium text-gray-700">Design Image</label>
                            <input type="file" name="design_image" id="design_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" required>
                        </div>

                        <!-- Total Quantity -->
                        <div>
                            <label for="total_quantity" class="block text-sm font-medium text-gray-700">Total Quantity</label>
                            <input type="number" id="total_quantity" x-model.number="totalQty" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <hr/>

                        <!-- Collar Types -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <label class="block text-sm font-medium text-gray-700">Collar Types</label>
                                <span class="text-xs px-2 py-1 rounded-full" :class="collarQtySum === totalQty ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" x-text="`${collarQtySum}/${totalQty}`"></span>
                            </div>
                            <template x-for="(collar, index) in collar_types" :key="index">
                                <div class="flex items-center space-x-2">
                                    <select x-model="collar.name" @change="updatePrice(collar, collars)" class="block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Select Type</option>
                                        <template x-for="option in collars">
                                            <option :value="option.name" x-text="`${option.name} (+RM${parseFloat(option.addon_price).toFixed(2)})`"></option>
                                        </template>
                                    </select>
                                    <input type="number" x-model.number="collar.quantity" min="0" class="block w-1/4 rounded-md border-gray-300 shadow-sm" placeholder="Qty">
                                    <button type="button" @click="removeCollar(index)" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                                </div>
                            </template>
                            <button type="button" @click="addCollar" class="text-sm text-indigo-600 hover:text-indigo-900">+ Add Collar</button>
                        </div>
                        
                        <!-- Fabric Types -->
                        <div class="space-y-2">
                             <div class="flex justify-between items-center">
                                <label class="block text-sm font-medium text-gray-700">Fabric Types</label>
                                <span class="text-xs px-2 py-1 rounded-full" :class="fabricQtySum === totalQty ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" x-text="`${fabricQtySum}/${totalQty}`"></span>
                            </div>
                            <template x-for="(fabric, index) in fabric_types" :key="index">
                                <div class="flex items-center space-x-2">
                                    <select x-model="fabric.name" @change="updatePrice(fabric, fabrics)" class="block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Select Type</option>
                                        <template x-for="option in fabrics">
                                            <option :value="option.name" x-text="`${option.name} (+RM${parseFloat(option.addon_price).toFixed(2)})`"></option>
                                        </template>
                                    </select>
                                    <input type="number" x-model.number="fabric.quantity" min="0" class="block w-1/4 rounded-md border-gray-300 shadow-sm" placeholder="Qty">
                                    <button type="button" @click="removeFabric(index)" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                                </div>
                            </template>
                            <button type="button" @click="addFabric" class="text-sm text-indigo-600 hover:text-indigo-900">+ Add Fabric</button>
                        </div>

                        <!-- Sleeve Types -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <label class="block text-sm font-medium text-gray-700">Sleeve Types</label>
                                <span class="text-xs px-2 py-1 rounded-full" :class="sleeveQtySum === totalQty ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" x-text="`${sleeveQtySum}/${totalQty}`"></span>
                            </div>
                            <template x-for="(sleeve, index) in sleeve_types" :key="index">
                                <div class="flex items-center space-x-2">
                                    <select x-model="sleeve.name" @change="updatePrice(sleeve, sleeves)" class="block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Select Type</option>
                                        <template x-for="option in sleeves">
                                            <option :value="option.name" x-text="`${option.name} (+RM${parseFloat(option.addon_price).toFixed(2)})`"></option>
                                        </template>
                                    </select>
                                    <input type="number" x-model.number="sleeve.quantity" min="0" class="block w-1/4 rounded-md border-gray-300 shadow-sm" placeholder="Qty">
                                    <button type="button" @click="removeSleeve(index)" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                                </div>
                            </template>
                            <button type="button" @click="addSleeve" class="text-sm text-indigo-600 hover:text-indigo-900">+ Add Sleeve</button>
                        </div>

                        <hr/>

                        <!-- Totals -->
                        <div class="space-y-1 text-right">
                             <p class="text-gray-600">Addon Price: <strong class="font-medium" x-text="`RM ${addonPrice.toFixed(2)}`"></strong></p>
                             <p class="text-xl font-bold text-gray-800">Total Price: <strong x-text="`RM ${totalPrice.toFixed(2)}`"></strong></p>
                        </div>
                        
                        <div class="pt-4 flex items-center justify-end space-x-4">
                            <button type="button" @click="showDesignModal = false" class="px-6 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-200 focus:outline-none">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function designForm(options = {}) {
            return {
                showModal: false,
                designId: null,
                paymentType: '',
                selectedDesign: null,
                depositAmount: '',
                openModal(type, id, deposit = null) {
                    this.showModal = true;
                    this.paymentType = type;
                    this.designId = id;
                    this.selectedDesign = this.designs.find(d => d.id === id);
                    if (deposit !== null) {
                        this.depositAmount = deposit.toFixed(2);
                    } else if (this.selectedDesign) {
                        this.depositAmount = (this.selectedDesign.total_price / 2).toFixed(2);
                    } else {
                        this.depositAmount = '0.00';
                    }
                },

                showDesignModal: false,
                totalQty: 1,
                basePrice: 35, // Base price for a custom t-shirt
                collar_types: [{ name: '', quantity: 1, addon: 0 }],
                fabric_types: [{ name: '', quantity: 1, addon: 0 }],
                sleeve_types: [{ name: '', quantity: 1, addon: 0 }],
                
                collars: options.collars || [],
                fabrics: options.fabrics || [],
                sleeves: options.sleeves || [],

                init() {
                    if (this.collars.length > 0) {
                        this.collar_types[0].name = this.collars[0].name;
                    }
                    if (this.fabrics.length > 0) {
                        this.fabric_types[0].name = this.fabrics[0].name;
                    }
                    if (this.sleeves.length > 0) {
                        this.sleeve_types[0].name = this.sleeves[0].name;
                    }
                    this.$watch('totalQty', (newVal) => {
                        if (newVal > 0) {
                            this.distributeQty();
                        }
                    });
                    this.distributeQty();
                },

                distributeQty() {
                    const types = ['collar_types', 'fabric_types', 'sleeve_types'];
                    types.forEach(type => {
                        if (this[type].length > 0) {
                            this[type][0].quantity = this.totalQty;
                            // zero out others
                            for(let i=1; i < this[type].length; i++) {
                                this[type][i].quantity = 0;
                            }
                        }
                    });
                },

                addCollar() { this.collar_types.push({ name: this.collars[0]?.name || '', quantity: 0, price: 0 }); },
                removeCollar(index) { if (this.collar_types.length > 1) this.collar_types.splice(index, 1); },
                addFabric() { this.fabric_types.push({ name: this.fabrics[0]?.name || '', quantity: 0, price: 0 }); },
                removeFabric(index) { if (this.fabric_types.length > 1) this.fabric_types.splice(index, 1); },
                addSleeve() { this.sleeve_types.push({ name: this.sleeves[0]?.name || '', quantity: 0, price: 0 }); },
                removeSleeve(index) { if (this.sleeve_types.length > 1) this.sleeve_types.splice(index, 1); },

                updatePrice(item, options) {
                    const selected = options.find(opt => opt.name === item.name);
                    item.price = selected ? parseFloat(selected.addon_price) : 0;
                },

                get collarQtySum() { return this.collar_types.reduce((sum, item) => sum + (Number(item.quantity) || 0), 0); },
                get fabricQtySum() { return this.fabric_types.reduce((sum, item) => sum + (Number(item.quantity) || 0), 0); },
                get sleeveQtySum() { return this.sleeve_types.reduce((sum, item) => sum + (Number(item.quantity) || 0), 0); },

                get addonPrice() {
                    let price = 0;
                    this.collar_types.forEach(item => { price += (Number(item.quantity) || 0) * (item.price || 0); });
                    this.fabric_types.forEach(item => { price += (Number(item.quantity) || 0) * (item.price || 0); });
                    this.sleeve_types.forEach(item => { price += (Number(item.quantity) || 0) * (item.price || 0); });
                    return price;
                },

                get totalPrice() {
                    let price = (this.totalQty || 0) * this.basePrice;
                    price += this.addonPrice;
                    return price;
                },

                submitDesignForm(event) {
                    let message = '';
                    if (this.collarQtySum !== this.totalQty) {
                        message += 'The sum of Collar Type quantities must be equal to the Total Quantity.\n';
                    }
                    if (this.fabricQtySum !== this.totalQty) {
                        message += 'The sum of Fabric Type quantities must be equal to the Total Quantity.\n';
                    }
                    if (this.sleeveQtySum !== this.totalQty) {
                        message += 'The sum of Sleeve Type quantities must be equal to the Total Quantity.\n';
                    }
                    // Validasi nama tidak kosong
                    if (this.collar_types.some(c => !c.name)) {
                        message += 'Please select a Collar Type for each row.\n';
                    }
                    if (this.fabric_types.some(f => !f.name)) {
                        message += 'Please select a Fabric Type for each row.\n';
                    }
                    if (this.sleeve_types.some(s => !s.name)) {
                        message += 'Please select a Sleeve Type for each row.\n';
                    }

                    if (message) {
                        event.preventDefault();
                        alert(message);
                        return;
                    }

                    // Force update hidden input values before submit
                    this.$refs.designForm.querySelector('input[name=collar_type]').value = JSON.stringify(this.collar_types.map(c => ({ name: c.name, quantity: c.quantity })));
                    this.$refs.designForm.querySelector('input[name=fabric_type]').value = JSON.stringify(this.fabric_types.map(f => ({ name: f.name, quantity: f.quantity })));
                    this.$refs.designForm.querySelector('input[name=sleeve_type]').value = JSON.stringify(this.sleeve_types.map(s => ({ name: s.name, quantity: s.quantity })));

                    // Tambah log untuk debug
                    console.log('collar_types:', this.collar_types);
                    console.log('fabric_types:', this.fabric_types);
                    console.log('sleeve_types:', this.sleeve_types);
                    console.log('collar_type input value:', this.$refs.designForm.querySelector('input[name=collar_type]').value);
                    console.log('fabric_type input value:', this.$refs.designForm.querySelector('input[name=fabric_type]').value);
                    console.log('sleeve_type input value:', this.$refs.designForm.querySelector('input[name=sleeve_type]').value);
                }
            }
        }
    </script>
</x-app-layout>