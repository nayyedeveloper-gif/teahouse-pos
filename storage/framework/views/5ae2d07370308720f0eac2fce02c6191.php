<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 myanmar-text">
                    အော်ဒါ #<?php echo e($order->order_number); ?>

                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    <?php echo e($order->created_at->format('d M Y, h:i A')); ?>

                </p>
            </div>
            <a href="<?php echo e(route('waiter.orders.index')); ?>" class="btn btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="myanmar-text">နောက်သို့</span>
            </a>
        </div>

        <!-- Order Info Card -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Table/Type -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 myanmar-text">စားပွဲ</h3>
                        <!--[if BLOCK]><![endif]--><?php if($order->table): ?>
                            <p class="text-lg font-semibold text-gray-900">
                                <span class="myanmar-text"><?php echo e($order->table->name_mm ?? $order->table->name); ?></span>
                            </p>
                        <?php else: ?>
                            <p class="text-lg font-semibold text-gray-900 myanmar-text">ပါဆယ်ယူမည်</p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Waiter -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 myanmar-text">ဝန်ထမ်း</h3>
                        <p class="text-lg font-semibold text-gray-900"><?php echo e($order->waiter->name); ?></p>
                    </div>

                    <!-- Status -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 myanmar-text">အခြေအနေ</h3>
                        <!--[if BLOCK]><![endif]--><?php if($order->status === 'pending'): ?>
                            <span class="badge badge-warning text-lg">
                                <span class="myanmar-text">စောင့်ဆိုင်းဆဲ</span>
                            </span>
                        <?php elseif($order->status === 'preparing'): ?>
                            <span class="badge badge-info text-lg">
                                <span class="myanmar-text">ပြင်ဆင်နေသည်</span>
                            </span>
                        <?php elseif($order->status === 'ready'): ?>
                            <span class="badge badge-primary text-lg">
                                <span class="myanmar-text">အဆင်သင့်</span>
                            </span>
                        <?php elseif($order->status === 'completed'): ?>
                            <span class="badge badge-success text-lg">
                                <span class="myanmar-text">ပြီးစီး</span>
                            </span>
                        <?php else: ?>
                            <span class="badge badge-danger text-lg">
                                <span class="myanmar-text">ပယ်ဖျက်</span>
                            </span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!--[if BLOCK]><![endif]--><?php if($order->notes): ?>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500 mb-2 myanmar-text">မှတ်ချက်</h3>
                        <p class="text-gray-900"><?php echo e($order->notes); ?></p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-6">
            <div class="card-header">
                <h2 class="text-lg font-bold text-gray-900 myanmar-text">အမျိုးအမည်များ</h2>
            </div>
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="myanmar-text">ပစ္စည်း</th>
                                <th class="text-center myanmar-text">အရေအတွက်</th>
                                <th class="text-right myanmar-text">ဈေးနှုန်း</th>
                                <th class="text-right myanmar-text">စုစုပေါင်း</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div>
                                            <p class="font-semibold text-gray-900"><?php echo e($orderItem->item->name); ?></p>
                                            <p class="text-sm text-gray-600 myanmar-text"><?php echo e($orderItem->item->name_mm); ?></p>
                                            <!--[if BLOCK]><![endif]--><?php if($orderItem->notes): ?>
                                                <p class="text-xs text-gray-500 italic mt-1"><?php echo e($orderItem->notes); ?></p>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if($orderItem->is_foc): ?>
                                                <span class="badge badge-success mt-1">FOC</span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-semibold"><?php echo e($orderItem->quantity); ?></span>
                                    </td>
                                    <td class="text-right">
                                        <?php echo e(number_format($orderItem->price, 0)); ?> Ks
                                    </td>
                                    <td class="text-right font-semibold">
                                        <!--[if BLOCK]><![endif]--><?php if($orderItem->is_foc): ?>
                                            <span class="text-green-600">FOC</span>
                                        <?php else: ?>
                                            <?php echo e(number_format($orderItem->subtotal, 0)); ?> Ks
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">စုစုပေါင်း</span>
                        <span class="font-semibold"><?php echo e(number_format($order->subtotal, 0)); ?> Ks</span>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if($order->tax_amount > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 myanmar-text">အခွန် (<?php echo e($order->tax_percentage); ?>%)</span>
                            <span class="font-semibold"><?php echo e(number_format($order->tax_amount, 0)); ?> Ks</span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($order->discount_amount > 0): ?>
                        <div class="flex justify-between text-sm text-red-600">
                            <span class="myanmar-text">လျှော့်ဇေး (<?php echo e($order->discount_percentage); ?>%)</span>
                            <span class="font-semibold">-<?php echo e(number_format($order->discount_amount, 0)); ?> Ks</span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($order->service_charge > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 myanmar-text">ဝန်ဆောင်ခ</span>
                            <span class="font-semibold"><?php echo e(number_format($order->service_charge, 0)); ?> Ks</span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900 myanmar-text">စုစုပေါင်း</span>
                            <span class="text-2xl font-bold text-primary-600"><?php echo e(number_format($order->total, 0)); ?> Ks</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Flash Messages -->
    <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/waiter/order-details.blade.php ENDPATH**/ ?>