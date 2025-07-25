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
        <h2 class="font-semibold text-xl text-pastel-purple leading-tight font-sans">
            Kemaskini WhatsApp Admin
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 font-sans bg-pastel-gray min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8 border border-gray-200">
                <?php if(session('success')): ?>
                    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-200 text-sm">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
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
                    <div>
                        <label for="whatsapp_message" class="block text-sm font-medium text-gray-700 mb-1">Pesan Default</label>
                        <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-pastel-purple focus:ring focus:ring-pastel-purple/30" id="whatsapp_message" name="whatsapp_message" value="<?php echo e(old('whatsapp_message', $whatsapp_message)); ?>" required>
                        <?php $__errorArgs = ['whatsapp_message'];
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
                        <button type="submit" class="px-6 py-2 bg-pastel-purple text-white font-semibold rounded shadow hover:bg-pastel-blue hover:text-pastel-purple transition">
                            Simpan
                        </button>
                    </div>
                </form>
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
<?php endif; ?> <?php /**PATH C:\xampp\htdocs\tshirt-system\resources\views/admin/settings/whatsapp.blade.php ENDPATH**/ ?>