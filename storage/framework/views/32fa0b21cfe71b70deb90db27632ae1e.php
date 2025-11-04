<div>
    <!-- Success Message -->
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
    <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700 myanmar-text"><?php echo e(session('message')); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Error Message -->
    <?php if(session()->has('error')): ?>
    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 myanmar-text"><?php echo e(session('error')); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 myanmar-text">အမျိုးအစားများ စီမံခန့်ခွဲမှု</h2>
            <p class="mt-1 text-sm text-gray-600 myanmar-text">အမျိုးအစားများကို ထည့်သွင်း၊ ပြင်ဆင်၊ ဖျက်ပစ်နိုင်ပါသည်။</p>
        </div>
        <button wire:click="create" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span class="myanmar-text">အမျိုးအစားအသစ် ထည့်ရန်</span>
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 md:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရှာဖွေရန်</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="အမျိုးအစားအမည် ရှာရန်..." class="input">
            </div>

            <!-- Printer Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ပရင်တာ အမျိုးအစား</label>
                <select wire:model.live="printerFilter" class="input">
                    <option value="">အားလုံး</option>
                    <option value="kitchen">မီးဖိုချောင် / Kitchen</option>
                    <option value="bar">ဘား / Bar</option>
                    <option value="none">မရှိ / None</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 myanmar-text"><?php echo e($category->name_mm); ?></h3>
                        <p class="text-sm text-gray-500"><?php echo e($category->name); ?></p>
                    </div>
                    <div class="flex space-x-2">
                        <!--[if BLOCK]><![endif]--><?php if($category->is_active): ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 myanmar-text">
                            အသုံးပြုနေသော
                        </span>
                        <?php else: ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 myanmar-text">
                            ပိတ်ထားသော
                        </span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!--[if BLOCK]><![endif]--><?php if($category->description): ?>
                <p class="text-sm text-gray-600 mb-4 myanmar-text"><?php echo e($category->description); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span class="text-gray-600 myanmar-text">ပရင်တာ:</span>
                        <span class="ml-2 font-medium">
                            <!--[if BLOCK]><![endif]--><?php if($category->printer_type === 'kitchen'): ?>
                            <span class="myanmar-text">မီးဖိုချောင်</span>
                            <?php elseif($category->printer_type === 'bar'): ?>
                            <span class="myanmar-text">ဘား</span>
                            <?php else: ?>
                            <span class="myanmar-text">မရှိ</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </span>
                    </div>

                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-gray-600 myanmar-text">ပစ္စည်းများ:</span>
                        <span class="ml-2 font-medium"><?php echo e($category->items_count); ?> <span class="myanmar-text">ခု</span></span>
                    </div>

                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                        <span class="text-gray-600 myanmar-text">စီစဉ်မှု:</span>
                        <span class="ml-2 font-medium"><?php echo e($category->sort_order); ?></span>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200">
                    <button wire:click="toggleActive(<?php echo e($category->id); ?>)" class="text-blue-600 hover:text-blue-900" title="အခြေအနေ ပြောင်းရန်">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                    <button wire:click="edit(<?php echo e($category->id); ?>)" class="text-indigo-600 hover:text-indigo-900" title="ပြင်ဆင်ရန်">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button wire:click="confirmDelete(<?php echo e($category->id); ?>)" class="text-red-600 hover:text-red-900" title="ဖျက်ရန်">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full">
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 myanmar-text">အမျိုးအစား မတွေ့ပါ</h3>
                <p class="mt-1 text-sm text-gray-500 myanmar-text">အမျိုးအစားအသစ် ထည့်သွင်းပါ။</p>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Pagination -->
    <!--[if BLOCK]><![endif]--><?php if($categories->hasPages()): ?>
    <div class="mt-6">
        <?php echo e($categories->links()); ?>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Create/Edit Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 myanmar-text">
                    <?php echo e($editMode ? 'အမျိုးအစား ပြင်ဆင်ရန်' : 'အမျိုးအစားအသစ် ထည့်ရန်'); ?>

                </h3>
            </div>

            <form wire:submit.prevent="save">
                <div class="px-6 py-4 space-y-4">
                    <!-- Name (English) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name (English) *</label>
                        <input type="text" wire:model="name" class="input" placeholder="Coffee">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Name (Myanmar) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အမည် (မြန်မာ) *</label>
                        <input type="text" wire:model="name_mm" class="input myanmar-text" placeholder="ကော်ဖီ">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name_mm'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ဖော်ပြချက်</label>
                        <textarea wire:model="description" rows="3" class="input" placeholder="အမျိုးအစားအကြောင်း ဖော်ပြချက်..."></textarea>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Printer Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ပရင်တာ အမျိုးအစား *</label>
                        <select wire:model="printer_type" class="input">
                            <option value="kitchen">မီးဖိုချောင် / Kitchen</option>
                            <option value="bar">ဘား / Bar</option>
                            <option value="none">မရှိ / None</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500 myanmar-text">
                            ဤအမျိုးအစားမှ ပစ္စည်းများကို မည်သည့် ပရင်တာသို့ ပေးပို့မည်ကို သတ်မှတ်ပါ။
                        </p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['printer_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">စီစဉ်မှု အစဉ်</label>
                        <input type="number" wire:model="sort_order" class="input" min="0">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Active Checkbox -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700 myanmar-text">အသုံးပြုနေသော</span>
                        </label>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" wire:click="closeModal" class="btn btn-outline">
                        <span class="myanmar-text">မလုပ်တော့ပါ</span>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span class="myanmar-text"><?php echo e($editMode ? 'ပြင်ဆင်မည်' : 'ထည့်သွင်းမည်'); ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Delete Confirmation Modal -->
    <!--[if BLOCK]><![endif]--><?php if($deleteConfirm): ?>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-gray-900 myanmar-text">အမျိုးအစား ဖျက်ရန် သေချာပါသလား?</h3>
                        <p class="mt-2 text-sm text-gray-500 myanmar-text">ဤလုပ်ဆောင်ချက်ကို နောက်ပြန်ပြောင်း၍ မရပါ။</p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                <button type="button" wire:click="$set('deleteConfirm', false)" class="btn btn-outline">
                    <span class="myanmar-text">မလုပ်တော့ပါ</span>
                </button>
                <button type="button" wire:click="delete" class="btn bg-red-600 hover:bg-red-700 text-white">
                    <span class="myanmar-text">ဖျက်မည်</span>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/admin/categories-management.blade.php ENDPATH**/ ?>