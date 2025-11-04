<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 myanmar-text">အော်ဒါများ</h2>
            <p class="mt-1 text-sm text-gray-600 myanmar-text">အော်ဒါများကို ကြည့်ရှုနိုင်ပါသည်။</p>
        </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 md:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရှာဖွေရန်</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="အော်ဒါနံပါတ်..." class="input">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အခြေအနေ</label>
                <select wire:model.live="statusFilter" class="input">
                    <option value="">အားလုံး</option>
                    <option value="pending">စောင့်ဆိုင်းဆဲ / Pending</option>
                    <option value="completed">ငွေရှင်းပြီး / Completed</option>
                    <option value="cancelled">ပယ်ဖျက် / Cancelled</option>
                </select>
            </div>

            <!-- Table Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">စားပွဲ</label>
                <select wire:model.live="tableFilter" class="input">
                    <option value="">အားလုံး</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($table->id); ?>"><?php echo e($table->name_mm); ?> / <?php echo e($table->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>

            <!-- Date Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရက်စွဲ</label>
                <select wire:model.live="dateFilter" class="input">
                    <option value="today">ယနေ့ / Today</option>
                    <option value="yesterday">မနေ့က / Yesterday</option>
                    <option value="week">ဤအပတ် / This Week</option>
                    <option value="month">ဤလ / This Month</option>
                    <option value="">အားလုံး / All</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Orders Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition-shadow cursor-pointer"
             wire:click="viewOrder(<?php echo e($order->id); ?>)">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900"><?php echo e($order->order_number); ?></h3>
                        <p class="text-sm text-gray-500 myanmar-text">
                            <?php echo e($order->order_type === 'dine_in' ? 'ဆိုင်တွင်းစားမည်' : 'ပါဆယ်ယူမည်'); ?>

                        </p>
                    </div>
                    <div>
                        <!--[if BLOCK]><![endif]--><?php if($order->status === 'pending'): ?>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 myanmar-text">
                            စောင့်ဆိုင်းဆဲ
                        </span>
                        <?php elseif($order->status === 'completed'): ?>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 myanmar-text">
                            ပြီးစီး
                        </span>
                        <?php else: ?>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 myanmar-text">
                            ပယ်ဖျက်
                        </span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <div class="space-y-2 mb-4">
                    <!--[if BLOCK]><![endif]--><?php if($order->table): ?>
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-600 myanmar-text">စားပွဲ:</span>
                        <span class="ml-2 font-medium myanmar-text"><?php echo e($order->table->name_mm); ?></span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="text-gray-600 myanmar-text">ပစ္စည်းများ:</span>
                        <span class="ml-2 font-medium"><?php echo e($order->orderItems->count()); ?> <span class="myanmar-text">မျိုး</span></span>
                    </div>

                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-600 myanmar-text">အချိန်:</span>
                        <span class="ml-2 font-medium"><?php echo e($order->created_at->format('H:i')); ?></span>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if($order->waiter): ?>
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-gray-600 myanmar-text">စားပွဲထိုး:</span>
                        <span class="ml-2 font-medium"><?php echo e($order->waiter->name); ?></span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-600 myanmar-text">စုစုပေါင်း</span>
                        <span class="text-lg font-bold text-gray-900"><?php echo e(number_format($order->total, 0)); ?> Ks</span>
                    </div>
                    
                    <!--[if BLOCK]><![endif]--><?php if($order->status === 'pending'): ?>
                    <button 
                        wire:click.stop="openPaymentModal(<?php echo e($order->id); ?>)"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center space-x-2 myanmar-text"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>ငွေရှင်းမည်</span>
                    </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full">
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 myanmar-text">အော်ဒါ မတွေ့ပါ</h3>
                <p class="mt-1 text-sm text-gray-500 myanmar-text">ရှာဖွေမှု filter များကို ပြောင်းကြည့်ပါ။</p>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Pagination -->
    <!--[if BLOCK]><![endif]--><?php if($orders->hasPages()): ?>
    <div class="mt-6">
        <?php echo e($orders->links()); ?>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Order Details Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showOrderDetails && $selectedOrder): ?>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 myanmar-text">အော်ဒါ အသေးစိတ်</h3>
                    <p class="text-sm text-gray-500"><?php echo e($selectedOrder->order_number); ?></p>
                </div>
                <button wire:click="closeOrderDetails" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-4">
                <!-- Order Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 myanmar-text">စားပွဲ</p>
                        <p class="text-base font-medium myanmar-text">
                            <?php echo e($selectedOrder->table ? $selectedOrder->table->name_mm : '-'); ?>

                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 myanmar-text">အမျိုးအစား</p>
                        <p class="text-base font-medium myanmar-text">
                            <?php echo e($selectedOrder->order_type === 'dine_in' ? 'ဆိုင်တွင်းစားမည်' : 'ပါဆယ်ယူမည်'); ?>

                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 myanmar-text">စားပွဲထိုး</p>
                        <p class="text-base font-medium">
                            <?php echo e($selectedOrder->waiter ? $selectedOrder->waiter->name : '-'); ?>

                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 myanmar-text">ငွေကိုင်</p>
                        <p class="text-base font-medium">
                            <?php echo e($selectedOrder->cashier ? $selectedOrder->cashier->name : '-'); ?>

                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 myanmar-text">အချိန်</p>
                        <p class="text-base font-medium">
                            <?php echo e($selectedOrder->created_at->format('Y-m-d H:i')); ?>

                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 myanmar-text">အခြေအနေ</p>
                        <p class="text-base font-medium myanmar-text">
                            <!--[if BLOCK]><![endif]--><?php if($selectedOrder->status === 'pending'): ?> စောင့်ဆိုင်းဆဲ
                            <?php elseif($selectedOrder->status === 'completed'): ?> ငွေရှင်းပြီး
                            <?php else: ?> ပယ်ဖျက်
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-3 myanmar-text">မှာယူထားသော ပစ္စည်းများ</h4>
                    <div class="space-y-2">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedOrder->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 myanmar-text"><?php echo e($item->item->name_mm); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($item->item->name); ?></p>
                                <!--[if BLOCK]><![endif]--><?php if($item->is_foc): ?>
                                <span class="text-xs text-red-600 myanmar-text">(အခမဲ့)</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-900"><?php echo e($item->quantity); ?> x <?php echo e(number_format($item->price, 0)); ?> Ks</p>
                                <p class="text-sm font-medium text-gray-900"><?php echo e(number_format($item->subtotal, 0)); ?> Ks</p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Order Total -->
                <div class="border-t border-gray-200 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">စုစုပေါင်း</span>
                        <span class="font-medium"><?php echo e(number_format($selectedOrder->subtotal, 0)); ?> Ks</span>
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->tax_amount > 0): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">အခွန် (<?php echo e($selectedOrder->tax_percentage); ?>%)</span>
                        <span class="font-medium"><?php echo e(number_format($selectedOrder->tax_amount, 0)); ?> Ks</span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->service_charge > 0): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">ဝန်ဆောင်မှု ကြေး</span>
                        <span class="font-medium"><?php echo e(number_format($selectedOrder->service_charge, 0)); ?> Ks</span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->discount_amount > 0): ?>
                    <div class="flex justify-between text-sm text-red-600">
                        <span class="myanmar-text">လျှော့ဈေး</span>
                        <span class="font-medium">-<?php echo e(number_format($selectedOrder->discount_amount, 0)); ?> Ks</span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="flex justify-between text-lg font-bold border-t border-gray-300 pt-2">
                        <span class="myanmar-text">စုစုပေါင်း ပေးရန်</span>
                        <span><?php echo e(number_format($selectedOrder->total, 0)); ?> Ks</span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                <div class="flex space-x-2">
                    <button wire:click="printReceipt(<?php echo e($selectedOrder->id); ?>)" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span class="myanmar-text">ပရင့်ထုတ်မည်</span>
                    </button>
                    
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->status === 'pending'): ?>
                    <button wire:click="cancelOrder(<?php echo e($selectedOrder->id); ?>)" 
                            onclick="return confirm('ဤအော်ဒါကို ပယ်ဖျက်မှာ သေချာပါသလား?')"
                            class="btn bg-yellow-600 hover:bg-yellow-700 text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="myanmar-text">ပယ်ဖျက်မည်</span>
                    </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->status === 'cancelled'): ?>
                    <button wire:click="deleteOrder(<?php echo e($selectedOrder->id); ?>)" 
                            onclick="return confirm('ဤအော်ဒါကို လုံးဝဖျက်မှာ သေချာပါသလား?')"
                            class="btn bg-red-600 hover:bg-red-700 text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span class="myanmar-text">ဖျက်မည်</span>
                    </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                
                <button wire:click="closeOrderDetails" class="btn btn-outline">
                    <span class="myanmar-text">ပိတ်မည်</span>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Hidden Receipt Template for Printing -->
    <!--[if BLOCK]><![endif]--><?php if($selectedOrder): ?>
    <div id="receipt-print-<?php echo e($selectedOrder->id); ?>" class="hidden">
        <div style="width: 280px; font-family: 'Courier New', monospace; font-size: 11px; padding: 5px;">
            <div style="text-align: center; margin-bottom: 10px;">
                <?php
                    $logo = \App\Models\Setting::get('app_logo');
                    $showLogo = \App\Models\Setting::get('show_logo_on_receipt', false);
                ?>
                <!--[if BLOCK]><![endif]--><?php if($logo && $showLogo): ?>
                <div style="margin-bottom: 10px;">
                    <img src="<?php echo e(asset('storage/' . $logo)); ?>" alt="Logo" style="max-width: 100px; max-height: 100px; margin: 0 auto; display: block;">
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <div style="font-size: 16px; font-weight: bold;"><?php echo e(\App\Models\Setting::get('business_name_mm', config('app.name'))); ?></div>
                <div style="font-size: 13px;"><?php echo e(\App\Models\Setting::get('business_name', 'Thar Cho Cafe')); ?></div>
                <div style="font-size: 13px; margin-top: 5px;"><?php echo e(\App\Models\Setting::get('business_address', '')); ?></div>
                <div style="font-size: 13px;">Tel: <?php echo e(\App\Models\Setting::get('business_phone', '')); ?></div>
            </div>
            
            <div style="border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 5px 0; margin: 10px 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>Order #:</td>
                        <td style="text-align: right;"><?php echo e($selectedOrder->order_number); ?></td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td style="text-align: right;"><?php echo e($selectedOrder->created_at->format('Y-m-d H:i')); ?></td>
                    </tr>
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->table): ?>
                    <tr>
                        <td>Table:</td>
                        <td style="text-align: right;"><?php echo e($selectedOrder->table->name); ?></td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->waiter): ?>
                    <tr>
                        <td>Waiter:</td>
                        <td style="text-align: right;"><?php echo e($selectedOrder->waiter->name); ?></td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->cashier): ?>
                    <tr>
                        <td>Cashier:</td>
                        <td style="text-align: right;"><?php echo e($selectedOrder->cashier->name); ?></td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </table>
            </div>
            
            <div style="margin: 10px 0;">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedOrder->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="margin-bottom: 5px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 70%;"><?php echo e($item->item->name); ?></td>
                            <td style="text-align: right; width: 30%;"><?php echo e(number_format($item->subtotal, 0)); ?></td>
                        </tr>
                    </table>
                    <div style="font-size: 10px; color: #666; padding-left: 10px;">
                        <?php echo e($item->quantity); ?> x <?php echo e(number_format($item->price, 0)); ?>

                        <!--[if BLOCK]><![endif]--><?php if($item->is_foc): ?> (FOC) <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            
            <div style="border-top: 1px dashed #000; padding-top: 5px; margin-top: 10px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>Subtotal:</td>
                        <td style="text-align: right;"><?php echo e(number_format($selectedOrder->subtotal, 0)); ?></td>
                    </tr>
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->tax_amount > 0): ?>
                    <tr>
                        <td>Tax (<?php echo e($selectedOrder->tax_percentage); ?>%):</td>
                        <td style="text-align: right;"><?php echo e(number_format($selectedOrder->tax_amount, 0)); ?></td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->service_charge > 0): ?>
                    <tr>
                        <td>Service Charge:</td>
                        <td style="text-align: right;"><?php echo e(number_format($selectedOrder->service_charge, 0)); ?></td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if($selectedOrder->discount_amount > 0): ?>
                    <tr>
                        <td>Discount:</td>
                        <td style="text-align: right;">-<?php echo e(number_format($selectedOrder->discount_amount, 0)); ?></td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <tr style="font-size: 14px; font-weight: bold; border-top: 1px solid #000;">
                        <td style="padding-top: 5px;">TOTAL:</td>
                        <td style="text-align: right; padding-top: 5px;"><?php echo e(number_format($selectedOrder->total, 0)); ?> Ks</td>
                    </tr>
                </table>
            </div>
            
            <div style="text-align: center; margin-top: 15px; font-size: 11px;">
                <div><?php echo e(\App\Models\Setting::get('receipt_footer', 'Thank you for your visit!')); ?></div>
                <div style="margin-top: 5px;"><?php echo e(now()->format('Y-m-d H:i:s')); ?></div>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('print-receipt', (event) => {
                const orderId = event.orderId;
                const receiptContent = document.getElementById('receipt-print-' + orderId);
                
                if (receiptContent) {
                    const printWindow = window.open('', '_blank', 'width=400,height=600');
                    printWindow.document.write('<html><head><title>Receipt</title>');
                    printWindow.document.write('<style>@page { size: 80mm auto; margin: 0; } body { margin: 0; padding: 0; } @media print { body { margin: 0; padding: 0; } }</style>');
                    printWindow.document.write('</head><body>');
                    printWindow.document.write(receiptContent.innerHTML);
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                    
                    setTimeout(() => {
                        printWindow.print();
                        printWindow.close();
                    }, 250);
                }
            });
        });
    </script>

    <!-- Payment Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showPaymentModal && $paymentOrder): ?>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="bg-green-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white myanmar-text">ငွေရှင်းခြင်း</h3>
                <button wire:click="closePaymentModal" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <!-- Order Info -->
                <div class="mb-6 pb-4 border-b">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900"><?php echo e($paymentOrder->order_number); ?></h4>
                            <!--[if BLOCK]><![endif]--><?php if($paymentOrder->table): ?>
                            <p class="text-sm text-gray-600 myanmar-text"><?php echo e($paymentOrder->table->name_mm); ?></p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold myanmar-text">
                            စောင့်ဆိုင်းဆဲ
                        </span>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <h5 class="font-semibold text-gray-900 mb-3 myanmar-text">မှာယူထားသော ပစ္စည်းများ</h5>
                    <div class="space-y-2">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $paymentOrder->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex justify-between text-sm">
                            <div class="flex-1">
                                <span class="text-gray-900"><?php echo e($item->item->name); ?></span>
                                <span class="text-gray-500"> × <?php echo e($item->quantity); ?></span>
                                <!--[if BLOCK]><![endif]--><?php if($item->foc_quantity > 0): ?>
                                <span class="text-green-600 text-xs myanmar-text"> (FOC: <?php echo e($item->foc_quantity); ?>)</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <span class="font-medium text-gray-900"><?php echo e(number_format($item->subtotal, 0)); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Tax & Service Options -->
                <div class="mb-6 space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                wire:model.live="applyTax"
                                id="applyTax"
                                class="w-5 h-5 text-green-600 rounded focus:ring-green-500"
                            >
                            <label for="applyTax" class="ml-3">
                                <span class="font-medium text-gray-900">Tax</span>
                                <span class="text-sm text-gray-500 ml-2">(<?php echo e(\App\Models\Setting::get('tax_percentage', 0)); ?>%)</span>
                            </label>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($applyTax): ?>
                        <span class="font-semibold text-gray-900"><?php echo e(number_format($calculatedTax, 0)); ?> Ks</span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                wire:model.live="applyService"
                                id="applyService"
                                class="w-5 h-5 text-green-600 rounded focus:ring-green-500"
                            >
                            <label for="applyService" class="ml-3">
                                <span class="font-medium text-gray-900 myanmar-text">ဝန်ဆောင်မှု ခ</span>
                                <span class="text-sm text-gray-500 ml-2">(<?php echo e(number_format(\App\Models\Setting::get('service_charge', 0), 0)); ?> Ks)</span>
                            </label>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($applyService): ?>
                        <span class="font-semibold text-gray-900"><?php echo e(number_format($calculatedService, 0)); ?> Ks</span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="mb-6">
                    <label class="block font-medium text-gray-900 mb-3 myanmar-text">ငွေပေးချေမှု နည်းလမ်း</label>
                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <button 
                            wire:click="$set('paymentMethod', 'cash')"
                            class="px-4 py-3 rounded-lg font-medium flex flex-col items-center <?php echo e($paymentMethod === 'cash' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>"
                        >
                            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="myanmar-text">ငွေသား</span>
                        </button>
                        <button 
                            wire:click="$set('paymentMethod', 'card')"
                            class="px-4 py-3 rounded-lg font-medium flex flex-col items-center <?php echo e($paymentMethod === 'card' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>"
                        >
                            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <span>Card</span>
                        </button>
                        <button 
                            wire:click="$set('paymentMethod', 'mobile')"
                            class="px-4 py-3 rounded-lg font-medium flex flex-col items-center <?php echo e($paymentMethod === 'mobile' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>"
                        >
                            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span>Mobile</span>
                        </button>
                    </div>
                    
                    <!--[if BLOCK]><![endif]--><?php if($paymentMethod === 'cash'): ?>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 myanmar-text">ပေးငွေ</label>
                        <input 
                            type="number" 
                            wire:model.live="amountReceived"
                            min="<?php echo e($calculatedTotal); ?>"
                            step="100"
                            class="w-full border-gray-300 rounded-lg text-lg font-semibold"
                            placeholder="ပေးငွေ ထည့်ပါ"
                        >
                        <!--[if BLOCK]><![endif]--><?php if($amountReceived > 0 && $calculatedChange >= 0): ?>
                        <div class="mt-2 p-3 bg-blue-50 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700 myanmar-text">ပြန်အမ်းငွေ</span>
                                <span class="text-lg font-bold text-blue-600"><?php echo e(number_format($calculatedChange, 0)); ?> Ks</span>
                            </div>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Discount -->
                <div class="mb-6">
                    <label class="block font-medium text-gray-900 mb-3 myanmar-text">လျှော့ဈေး (Discount)</label>
                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <button 
                            wire:click="$set('discountType', 'none')"
                            class="px-4 py-2 rounded-lg font-medium <?php echo e($discountType === 'none' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>"
                        >
                            None
                        </button>
                        <button 
                            wire:click="$set('discountType', 'percentage')"
                            class="px-4 py-2 rounded-lg font-medium <?php echo e($discountType === 'percentage' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>"
                        >
                            %
                        </button>
                        <button 
                            wire:click="$set('discountType', 'fixed')"
                            class="px-4 py-2 rounded-lg font-medium <?php echo e($discountType === 'fixed' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>"
                        >
                            Fixed
                        </button>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if($discountType !== 'none'): ?>
                    <div class="flex items-center space-x-2">
                        <input 
                            type="number" 
                            wire:model.live="discountValue"
                            min="0"
                            step="0.01"
                            class="flex-1 border-gray-300 rounded-lg"
                            placeholder="<?php echo e($discountType === 'percentage' ? 'Percentage (%)' : 'Amount (Ks)'); ?>"
                        >
                        <span class="text-gray-600"><?php echo e($discountType === 'percentage' ? '%' : 'Ks'); ?></span>
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if($calculatedDiscount > 0): ?>
                    <p class="mt-2 text-sm text-green-600 myanmar-text">
                        လျှော့ဈေး: -<?php echo e(number_format($calculatedDiscount, 0)); ?> Ks
                    </p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Summary -->
                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">Subtotal</span>
                        <span class="font-medium"><?php echo e(number_format($calculatedSubtotal, 0)); ?> Ks</span>
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if($applyTax): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-medium"><?php echo e(number_format($calculatedTax, 0)); ?> Ks</span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if($applyService): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">ဝန်ဆောင်မှု</span>
                        <span class="font-medium"><?php echo e(number_format($calculatedService, 0)); ?> Ks</span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if($calculatedDiscount > 0): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">လျှော့ဈေး</span>
                        <span class="font-medium text-green-600">-<?php echo e(number_format($calculatedDiscount, 0)); ?> Ks</span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="flex justify-between text-lg font-bold pt-2 border-t">
                        <span class="myanmar-text">စုစုပေါင်း</span>
                        <span class="text-green-600"><?php echo e(number_format($calculatedTotal, 0)); ?> Ks</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex space-x-3">
                    <button 
                        wire:click="closePaymentModal"
                        class="flex-1 px-6 py-3 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 myanmar-text"
                    >
                        မလုပ်တော့ပါ
                    </button>
                    <button 
                        wire:click="processPayment"
                        class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold flex items-center justify-center space-x-2 myanmar-text"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>ငွေရှင်းမည်</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Success Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showSuccessModal): ?>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
            <!-- Success Animation -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 p-8 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full mb-4 animate-bounce">
                    <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2 myanmar-text">အောင်မြင်ပါသည်!</h2>
                <p class="text-green-100 text-lg myanmar-text">ငွေပေးချေမှု အောင်မြင်ပါသည်</p>
            </div>

            <div class="p-6">
                <div class="text-center mb-6">
                    <p class="text-gray-600 myanmar-text">ငွေရှင်းခြင်း ပြီးစီးပါပြီ</p>
                    <p class="text-sm text-gray-500 mt-1">Payment completed successfully</p>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <button 
                        type="button"
                        wire:click.prevent="printCompletedReceipt"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-colors flex items-center justify-center space-x-2"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span class="myanmar-text">ဘောင်ချာ ပရင့်ထုတ်မည်</span>
                    </button>

                    <button 
                        wire:click="closeSuccessModal"
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-4 px-6 rounded-xl transition-colors myanmar-text"
                    >
                        ပြီးပါပြီ
                    </button>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-500 flex items-center justify-center space-x-2 myanmar-text">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                        </svg>
                        <span>ကျေးဇူးတင်ပါသည်</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('print-payment-receipt', (event) => {
                const orderId = event.orderId;
                
                // Fetch order details
                fetch(`/api/orders/${orderId}/receipt`)
                    .then(response => response.json())
                    .then(order => {
                        printDetailedReceipt(order);
                    });
            });
        });

        function printDetailedReceipt(order) {
            const printWindow = window.open('', '_blank', 'width=400,height=800');
            
            if (!printWindow) {
                alert('ကျေးဇူးပြု၍ Popup Blocker ကို ပိတ်ပေးပါ။\nPlease allow popups for this site.');
                return;
            }
            
            const paymentMethodLabels = {
                'cash': 'ငွေသား / Cash',
                'card': 'ကတ် / Card',
                'mobile': 'မိုဘိုင်း / Mobile'
            };
            
            let itemsHtml = '';
            order.order_items.forEach(item => {
                const focText = item.foc_quantity > 0 ? ` (FOC: ${item.foc_quantity})` : '';
                itemsHtml += `
                    <tr>
                        <td style="padding: 4px 0;">${item.item.name}${focText}</td>
                        <td style="text-align: center;">${item.quantity}</td>
                        <td style="text-align: right;">${Number(item.price).toLocaleString()}</td>
                        <td style="text-align: right;">${Number(item.subtotal).toLocaleString()}</td>
                    </tr>
                `;
            });
            
            let summaryHtml = `
                <tr>
                    <td colspan="3" style="text-align: right; padding: 8px 0;">Subtotal:</td>
                    <td style="text-align: right; font-weight: bold;">${Number(order.subtotal).toLocaleString()} Ks</td>
                </tr>
            `;
            
            if (order.tax_amount > 0) {
                summaryHtml += `
                    <tr>
                        <td colspan="3" style="text-align: right; padding: 4px 0;">Tax (${order.tax_percentage}%):</td>
                        <td style="text-align: right;">${Number(order.tax_amount).toLocaleString()} Ks</td>
                    </tr>
                `;
            }
            
            if (order.service_charge > 0) {
                summaryHtml += `
                    <tr>
                        <td colspan="3" style="text-align: right; padding: 4px 0;">Service Charge:</td>
                        <td style="text-align: right;">${Number(order.service_charge).toLocaleString()} Ks</td>
                    </tr>
                `;
            }
            
            if (order.discount_amount > 0) {
                const discountLabel = order.discount_percentage > 0 
                    ? `Discount (${order.discount_percentage}%)` 
                    : 'Discount';
                summaryHtml += `
                    <tr>
                        <td colspan="3" style="text-align: right; padding: 4px 0;">${discountLabel}:</td>
                        <td style="text-align: right; color: #059669;">-${Number(order.discount_amount).toLocaleString()} Ks</td>
                    </tr>
                `;
            }
            
            summaryHtml += `
                <tr style="border-top: 2px solid #000;">
                    <td colspan="3" style="text-align: right; padding: 8px 0; font-weight: bold; font-size: 16px;">TOTAL:</td>
                    <td style="text-align: right; font-weight: bold; font-size: 16px;">${Number(order.total).toLocaleString()} Ks</td>
                </tr>
            `;
            
            let paymentHtml = `
                <tr>
                    <td colspan="3" style="text-align: right; padding: 4px 0;">Payment Method:</td>
                    <td style="text-align: right;">${paymentMethodLabels[order.payment_method] || order.payment_method}</td>
                </tr>
            `;
            
            if (order.payment_method === 'cash') {
                paymentHtml += `
                    <tr>
                        <td colspan="3" style="text-align: right; padding: 4px 0;">Amount Received:</td>
                        <td style="text-align: right;">${Number(order.amount_received).toLocaleString()} Ks</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right; padding: 4px 0;">Change:</td>
                        <td style="text-align: right; font-weight: bold;">${Number(order.change_amount).toLocaleString()} Ks</td>
                    </tr>
                `;
            }
            
            const html = `
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Receipt - ${order.order_number}</title>
                    <style>
                        @page { size: 80mm auto; margin: 0; }
                        * { margin: 0; padding: 0; box-sizing: border-box; }
                        body {
                            font-family: 'Courier New', monospace;
                            font-size: 12px;
                            line-height: 1.4;
                            padding: 10mm;
                            width: 80mm;
                        }
                        .header { text-align: center; margin-bottom: 10px; border-bottom: 2px dashed #000; padding-bottom: 10px; }
                        .header h1 { font-size: 18px; margin-bottom: 5px; }
                        .header p { font-size: 11px; }
                        .info { margin: 10px 0; font-size: 11px; }
                        .info div { margin: 3px 0; }
                        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                        th { text-align: left; border-bottom: 1px solid #000; padding: 5px 0; font-size: 11px; }
                        td { padding: 4px 0; font-size: 11px; }
                        .footer { text-align: center; margin-top: 15px; padding-top: 10px; border-top: 2px dashed #000; font-size: 11px; }
                        @media print {
                            body { margin: 0; padding: 10mm; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>${order.shop_name || 'Tea House POS'}</h1>
                        <p>Thank You For Your Purchase</p>
                    </div>
                    
                    <div class="info">
                        <div><strong>Order #:</strong> ${order.order_number}</div>
                        ${order.table ? `<div><strong>Table:</strong> ${order.table.name}</div>` : ''}
                        ${order.waiter ? `<div><strong>Waiter:</strong> ${order.waiter.name}</div>` : ''}
                        <div><strong>Cashier:</strong> ${order.cashier.name}</div>
                        <div><strong>Date:</strong> ${new Date(order.completed_at).toLocaleString()}</div>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th style="text-align: center;">Qty</th>
                                <th style="text-align: right;">Price</th>
                                <th style="text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsHtml}
                        </tbody>
                    </table>
                    
                    <table>
                        <tbody>
                            ${summaryHtml}
                            ${paymentHtml}
                        </tbody>
                    </table>
                    
                    <div class="footer">
                        <p>*** Thank You! Come Again! ***</p>
                        <p style="margin-top: 5px;">Powered by Tea House POS</p>
                    </div>
                </body>
                </html>
            `;
            
            printWindow.document.write(html);
            printWindow.document.close();
            
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 250);
        }
    </script>
    </div>
</div>
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/cashier/orders-list.blade.php ENDPATH**/ ?>