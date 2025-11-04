<div class="min-h-screen bg-gray-50 pb-20" wire:poll.5s="loadTables">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
        <!-- Header -->
        <div class="sticky top-0 bg-gray-50 z-10 py-4 border-b border-gray-200 mb-4">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 myanmar-text">စားပွဲများ</h1>
                    <p class="mt-1 text-xs sm:text-sm text-gray-600 myanmar-text">
                        စားပွဲတစ်ခုကို ရွေးချယ်ပြီး အော်ဒါယူပါ
                    </p>
                </div>
                <!-- Stats -->
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900"><?php echo e($tables->count()); ?></div>
                    <div class="text-xs text-gray-500 myanmar-text">စားပွဲ</div>
                </div>
            </div>

            <!-- Search -->
            <div class="relative">
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="ရှာဖွေရန်..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Status Legend -->
        <div class="flex items-center justify-center gap-4 mb-4 text-xs">
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-green-500 mr-1.5"></div>
                <span class="myanmar-text">အလွတ်</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-red-500 mr-1.5"></div>
                <span class="myanmar-text">အသုံးပြုနေသည်</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1.5"></div>
                <span class="myanmar-text">ကြိုတင်မှာထား</span>
            </div>
        </div>

        <!-- Tables Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $isOccupied = $table->active_orders_count > 0;
                    $statusColor = $isOccupied ? 'red' : ($table->status === 'reserved' ? 'yellow' : 'green');
                ?>
                <button 
                    wire:click="selectTable(<?php echo e($table->id); ?>)"
                    class="relative bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 p-4 border-2 <?php echo e($isOccupied ? 'border-red-200 bg-red-50' : ($table->status === 'reserved' ? 'border-yellow-200 bg-yellow-50' : 'border-green-200 hover:border-green-300')); ?>"
                >
                    <!-- Status Indicator -->
                    <div class="absolute top-2 right-2">
                        <div class="w-3 h-3 rounded-full <?php echo e($isOccupied ? 'bg-red-500 animate-pulse' : ($table->status === 'reserved' ? 'bg-yellow-500' : 'bg-green-500')); ?>"></div>
                    </div>

                    <!-- Table Icon -->
                    <div class="mb-2">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto <?php echo e($isOccupied ? 'text-red-600' : ($table->status === 'reserved' ? 'text-yellow-600' : 'text-green-600')); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>

                    <!-- Table Name -->
                    <div class="font-bold text-base sm:text-lg text-gray-900">
                        <?php echo e($table->name); ?>

                    </div>
                    <div class="text-xs text-gray-600 myanmar-text mb-2">
                        <?php echo e($table->name_mm); ?>

                    </div>

                    <!-- Capacity -->
                    <div class="flex items-center justify-center text-xs text-gray-500 mb-2">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <?php echo e($table->capacity); ?>

                    </div>

                    <!-- Active Orders Info -->
                    <!--[if BLOCK]><![endif]--><?php if($isOccupied): ?>
                        <div class="mt-2 pt-2 border-t border-gray-200">
                            <!--[if BLOCK]><![endif]--><?php if($table->orders->first()): ?>
                                <div class="text-xs font-semibold text-red-600 mb-1">
                                    #<?php echo e($table->orders->first()->order_number); ?>

                                </div>
                                <div class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs rounded-md">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <span class="myanmar-text">ထပ်ထည့်မည်</span>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php else: ?>
                        <div class="mt-2 pt-2 border-t border-gray-200">
                            <div class="inline-flex items-center px-2 py-1 bg-green-600 text-white text-xs rounded-md">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="myanmar-text">အော်ဒါယူမည်</span>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-12 bg-white rounded-xl">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500 myanmar-text text-lg">စားပွဲ မရှိသေးပါ</p>
                    <p class="text-gray-400 text-sm mt-2">Admin မှ စားပွဲများ ထည့်ပေးရန် လိုအပ်ပါသည်</p>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/waiter/tables-list.blade.php ENDPATH**/ ?>