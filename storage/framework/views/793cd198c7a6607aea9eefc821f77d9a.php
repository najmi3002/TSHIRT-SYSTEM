<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e($product->name); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16">

                <!-- Product Image -->
                <div class="flex items-center justify-center bg-white rounded-lg shadow-lg p-6">
                    <img src="<?php echo e(asset('storage/'.$product->image_path)); ?>" alt="<?php echo e($product->name); ?>" class="object-contain max-h-96 w-full">
                </div>

                <!-- Product Details and Form -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h1 class="text-3xl font-bold text-gray-900"><?php echo e($product->name); ?></h1>
                    <p class="mt-4 text-gray-600"><?php echo e($product->description ?? 'A high-quality t-shirt with a clean and bold look.'); ?></p>
                    <p class="text-3xl font-light text-gray-900 mt-6">RM<?php echo e(number_format($product->price, 2)); ?></p>
                    
                    <form id="choose-form" action="/designs" method="POST" class="w-full mt-8">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        
                        <!-- Master Quantity -->
                        <div class="mb-6">
                            <label for="master-qty" class="font-semibold text-sm mb-2 block text-gray-700">Total Quantity</label>
                            <input type="number" id="master-qty" name="total_qty" min="1" value="1" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        </div>

                        <!-- Options Separator -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="space-y-6">
                                <!-- Collar -->
                                <div>
                                    <label class="font-semibold text-sm mb-1 flex justify-between items-center text-gray-700">
                                        <span>Collar Types</span>
                                        <span id="collar-qty-status" class="text-xs font-bold bg-gray-200 px-2 py-1 rounded-full"></span>
                                    </label>
                                    <div id="collar-rows" class="space-y-2 mt-2"></div>
                                    <button type="button" class="add-row-btn text-xs text-indigo-600 hover:text-indigo-900 font-semibold mt-2" data-type="collar">+ Add Collar</button>
                                </div>
                                <!-- Fabric -->
                                <div>
                                    <label class="font-semibold text-sm mb-1 flex justify-between items-center text-gray-700">
                                        <span>Fabric Types</span>
                                        <span id="fabric-qty-status" class="text-xs font-bold bg-gray-200 px-2 py-1 rounded-full"></span>
                                    </label>
                                    <div id="fabric-rows" class="space-y-2 mt-2"></div>
                                    <button type="button" class="add-row-btn text-xs text-indigo-600 hover:text-indigo-900 font-semibold mt-2" data-type="fabric">+ Add Fabric</button>
                                </div>
                                <!-- Sleeve -->
                                <div>
                                    <label class="font-semibold text-sm mb-1 flex justify-between items-center text-gray-700">
                                        <span>Sleeve Types</span>
                                        <span id="sleeve-qty-status" class="text-xs font-bold bg-gray-200 px-2 py-1 rounded-full"></span>
                                    </label>
                                    <div id="sleeve-rows" class="space-y-2 mt-2"></div>
                                    <button type="button" class="add-row-btn text-xs text-indigo-600 hover:text-indigo-900 font-semibold mt-2" data-type="sleeve">+ Add Sleeve</button>
                                </div>
                            </div>
                        </div>

                        <!-- Totals & Submit -->
                        <div class="w-full mt-8 border-t border-gray-200 pt-6">
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Addon Price:</span>
                                <span class="font-medium">RM <span id="total-addon-harga">0.00</span></span>
                            </div>
                            <div class="flex justify-between items-center text-xl font-bold text-gray-900 mt-2">
                                <span>Total Price:</span>
                                <span>RM <span id="total-harga">0.00</span></span>
                            </div>
                            <div id="validation-message" class="text-sm text-red-600 font-semibold mt-4 min-h-[1.25rem]"></div>
                            <button type="button" id="choose-btn" class="mt-4 w-full bg-white text-black border-2 border-black font-bold py-3 px-4 rounded-md shadow-lg text-lg hover:bg-gray-100 disabled:bg-gray-400 disabled:text-white disabled:border-gray-400 disabled:cursor-not-allowed transition-all duration-300">Place Order</button>
                        </div>

                        <input type="hidden" name="collar_type">
                        <input type="hidden" name="fabric_type">
                        <input type="hidden" name="sleeve_type">
                        <input type="hidden" name="total_price">
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const product = <?php echo json_encode($product, 15, 512) ?>;
    const basePrice = parseFloat(product.price);
    const masterQtyInput = document.getElementById('master-qty');
    const chooseBtn = document.getElementById('choose-btn');
    const validationMsg = document.getElementById('validation-message');
    const isLoggedIn = <?php echo e(Auth::check() ? 'true' : 'false'); ?>;
    const currentUrl = window.location.pathname + window.location.search;

    const typeOptions = {
        collar: (product.collar_type || []).map(type => `<option value="${type.name}" data-addon="${type.addon_price}">${type.name} (+RM${parseFloat(type.addon_price).toFixed(2)})</option>`).join(''),
        fabric: (product.fabric_type || []).map(type => `<option value="${type.name}" data-addon="${type.addon_price}">${type.name} (+RM${parseFloat(type.addon_price).toFixed(2)})</option>`).join(''),
        sleeve: (product.sleeve_type || []).map(type => `<option value="${type.name}" data-addon="${type.addon_price}">${type.name} (+RM${parseFloat(type.addon_price).toFixed(2)})</option>`).join('')
    };

    function addRow(type, isFirst = false) {
        const container = document.getElementById(type + '-rows');
        const newRow = document.createElement('div');
        newRow.className = 'flex items-center gap-2 dynamic-row';
        let removeBtnHtml = isFirst ? '' : `<button type="button" class="remove-row-btn text-red-500 hover:text-red-700 font-bold text-xl leading-none">&times;</button>`;

        newRow.innerHTML = `
            <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm w-full">
                <option value="">Select Type</option>
                ${typeOptions[type]}
            </select>
            <input type="number" min="1" value="1" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-24 text-sm qty-input" placeholder="Qty">
            ${removeBtnHtml}
        `;
        container.appendChild(newRow);
        attachRowListeners(newRow);
    }

    function attachRowListeners(row) {
        row.querySelector('.qty-input').addEventListener('input', updateTotals);
        row.querySelector('select').addEventListener('change', updateTotals);
        const removeBtn = row.querySelector('.remove-row-btn');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                row.remove();
                updateTotals();
            });
        }
    }

    masterQtyInput.addEventListener('input', function() {
        const masterQty = parseInt(this.value) || 1;

        // Auto-update the first row of each type
        ['collar', 'fabric', 'sleeve'].forEach(type => {
            const firstRowQtyInput = document.querySelector(`#${type}-rows .dynamic-row:first-child .qty-input`);
            if (firstRowQtyInput) {
                firstRowQtyInput.value = masterQty;
            }
        });
        
        updateTotals();
    });

    function updateTotals() {
        const masterQty = parseInt(masterQtyInput.value) || 0;
        let addonPrice = 0;
        let isQtyValid = true;
        let validationMessages = [];

        ['collar', 'fabric', 'sleeve'].forEach(type => {
            const container = document.getElementById(type + '-rows');
            let currentQty = 0;
            container.querySelectorAll('.dynamic-row').forEach(row => {
                const qty = parseInt(row.querySelector('.qty-input').value) || 0;
                const select = row.querySelector('select');
                const selectedOption = select.options[select.selectedIndex];
                
                if (select.value) {
                    const addon = parseFloat(selectedOption.dataset.addon) || 0;
                    addonPrice += qty * addon;
                }
                currentQty += qty;
            });
            
            const statusEl = document.getElementById(type + '-qty-status');
            statusEl.textContent = `${currentQty}/${masterQty}`;
            if (masterQty > 0 && currentQty !== masterQty) {
                isQtyValid = false;
                statusEl.classList.add('text-red-500');
                statusEl.classList.remove('text-green-500');
                validationMessages.push(`Total ${type} quantity must match Total Quantity.`);
            } else {
                statusEl.classList.add('text-green-500');
                statusEl.classList.remove('text-red-500');
            }
        });

        const totalPrice = (basePrice * masterQty) + addonPrice;

        document.getElementById('total-addon-harga').textContent = addonPrice.toFixed(2);
        document.getElementById('total-harga').textContent = totalPrice.toFixed(2);
        
        validationMsg.innerHTML = validationMessages.join('<br>');
        chooseBtn.disabled = !isQtyValid || masterQty <= 0;
    }

    document.querySelectorAll('.add-row-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            addRow(this.dataset.type);
            updateTotals();
        });
    });
    
    chooseBtn.addEventListener('click', function() {
        if (this.disabled) return;
        if (!isLoggedIn) {
            window.location.href = '/register?intended=' + encodeURIComponent(currentUrl);
            return;
        }
        const form = document.getElementById('choose-form');
        
        function collectDataFor(type) {
            const items = [];
            document.querySelectorAll(`#${type}-rows .dynamic-row`).forEach(row => {
                const select = row.querySelector('select');
                const qtyInput = row.querySelector('input[type=number]');
                if (select.value && qtyInput.value > 0) {
                    items.push({
                        name: select.value,
                        quantity: parseInt(qtyInput.value)
                    });
                }
            });
            return items;
        }

        form.querySelector('input[name=collar_type]').value = JSON.stringify(collectDataFor('collar'));
        form.querySelector('input[name=fabric_type]').value = JSON.stringify(collectDataFor('fabric'));
        form.querySelector('input[name=sleeve_type]').value = JSON.stringify(collectDataFor('sleeve'));
        form.querySelector('input[name=total_price]').value = document.getElementById('total-harga').textContent;
        
        form.submit();
    });

    // Initialize
    ['collar', 'fabric', 'sleeve'].forEach(type => addRow(type, true));
    masterQtyInput.dispatchEvent(new Event('input')); // Trigger distribution to set initial quantities
    updateTotals();
});
</script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\tshirt-system\tshirt-system\resources\views/customer/product.blade.php ENDPATH**/ ?>