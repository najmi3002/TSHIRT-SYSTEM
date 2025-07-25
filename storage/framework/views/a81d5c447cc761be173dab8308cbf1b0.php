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
            <?php echo e(__('Manage Orders')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <?php
                $whatsapp_number = \App\Models\Setting::get('whatsapp_number', '');
                $whatsapp_message = \App\Models\Setting::get('whatsapp_message', '');
            ?>
            <div x-data="{ open: false }">
                <div class="flex justify-end mb-4">
                    <button @click="open = true" class="inline-block px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-700 transition">
                        Kemaskini WhatsApp Admin
                    </button>
                </div>
                <!-- Modal -->
                <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40" style="display: none;">
                    <div @click.away="open = false" class="bg-white rounded-lg shadow-lg max-w-md w-full p-8 border border-gray-200 relative">
                        <button @click="open = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
                        <h3 class="text-lg font-semibold mb-6 text-black">Kemaskini WhatsApp Admin</h3>
                        <form method="POST" action="<?php echo e(route('admin.settings.whatsapp.update')); ?>" class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp Admin</label>
                                <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-pastel-purple focus:ring focus:ring-pastel-purple/30" id="whatsapp_number" name="whatsapp_number" value="<?php echo e(old('whatsapp_number', $whatsapp_number)); ?>" required>
                                <?php $__errorArgs = ['whatsapp_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-red-500 text-xs mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-blue-500 text-black font-semibold rounded shadow hover:bg-blue-700 transition">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="" class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label for="order_id" class="block text-xs font-medium text-gray-700">Order ID</label>
                            <input type="text" name="order_id" id="order_id" value="<?php echo e(request('order_id')); ?>" class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm focus:border-pastel-purple focus:ring focus:ring-pastel-purple/30">
                        </div>
                        <div>
                            <label for="customer_name" class="block text-xs font-medium text-gray-700">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" value="<?php echo e(request('customer_name')); ?>" class="mt-1 block w-48 rounded-md border-gray-300 shadow-sm focus:border-pastel-purple focus:ring focus:ring-pastel-purple/30">
                        </div>
                        <div>
                            <label for="order_date" class="block text-xs font-medium text-gray-700">Order Date</label>
                            <input type="date" name="order_date" id="order_date" value="<?php echo e(request('order_date')); ?>" class="mt-1 block w-44 rounded-md border-gray-300 shadow-sm focus:border-pastel-purple focus:ring focus:ring-pastel-purple/30">
                        </div>
                        <div>
                            <button type="submit" class="px-6 py-2 bg-blue-500 text-black font-semibold rounded shadow hover:bg-blue-600 hover:text-white transition">Filter</button>
                            <a href="<?php echo e(route('admin.orders.index')); ?>" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Custom Design Orders -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Custom Design Orders</h3>
                    <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Design ID</th>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Design Image</th>
                                <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Details</th>
                                <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deposit Proof</th>
                                <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Payment Proof</th>
                                <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chat</th>
                                <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                                <?php $__empty_1 = true; $__currentLoopData = $customDesigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $design): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border border-gray-300"><?php echo e($design->id); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300"><?php echo e(optional($design->user)->name ?? 'N/A'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                            <?php if($design->design_path): ?>
                                                <a href="<?php echo e(asset('storage/' . $design->design_path)); ?>" target="_blank">
                                                    <img src="<?php echo e(asset('storage/' . $design->design_path)); ?>" alt="Design Image" class="h-16 w-16 object-cover rounded">
                                                </a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-500 border border-gray-300">
                                            <a href="<?php echo e(route('admin.orders.show', $design->id)); ?>" class="hover:underline">View Details</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                            <form action="<?php echo e(route('admin.orders.updateStatus', $design->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                                                    <?php $__currentLoopData = ['Deposit Pending', 'Full Payment Pending', 'In Progress', 'Complete', 'Pending', 'Deposit Paid', 'Fully Paid']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($status); ?>" <?php if($design->status == $status): ?> selected <?php endif; ?>><?php echo e($status); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                            <?php if($design->deposit_proof_path): ?>
                                                <a href="<?php echo e(asset('storage/' . $design->deposit_proof_path)); ?>" target="_blank" class="text-blue-500 hover:underline">View</a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                            <?php if($design->fullpayment_proof_path): ?>
                                                <a href="<?php echo e(asset('storage/' . $design->fullpayment_proof_path)); ?>" target="_blank" class="text-blue-500 hover:underline">View</a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-500 border border-gray-300">
                                            <?php
                                                $customerPhone = optional($design->user)->phone;
                                                $waPhone = $customerPhone ? preg_replace('/[^0-9]/', '', $customerPhone) : '';
                                                if (strpos($waPhone, '0') === 0) {
                                                    $waPhone = '60' . ltrim($waPhone, '0');
                                                }
                                                $msg = 'Hi ' . (optional($design->user)->name ?? '') . ', admin ingin berbincang tentang order anda. ID: ' . $design->id . ', Nama Baju: ' . ($design->product_name ?? ($design->product->name ?? 'Custom Design'));
                                                $waMsg = urlencode($msg);
                                            ?>
                                            <?php if($waPhone): ?>
                                                <a href="https://wa.me/<?php echo e($waPhone); ?>?text=<?php echo e($waMsg); ?>" target="_blank" class="text-green-600 hover:underline font-bold">Chat</a>
                                            <?php else: ?>
                                                <span class="text-gray-400">No phone</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300"><?php echo e($design->created_at->format('Y-m-d')); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center border border-gray-300">
                                            <form action="<?php echo e(route('admin.orders.destroy', $design->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="10" class="text-center py-4">No custom design orders found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Standard Orders -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Standard Orders</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Design ID</th>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Details</th>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deposit Proof</th>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Payment Proof</th>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chat</th>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 border border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php $__empty_1 = true; $__currentLoopData = $standardOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $design): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border border-gray-300"><?php echo e($design->id); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300"><?php echo e(optional($design->user)->name ?? 'N/A'); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-500 border border-gray-300">
                                        <a href="<?php echo e(route('admin.orders.show', $design->id)); ?>" class="hover:underline">View Details</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                        <form action="<?php echo e(route('admin.orders.updateStatus', $design->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                                                <?php $__currentLoopData = ['Deposit Pending', 'Full Payment Pending', 'In Progress', 'Complete', 'Pending', 'Deposit Paid', 'Fully Paid']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($status); ?>" <?php if($design->status == $status): ?> selected <?php endif; ?>><?php echo e($status); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                        <?php if($design->deposit_proof_path): ?>
                                            <a href="<?php echo e(asset('storage/' . $design->deposit_proof_path)); ?>" target="_blank" class="text-blue-500 hover:underline">View</a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                        <?php if($design->fullpayment_proof_path): ?>
                                            <a href="<?php echo e(asset('storage/' . $design->fullpayment_proof_path)); ?>" target="_blank" class="text-blue-500 hover:underline">View</a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-500 border border-gray-300">
                                        <?php
                                            $customerPhone = optional($design->user)->phone;
                                            $waPhone = $customerPhone ? preg_replace('/[^0-9]/', '', $customerPhone) : '';
                                            if (strpos($waPhone, '0') === 0) {
                                                $waPhone = '60' . ltrim($waPhone, '0');
                                            }
                                            $msg = 'Hi ' . (optional($design->user)->name ?? '') . ', admin ingin berbincang tentang order anda. ID: ' . $design->id . ', Nama Baju: ' . ($design->product_name ?? ($design->product->name ?? 'Custom Design'));
                                            $waMsg = urlencode($msg);
                                        ?>
                                        <?php if($waPhone): ?>
                                            <a href="https://wa.me/<?php echo e($waPhone); ?>?text=<?php echo e($waMsg); ?>" target="_blank" class="text-green-600 hover:underline font-bold">Chat</a>
                                        <?php else: ?>
                                            <span class="text-gray-400">No phone</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-300"><?php echo e($design->created_at->format('Y-m-d')); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center border border-gray-300">
                                        <form action="<?php echo e(route('admin.orders.destroy', $design->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="9" class="text-center py-4">No standard orders found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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
<?php endif; ?> <?php /**PATH C:\xampp\htdocs\tshirt-system\resources\views/admin/orders.blade.php ENDPATH**/ ?>