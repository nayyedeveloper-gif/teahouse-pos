<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side: Menu Items (2/3 width) -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Header & Order Type -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-2xl font-bold text-gray-900">
                            <span class="myanmar-text">ငွေကောက်ခံရန်</span> / POS
                        </h1>
                        <div class="flex space-x-2">
                            <button 
                                wire:click="$set('orderType', 'dine_in')"
                                class="px-4 py-2 rounded-lg font-medium <?php echo e($orderType === 'dine_in' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700'); ?>"
                            >
                                <span class="myanmar-text">စားပွဲ</span>
                            </button>
                            <button 
                                wire:click="$set('orderType', 'takeaway')"
                                class="px-4 py-2 rounded-lg font-medium <?php echo e($orderType === 'takeaway' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700'); ?>"
                            >
                                <span class="myanmar-text">ပါဆယ်</span>
                            </button>
                        </div>
                    </div>

                    <!-- Table Selection (for dine-in) -->
                    <!--[if BLOCK]><![endif]--><?php if($orderType === 'dine_in'): ?>
                        <div>
                            <label class="form-label myanmar-text">စားပွဲရွေးရန်</label>
                            <select wire:model="selectedTable" class="form-select">
                                <option value="">Select Table...</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $availableTables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($table->id); ?>"><?php echo e($table->name); ?> - <?php echo e($table->name_mm); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Search -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <input 
                        type="text" 
                        wire:model.live="searchTerm" 
                        placeholder="ရှာဖွေရန်... / Search items..."
                        class="form-input"
                    >
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex overflow-x-auto space-x-2 pb-2">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button 
                                wire:click="selectCategory(<?php echo e($category->id); ?>)"
                                class="flex-shrink-0 px-4 py-2 rounded-lg font-medium transition-colors <?php echo e($selectedCategory == $category->id ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>"
                            >
                                <span class="myanmar-text"><?php echo e($category->name_mm); ?></span>
                                <span class="text-xs ml-1">(<?php echo e($category->active_items_count); ?>)</span>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Items Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <button 
                            wire:click="addToCart(<?php echo e($item->id); ?>)"
                            class="pos-item-card hover:scale-105 transition-transform"
                        >
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto mb-2 bg-primary-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 text-sm mb-1"><?php echo e($item->name); ?></h3>
                                <p class="text-xs text-gray-600 myanmar-text mb-2"><?php echo e($item->name_mm); ?></p>
                                <p class="text-primary-600 font-bold"><?php echo e(number_format($item->price, 0)); ?> Ks</p>
                            </div>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 myanmar-text">ပစ္စည်းများ မရှိပါ</p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

            <!-- Right Side: Cart & Checkout (1/3 width) -->
            <div class="lg:col-span-1 space-y-4">
                <!-- Customer Lookup -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <button 
                        wire:click="$toggle('showCustomerLookup')"
                        class="w-full flex items-center justify-between text-left"
                    >
                        <span class="font-semibold text-gray-900 myanmar-text">ဖောက်သည် ရှာဖွေရန်</span>
                        <svg class="w-5 h-5 text-gray-400 transform <?php echo e($showCustomerLookup ? 'rotate-180' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!--[if BLOCK]><![endif]--><?php if($showCustomerLookup): ?>
                    <div class="mt-4 space-y-3">
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                wire:model="customer_search_phone"
                                placeholder="09xxxxxxxxx"
                                class="flex-1 px-3 py-2 border rounded-lg text-sm"
                            >
                            <button 
                                wire:click="searchCustomer"
                                class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm hover:bg-primary-700"
                            >
                                <span class="myanmar-text">ရှာမည်</span>
                            </button>
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if($customer): ?>
                        <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900"><?php echo e($customer->name); ?></p>
                                    <!--[if BLOCK]><![endif]--><?php if($customer->name_mm): ?>
                                    <p class="text-sm text-gray-600 myanmar-text"><?php echo e($customer->name_mm); ?></p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <p class="text-xs text-gray-500"><?php echo e($customer->customer_code); ?></p>
                                </div>
                                <button 
                                    wire:click="clearCustomer"
                                    class="text-red-600 hover:text-red-800"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="text-sm space-y-1">
                                <p class="myanmar-text">
                                    <span class="text-gray-600">ရရှိနိုင်သော Points:</span>
                                    <span class="font-bold text-green-600"><?php echo e(number_format($customer->loyalty_points)); ?></span>
                                </p>
                                <p class="myanmar-text">
                                    <span class="text-gray-600">စုစုပေါင်းသုံးစွဲမှု:</span>
                                    <span class="font-semibold"><?php echo e(number_format($customer->total_spent)); ?> Ks</span>
                                </p>
                            </div>

                            <!--[if BLOCK]><![endif]--><?php if($customer->loyalty_points >= 100): ?>
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">
                                    Points လျှော့ဈေးယူမည်
                                </label>
                                <input 
                                    type="number" 
                                    wire:model.live="loyalty_points_to_redeem"
                                    min="0"
                                    max="<?php echo e($customer->loyalty_points); ?>"
                                    step="100"
                                    class="w-full px-3 py-2 border rounded-lg text-sm"
                                    placeholder="100, 200, 300..."
                                >
                                <!--[if BLOCK]><![endif]--><?php if($loyalty_points_to_redeem > 0): ?>
                                <p class="text-xs text-green-600 mt-1 myanmar-text">
                                    လျှော့ဈေး: <?php echo e(number_format(($loyalty_points_to_redeem / 100) * 1000)); ?> Ks
                                </p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!--[if BLOCK]><![endif]--><?php if(session()->has('customer_error')): ?>
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600 myanmar-text"><?php echo e(session('customer_error')); ?></p>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Cart -->
                <div class="bg-white rounded-lg shadow-sm sticky top-6">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 myanmar-text">အော်ဒါစာရင်း</h3>
                        <p class="text-sm text-gray-600"><?php echo e(count($cart)); ?> items</p>
                    </div>

                    <div class="p-4 max-h-96 overflow-y-auto">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="mb-4 pb-4 border-b border-gray-200 last:border-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-sm"><?php echo e($item['name']); ?></h4>
                                        <p class="text-xs text-gray-600 myanmar-text"><?php echo e($item['name_mm']); ?></p>
                                    </div>
                                    <button 
                                        wire:click="removeFromCart('<?php echo e($key); ?>')"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center space-x-2 mb-2">
                                    <button 
                                        wire:click="updateQuantity('<?php echo e($key); ?>', <?php echo e($item['quantity'] - 1); ?>)"
                                        class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span class="w-12 text-center font-semibold"><?php echo e($item['quantity']); ?></span>
                                    <button 
                                        wire:click="updateQuantity('<?php echo e($key); ?>', <?php echo e($item['quantity'] + 1); ?>)"
                                        class="w-8 h-8 rounded-full bg-primary-600 hover:bg-primary-700 text-white flex items-center justify-center"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Price -->
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600"><?php echo e(number_format($item['price'], 0)); ?> × <?php echo e($item['quantity']); ?></span>
                                    <span class="font-bold text-gray-900">
                                        <!--[if BLOCK]><![endif]--><?php if($item['is_foc']): ?>
                                            <span class="text-green-600">FOC</span>
                                        <?php else: ?>
                                            <?php echo e(number_format($item['price'] * $item['quantity'], 0)); ?> Ks
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>

                                <!-- FOC Toggle -->
                                <label class="flex items-center cursor-pointer text-sm">
                                    <input 
                                        type="checkbox" 
                                        wire:click="toggleFoc('<?php echo e($key); ?>')"
                                        <?php echo e($item['is_foc'] ? 'checked' : ''); ?>

                                        class="form-checkbox text-primary-600"
                                    >
                                    <span class="ml-2 text-gray-700 myanmar-text">အခမဲ့ (FOC)</span>
                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-gray-500 text-sm myanmar-text">အော်ဒါစာရင်း အလွတ်</p>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if(count($cart) > 0): ?>
                        <div class="p-4 border-t border-gray-200 space-y-3">
                            <!-- Subtotal -->
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 myanmar-text">စုစုပေါင်း</span>
                                <span class="font-semibold"><?php echo e(number_format($subtotal, 0)); ?> Ks</span>
                            </div>

                            <!-- Tax -->
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 myanmar-text">အခွန် (%)</span>
                                <input 
                                    type="number" 
                                    wire:model.live="taxPercentage"
                                    class="w-20 text-right border-gray-300 rounded text-sm"
                                    min="0"
                                    step="0.1"
                                >
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($taxAmount > 0): ?>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span class="ml-4">Tax Amount</span>
                                    <span><?php echo e(number_format($taxAmount, 0)); ?> Ks</span>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!-- Discount -->
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 myanmar-text">လျှော့ဈေး (%)</span>
                                <input 
                                    type="number" 
                                    wire:model.live="discountPercentage"
                                    class="w-20 text-right border-gray-300 rounded text-sm"
                                    min="0"
                                    step="0.1"
                                >
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($discountAmount > 0): ?>
                                <div class="flex justify-between text-sm text-red-600">
                                    <span class="ml-4">Discount Amount</span>
                                    <span>-<?php echo e(number_format($discountAmount, 0)); ?> Ks</span>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!-- Service Charge -->
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 myanmar-text">ဝန်ဆောင်ခ</span>
                                <input 
                                    type="number" 
                                    wire:model.live="serviceCharge"
                                    class="w-24 text-right border-gray-300 rounded text-sm"
                                    min="0"
                                >
                            </div>

                            <!-- Total -->
                            <div class="pt-3 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900 myanmar-text">စုစုပေါင်း</span>
                                    <span class="text-2xl font-bold text-primary-600"><?php echo e(number_format($total, 0)); ?> Ks</span>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div>
                                <textarea 
                                    wire:model="notes"
                                    rows="2"
                                    placeholder="မှတ်ချက်... / Notes..."
                                    class="form-textarea text-sm"
                                ></textarea>
                            </div>

                            <!-- Checkout Buttons -->
                            <div class="space-y-2">
                                <button 
                                    wire:click="openPaymentModal"
                                    class="w-full btn btn-primary py-3 text-lg font-semibold"
                                >
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="myanmar-text">ငွေကောက်မည်</span> / Checkout
                                </button>
                                <button 
                                    wire:click="resetForm"
                                    class="w-full btn btn-outline py-2"
                                >
                                    <span class="myanmar-text">ပယ်ဖျက်မည်</span> / Clear
                                </button>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>

    <!-- Payment Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showPaymentModal): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closePaymentModal"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modal-title">
                                    <span class="myanmar-text">ငွေကောက်ခံမည်</span> / Process Payment
                                </h3>
                                
                                <div class="space-y-4">
                                    <!-- Payment Method -->
                                    <div>
                                        <label class="form-label myanmar-text">ငွေပေးချေမှုနည်းလမ်း</label>
                                        <div class="grid grid-cols-3 gap-2">
                                            <button 
                                                wire:click="$set('paymentMethod', 'cash')"
                                                class="px-4 py-2 rounded-lg font-medium <?php echo e($paymentMethod === 'cash' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700'); ?>"
                                            >
                                                Cash
                                            </button>
                                            <button 
                                                wire:click="$set('paymentMethod', 'card')"
                                                class="px-4 py-2 rounded-lg font-medium <?php echo e($paymentMethod === 'card' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700'); ?>"
                                            >
                                                Card
                                            </button>
                                            <button 
                                                wire:click="$set('paymentMethod', 'mobile')"
                                                class="px-4 py-2 rounded-lg font-medium <?php echo e($paymentMethod === 'mobile' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700'); ?>"
                                            >
                                                Mobile
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Total Amount Breakdown -->
                                    <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600 myanmar-text">စုစုပေါင်း</span>
                                            <span class="font-semibold"><?php echo e(number_format($subtotal, 0)); ?> Ks</span>
                                        </div>
                                        
                                        <!--[if BLOCK]><![endif]--><?php if($customer && $loyalty_points_to_redeem > 0): ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-green-600 myanmar-text">Loyalty လျှော့ဈေး</span>
                                            <span class="font-semibold text-green-600">-<?php echo e(number_format(($loyalty_points_to_redeem / 100) * 1000, 0)); ?> Ks</span>
                                        </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        
                                        <!--[if BLOCK]><![endif]--><?php if($discountAmount > 0): ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600 myanmar-text">လျှော့ဈေး</span>
                                            <span class="font-semibold text-red-600">-<?php echo e(number_format($discountAmount, 0)); ?> Ks</span>
                                        </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        
                                        <!--[if BLOCK]><![endif]--><?php if($taxAmount > 0): ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600 myanmar-text">အခွန်</span>
                                            <span class="font-semibold">+<?php echo e(number_format($taxAmount, 0)); ?> Ks</span>
                                        </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        
                                        <!--[if BLOCK]><![endif]--><?php if($serviceCharge > 0): ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600 myanmar-text">ဝန်ဆောင်မှုခ</span>
                                            <span class="font-semibold">+<?php echo e(number_format($serviceCharge, 0)); ?> Ks</span>
                                        </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        
                                        <div class="pt-2 border-t border-gray-300">
                                            <div class="flex justify-between items-center">
                                                <span class="text-lg font-semibold myanmar-text">ပေးရန်</span>
                                                <span class="text-2xl font-bold text-primary-600"><?php echo e(number_format($total, 0)); ?> Ks</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!--[if BLOCK]><![endif]--><?php if($paymentMethod === 'cash'): ?>
                                        <!-- Amount Received -->
                                        <div>
                                            <label class="form-label myanmar-text">လက်ခံငွေ</label>
                                            <input 
                                                type="number" 
                                                wire:model.live="amountReceived"
                                                class="form-input text-lg font-semibold"
                                                min="0"
                                                step="100"
                                            >
                                        </div>

                                        <!-- Change -->
                                        <!--[if BLOCK]><![endif]--><?php if($change > 0): ?>
                                            <div class="bg-green-50 p-4 rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-lg font-semibold myanmar-text text-green-800">ပြန်အမ်းငွေ</span>
                                                    <span class="text-2xl font-bold text-green-600"><?php echo e(number_format($change, 0)); ?> Ks</span>
                                                </div>
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button 
                            wire:click="processPayment"
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            <span class="myanmar-text">အတည်ပြုမည်</span> / Confirm
                        </button>
                        <button 
                            wire:click="closePaymentModal"
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            <span class="myanmar-text">မလုပ်တော့</span> / Cancel
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
                <p class="text-green-100 text-lg myanmar-text">အော်ဒါ အောင်မြင်စွာ ပြီးစီးပါပြီ</p>
            </div>

            <div class="p-6">
                <div class="text-center mb-6">
                    <p class="text-gray-600 myanmar-text">ငွေရှင်းခြင်း ပြီးစီးပါပြီ</p>
                    <p class="text-sm text-gray-500 mt-1">Order completed successfully</p>
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
            
            if (order.payment_method === 'cash' && order.amount_received) {
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
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/cashier/point-of-sale.blade.php ENDPATH**/ ?>