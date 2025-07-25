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
            Order Details for ID: <?php echo e($design->id); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Back Button -->
                    <div class="mb-6 flex justify-between items-center">
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            &larr; Back to All Orders
                        </a>
                        
                        <?php if(!$design->invoice): ?>
                            <a href="<?php echo e(route('admin.invoices.create')); ?>?design_id=<?php echo e($design->id); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Create Invoice
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('admin.invoices.show', $design->invoice)); ?>" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                View Invoice
                            </a>
                        <?php endif; ?>
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
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e(optional($design->user)->name ?? 'User Deleted'); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e(optional($design->user)->phone ?? '-'); ?></dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e(optional($design->user)->address ?? '-'); ?></dd>
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
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($design->product_name ?? (optional($design->product)->name ?? 'Product Deleted')); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Total Quantity</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($design->total_qty); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Total Price</dt>
                                    <dd class="mt-1 text-sm text-gray-900">RM<?php echo e(number_format($design->total_price, 2)); ?></dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Design Specifications</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <div class="space-y-2">
                                            <div>
                                                <strong>Collar Types:</strong>
                                                <ul class="list-disc list-inside">
                                                <?php $__empty_1 = true; $__currentLoopData = $design->collar_type ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <li><?php echo e($item['name']); ?> (Qty: <?php echo e($item['quantity']); ?>)</li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <li>-</li>
                                                <?php endif; ?>
                                                </ul>
                                            </div>
                                            <div>
                                                <strong>Fabric Types:</strong>
                                                <ul class="list-disc list-inside">
                                                <?php $__empty_1 = true; $__currentLoopData = $design->fabric_type ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <li><?php echo e($item['name']); ?> (Qty: <?php echo e($item['quantity']); ?>)</li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <li>-</li>
                                                <?php endif; ?>
                                                </ul>
                                            </div>
                                            <div>
                                                <strong>Sleeve Types:</strong>
                                                <ul class="list-disc list-inside">
                                                <?php $__empty_1 = true; $__currentLoopData = $design->sleeve_type ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <li><?php echo e($item['name']); ?> (Qty: <?php echo e($item['quantity']); ?>)</li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <li>-</li>
                                                <?php endif; ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?> <?php /**PATH C:\xampp\htdocs\tshirt-system\resources\views/admin/order-details.blade.php ENDPATH**/ ?>