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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Manage Products')); ?>

        </h2
        </div>
     <?php $__env->endSlot(); ?>
    <div x-data="productManager()" @keydown.escape.window="showModal = false" class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <?php if(session('success')): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow"><?php echo e(session('success')); ?></div>
                <?php endif; ?>
                
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="" class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label for="product_id" class="block text-xs font-medium text-gray-700">Order ID</label>
                            <input type="text" name="product_id" id="product_id" value="<?php echo e(request('product_id')); ?>" class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label for="product_name" class="block text-xs font-medium text-gray-700">Product Name</label>
                            <input type="text" name="product_name" id="product_name" value="<?php echo e(request('product_name')); ?>" class="mt-1 block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <button type="submit" class="px-6 py-2 bg-blue-500 text-black font-semibold rounded shadow hover:bg-blue-600 hover:text-white transition">Filter</button>
                            <a href="<?php echo e(url()->current()); ?>" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Product List</h3>
                    <div class="flex space-x-3">
                        <button @click="openModal(true)" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition-colors flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        <span>Add New Product</span>
                    </button>
                    </div>
                </div>

                <!-- Modal -->
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-800 bg-opacity-60 overflow-y-auto h-full w-full flex items-center justify-center z-50" style="display: none;">
                    <div @click.away="showModal = false" class="relative mx-auto p-8 border w-full max-w-4xl shadow-2xl rounded-2xl bg-white">
                        <h3 class="text-2xl font-bold text-black text-center mb-6" x-text="isNewProduct ? 'Add New Product' : 'Edit Product'"></h3>
                        <form :action="formAction" method="POST" enctype="multipart/form-data" class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <template x-if="!isNewProduct">
                                <?php echo method_field('PUT'); ?>
                            </template>
                            
                            <!-- Product Details Section -->
                            <div class="p-6 border border-gray-200 rounded-xl bg-gray-50">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                                    <div class="space-y-6">
                                        <div>
                                            <label class="block font-semibold mb-2 text-black">Product Name</label>
                                            <input type="text" name="name" x-model="product.name" required class="border-gray-300 rounded-lg p-3 w-full focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. Volta Premium">
                                        </div>
                                        <div>
                                            <label class="block font-semibold mb-2 text-black">Base Price (RM)</label>
                                            <input type="number" name="price" x-model="product.price" required class="border-gray-300 rounded-lg p-3 w-full focus:ring-blue-500 focus:border-blue-500" step="0.01" min="0" placeholder="e.g. 45.00">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block font-semibold mb-2 text-black">Product Image</label>
                                        <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*" :required="isNewProduct">
                                        <p class="text-xs text-gray-500 mt-2" x-show="!isNewProduct">Leave blank to keep the current image.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic Types Sections -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Collar Section -->
                                <div class="p-4 border border-gray-200 rounded-xl space-y-3 bg-white">
                                    <label class="block font-semibold text-black text-center">Collar Types</label>
                                    <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                                        <template x-for="(type, index) in product.collar_type" :key="index">
                                            <div class="p-3 border border-gray-200 rounded-lg flex items-center gap-3 bg-white">
                                                <div class="flex-grow">
                                                    <input type="text" :name="'collar_type[' + index + '][name]'" x-model="type.name" placeholder="e.g. V-Neck" class="border-gray-300 rounded-md p-2 w-full text-sm">
                                                </div>
                                                <div class="w-36">
                                                    <input type="number" :name="'collar_type[' + index + '][addon_price]'" x-model="type.addon_price" placeholder="Add-on (RM)" class="border-gray-300 rounded-md p-2 w-full text-sm" step="0.01" min="0">
                                                </div>
                                                <button type="button" @click="removeType('collar_type', index)" class="flex-shrink-0 bg-gray-200 text-black w-8 h-8 rounded-full font-bold text-lg hover:bg-gray-300 flex items-center justify-center">-</button>
                                            </div>
                                        </template>
                                    </div>
                                    <button type="button" @click="addType('collar_type')" class="w-full mt-2 py-2 px-4 border border-dashed border-gray-300 rounded-lg text-sm text-black hover:bg-gray-50">+ Add Collar</button>
                                </div>
                                <!-- Fabric Section -->
                                <div class="p-4 border border-gray-200 rounded-xl space-y-3 bg-white">
                                    <label class="block font-semibold text-black text-center">Fabric Types</label>
                                    <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                                        <template x-for="(type, index) in product.fabric_type" :key="index">
                                             <div class="p-3 border border-gray-200 rounded-lg flex items-center gap-3 bg-white">
                                                <div class="flex-grow">
                                                    <input type="text" :name="'fabric_type[' + index + '][name]'" x-model="type.name" placeholder="e.g. Cotton" class="border-gray-300 rounded-md p-2 w-full text-sm">
                                                </div>
                                                <div class="w-36">
                                                    <input type="number" :name="'fabric_type[' + index + '][addon_price]'" x-model="type.addon_price" placeholder="Add-on (RM)" class="border-gray-300 rounded-md p-2 w-full text-sm" step="0.01" min="0">
                                                </div>
                                                <button type="button" @click="removeType('fabric_type', index)" class="flex-shrink-0 bg-gray-200 text-black w-8 h-8 rounded-full font-bold text-lg hover:bg-gray-300 flex items-center justify-center">-</button>
                                            </div>
                                        </template>
                                    </div>
                                     <button type="button" @click="addType('fabric_type')" class="w-full mt-2 py-2 px-4 border border-dashed border-gray-300 rounded-lg text-sm text-black hover:bg-gray-50">+ Add Fabric</button>
                                </div>
                                <!-- Sleeve Section -->
                                <div class="p-4 border border-gray-200 rounded-xl space-y-3 bg-white">
                                    <label class="block font-semibold text-black text-center">Sleeve Types</label>
                                     <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                                        <template x-for="(type, index) in product.sleeve_type" :key="index">
                                            <div class="p-3 border border-gray-200 rounded-lg flex items-center gap-3 bg-white">
                                                <div class="flex-grow">
                                                    <input type="text" :name="'sleeve_type[' + index + '][name]'" x-model="type.name" placeholder="e.g. Long Sleeve" class="border-gray-300 rounded-md p-2 w-full text-sm">
                                                </div>
                                                <div class="w-36">
                                                    <input type="number" :name="'sleeve_type[' + index + '][addon_price]'" x-model="type.addon_price" placeholder="Add-on (RM)" class="border-gray-300 rounded-md p-2 w-full text-sm" step="0.01" min="0">
                                                </div>
                                                <button type="button" @click="removeType('sleeve_type', index)" class="flex-shrink-0 bg-gray-200 text-black w-8 h-8 rounded-full font-bold text-lg hover:bg-gray-300 flex items-center justify-center">-</button>
                                            </div>
                                        </template>
                                    </div>
                                    <button type="button" @click="addType('sleeve_type')" class="w-full mt-2 py-2 px-4 border border-dashed border-gray-300 rounded-lg text-sm text-black hover:bg-gray-50">+ Add Sleeve</button>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex items-center justify-end pt-6 space-x-4 border-t mt-8">
                                <button type="button" @click="showModal = false" class="bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-lg shadow-sm hover:bg-gray-300 transition-colors">Cancel</button>
                                <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition-colors" x-text="isNewProduct ? 'Add Product' : 'Update Product'"></button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name & Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available Types</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold"><?php echo e($product->id); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="<?php echo e(asset('storage/'.$product->image_path)); ?>" alt="Product Image" class="h-16 w-16 object-cover rounded-md shadow-sm">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900"><?php echo e($product->name); ?></div>
                                        <div class="text-sm text-gray-500">RM<?php echo e(number_format($product->price, 2)); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            <?php if(is_array($product->collar_type)): ?>
                                                <?php $__currentLoopData = $product->collar_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <?php echo e($type['name']); ?> (+<?php echo e(number_format($type['addon_price'], 2)); ?>)
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            <?php if(is_array($product->fabric_type)): ?>
                                                <?php $__currentLoopData = $product->fabric_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <?php echo e($type['name']); ?> (+<?php echo e(number_format($type['addon_price'], 2)); ?>)
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            <?php if(is_array($product->sleeve_type)): ?>
                                                <?php $__currentLoopData = $product->sleeve_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <?php echo e($type['name']); ?> (+<?php echo e(number_format($type['addon_price'], 2)); ?>)
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($product->created_at->format('Y-m-d')); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-3">
                                            <button @click="openModal(false, <?php echo e(json_encode($product)); ?>)" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</button>
                                            <form action="<?php echo e(url('/admin/products/'.$product->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-sm text-gray-500">No products found. Start by adding a new one!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
    <script>
        function productManager() {
            return {
                showModal: false,
                isNewProduct: true,
                formAction: '<?php echo e(url('/admin/products')); ?>',
                product: {},
                
                openModal(isNew, productData = null) {
                    this.isNewProduct = isNew;
                    if (isNew) {
                        this.formAction = '<?php echo e(url('/admin/products')); ?>';
                        this.product = {
                            name: '',
                            price: '',
                            collar_type: [{ name: '', addon_price: '' }],
                            fabric_type: [{ name: '', addon_price: '' }],
                            sleeve_type: [{ name: '', addon_price: '' }]
                        };
                    } else {
                        this.formAction = '<?php echo e(url('/admin/products')); ?>/' + productData.id;
                        this.product = JSON.parse(JSON.stringify(productData)); // Deep copy
                        // Ensure type arrays exist and are not empty
                        if (!this.product.collar_type || this.product.collar_type.length === 0) this.product.collar_type = [{ name: '', addon_price: '' }];
                        if (!this.product.fabric_type || this.product.fabric_type.length === 0) this.product.fabric_type = [{ name: '', addon_price: '' }];
                        if (!this.product.sleeve_type || this.product.sleeve_type.length === 0) this.product.sleeve_type = [{ name: '', addon_price: '' }];
                    }
                    this.showModal = true;
                },

                addType(typeKey) {
                    if (!this.product[typeKey]) {
                        this.product[typeKey] = [];
                    }
                    this.product[typeKey].push({ name: '', addon_price: '' });
                },

                removeType(typeKey, index) {
                    if (this.product[typeKey] && this.product[typeKey].length > 1) {
                        this.product[typeKey].splice(index, 1);
                    } else if (this.product[typeKey] && this.product[typeKey].length === 1) {
                        // Clear the fields instead of removing the last row
                        this.product[typeKey][index] = { name: '', addon_price: '' };
                    }
                }
            }
        }
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?> <?php /**PATH C:\xampp\htdocs\tshirt-system\tshirt-system\resources\views/admin/products.blade.php ENDPATH**/ ?>