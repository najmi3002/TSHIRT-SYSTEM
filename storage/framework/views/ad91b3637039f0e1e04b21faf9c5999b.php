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
                Invoice #<?php echo e($invoice->invoice_number); ?>

            </h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.invoices.pdf', $invoice)); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Download PDF
                </a>
                <a href="<?php echo e(route('admin.invoices.edit', $invoice)); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Invoice
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="<?php echo e(route('admin.invoices.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            &larr; Back to Invoices
                        </a>
                    </div>

                    <!-- Invoice Header -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">INVOICE</h1>
                                <p class="text-gray-600 mt-2">Invoice #<?php echo e($invoice->invoice_number); ?></p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-600">Invoice Date</div>
                                <div class="text-lg font-semibold"><?php echo e($invoice->invoice_date->format('M d, Y')); ?></div>
                                <div class="text-sm text-gray-600 mt-2">Due Date</div>
                                <div class="text-lg font-semibold <?php echo e($invoice->isOverdue() ? 'text-red-600' : ''); ?>">
                                    <?php echo e($invoice->due_date->format('M d, Y')); ?>

                                    <?php if($invoice->isOverdue()): ?>
                                        <span class="text-red-600">(Overdue)</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Bill To:</h3>
                            <div class="text-gray-700">
                                <p class="font-semibold"><?php echo e($invoice->customer_name); ?></p>
                                <p><?php echo e($invoice->customer_email); ?></p>
                                <p><?php echo e($invoice->customer_phone); ?></p>
                                <p class="mt-2"><?php echo e($invoice->customer_address); ?></p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">From:</h3>
                            <div class="text-gray-700">
                                <p class="font-semibold">T-SHIRT SYSTEM SDN BHD</p>
                                <p>No2 Tingkat 1, Jalan Pulai Indah Satu, Taman Pulai Indah,</p>
                                <p>Kangar, Perlis, 01000</p>
                                <p>Phone: +60 13-656 1726</p>
                                <p>Email: milestones7979@gmail.com</p>
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
                                        <?php echo e($invoice->product_name); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        <?php echo e($invoice->quantity); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        RM<?php echo e(number_format($invoice->unit_price, 2)); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        RM<?php echo e(number_format($invoice->subtotal, 2)); ?>

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
                                    <span class="font-semibold">RM<?php echo e(number_format($invoice->subtotal, 2)); ?></span>
                                </div>
                                <?php if($invoice->tax_amount > 0): ?>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tax:</span>
                                        <span class="font-semibold">RM<?php echo e(number_format($invoice->tax_amount, 2)); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if($invoice->discount_amount > 0): ?>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Discount:</span>
                                        <span class="font-semibold text-green-600">-RM<?php echo e(number_format($invoice->discount_amount, 2)); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="border-t border-gray-200 pt-2">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-semibold">Total:</span>
                                        <span class="text-lg font-bold">RM<?php echo e(number_format($invoice->total_amount, 2)); ?></span>
                                    </div>
                                </div>
                                <?php if($invoice->deposit_amount > 0): ?>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Deposit Paid:</span>
                                        <span class="font-semibold text-green-600">RM<?php echo e(number_format($invoice->deposit_amount, 2)); ?></span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-2">
                                        <div class="flex justify-between">
                                            <span class="text-lg font-semibold">Balance Due:</span>
                                            <span class="text-lg font-bold text-red-600">RM<?php echo e(number_format($invoice->balance_amount, 2)); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Payment Status</h4>
                                <p class="text-gray-600">Current status: 
                                    <span class="font-semibold 
                                        <?php if($invoice->payment_status === 'paid'): ?> text-green-600
                                        <?php elseif($invoice->payment_status === 'partial'): ?> text-yellow-600
                                        <?php else: ?> text-red-600 <?php endif; ?>">
                                        <?php echo e(ucfirst($invoice->payment_status)); ?>

                                    </span>
                                </p>
                            </div>
                            <div class="space-x-2">
                                <?php if($invoice->payment_status !== 'paid'): ?>
                                    <form method="POST" action="<?php echo e(route('admin.invoices.mark-paid', $invoice)); ?>" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Mark as Paid
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <?php if($invoice->invoice_status === 'draft'): ?>
                                    <form method="POST" action="<?php echo e(route('admin.invoices.send', $invoice)); ?>" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Send Invoice
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <?php if($invoice->notes): ?>
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Notes</h4>
                            <p class="text-gray-700"><?php echo e($invoice->notes); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Terms & Conditions -->
                    <?php if($invoice->terms_conditions): ?>
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Terms & Conditions</h4>
                            <p class="text-gray-700 text-sm"><?php echo e($invoice->terms_conditions); ?></p>
                        </div>
                    <?php endif; ?>

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
<?php endif; ?> <?php /**PATH C:\xampp\htdocs\tshirt-system\tshirt-system\resources\views/admin/invoices/show.blade.php ENDPATH**/ ?>