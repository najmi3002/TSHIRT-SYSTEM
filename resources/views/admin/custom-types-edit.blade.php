<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight font-sans">
            {{ __('Update Available Types for Custom Designs') }}
        </h2>
    </x-slot>
    <div class="py-12 font-sans bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 border border-black">

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
                @endif
                
                <form action="{{ route('admin.custom-types.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Collar Section -->
                        <div class="p-6 border border-gray-200 rounded-xl space-y-4 bg-gray-50">
                            <label class="block font-semibold text-black text-center text-lg">Collar Types</label>
                            <div id="collar-types" class="space-y-3"></div>
                            <button type="button" onclick="addTypeRow('collar')" class="w-full mt-2 py-2 px-4 border border-dashed border-gray-300 rounded-lg text-sm text-black hover:bg-gray-100 hover:border-gray-400 transition">+ Add Collar</button>
                        </div>
                        <!-- Fabric Section -->
                        <div class="p-6 border border-gray-200 rounded-xl space-y-4 bg-gray-50">
                            <label class="block font-semibold text-black text-center text-lg">Fabric Types</label>
                            <div id="fabric-types" class="space-y-3"></div>
                             <button type="button" onclick="addTypeRow('fabric')" class="w-full mt-2 py-2 px-4 border border-dashed border-gray-300 rounded-lg text-sm text-black hover:bg-gray-100 hover:border-gray-400 transition">+ Add Fabric</button>
                        </div>
                        <!-- Sleeve Section -->
                        <div class="p-6 border border-gray-200 rounded-xl space-y-4 bg-gray-50">
                            <label class="block font-semibold text-black text-center text-lg">Sleeve Types</label>
                            <div id="sleeve-types" class="space-y-3"></div>
                            <button type="button" onclick="addTypeRow('sleeve')" class="w-full mt-2 py-2 px-4 border border-dashed border-gray-300 rounded-lg text-sm text-black hover:bg-gray-100 hover:border-gray-400 transition">+ Add Sleeve</button>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end pt-6 space-x-4 border-t mt-8">
                        <a href="{{ url('/admin/products') }}" class="bg-gray-200 text-black font-bold py-3 px-6 rounded-lg shadow-sm hover:bg-gray-300 transition-colors">Back to Products</a>
                        <button type="submit" class="bg-gray-200 text-black font-bold py-3 px-6 rounded-lg shadow-md hover:bg-gray-300 transition-colors">Update Types</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const product = @json($product);

        function addTypeRow(type, item = { name: '', addon_price: 0 }) {
            let container, name, price, placeholder, index;
            const typeName = `${type}_type`;
            
            container = document.getElementById(`${type}-types`);
            index = container.children.length;

            name = `${typeName}[${index}][name]`;
            price = `${typeName}[${index}][addon_price]`;
            
            if(type === 'collar') placeholder = "e.g. V-Neck";
            else if(type === 'fabric') placeholder = "e.g. Cotton";
            else placeholder = "e.g. Long Sleeve";

            let div = document.createElement('div');
            div.className = 'p-3 border border-gray-300 rounded-lg flex items-center gap-3 bg-white shadow-sm';
            div.innerHTML = `
                <div class="flex-grow">
                    <input type="text" name="${name}" placeholder="${placeholder}" value="${item.name}" class="border-gray-300 rounded-md p-2 w-full text-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="w-36">
                     <input type="number" name="${price}" placeholder="Add-on (RM)" value="${item.addon_price}" class="border-gray-300 rounded-md p-2 w-full text-sm focus:ring-blue-500 focus:border-blue-500" step="0.01" min="0" required>
                </div>
                <button type="button" onclick="this.closest('div').remove()" class="flex-shrink-0 bg-red-500 text-white w-8 h-8 rounded-full font-bold text-lg hover:bg-red-600 flex items-center justify-center transition-colors">&times;</button>
            `;
            container.appendChild(div);
        }

        function initializeForm() {
            const types = ['collar', 'fabric', 'sleeve'];
            types.forEach(type => {
                const container = document.getElementById(`${type}-types`);
                container.innerHTML = '';
                const typeData = product[`${type}_type`] || [];
                if (Array.isArray(typeData) && typeData.length > 0) {
                    typeData.forEach(item => {
                        addTypeRow(type, item);
                    });
                } else {
                    addTypeRow(type); // Add one empty row if no data
                }
            });
        }
        
        document.addEventListener('DOMContentLoaded', initializeForm);
    </script>
</x-app-layout> 