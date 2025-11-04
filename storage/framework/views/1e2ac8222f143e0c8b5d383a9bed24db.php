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

    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 myanmar-text">ပစ္စည်းများ စီမံခန့်ခွဲမှု</h2>
            <p class="mt-1 text-sm text-gray-600 myanmar-text">ပစ္စည်းများကို ထည့်သွင်း၊ ပြင်ဆင်၊ ဖျက်ပစ်နိုင်ပါသည်။</p>
        </div>
        <button wire:click="create" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span class="myanmar-text">ပစ္စည်းအသစ် ထည့်ရန်</span>
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 md:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရှာဖွေရန်</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="ပစ္စည်းအမည် ရှာရန်..." class="input">
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အမျိုးအစား</label>
                <select wire:model.live="categoryFilter" class="input">
                    <option value="">အားလုံး</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name_mm); ?> / <?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အခြေအနေ</label>
                <select wire:model.live="statusFilter" class="input">
                    <option value="">အားလုံး</option>
                    <option value="available">ရရှိနိုင်သော</option>
                    <option value="unavailable">မရရှိနိုင်သော</option>
                    <option value="active">အသုံးပြုနေသော</option>
                    <option value="inactive">အသုံးမပြုတော့သော</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">ပုံ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အမည်</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အမျိုးအစား</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">ဈေး</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အခြေအနေ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">လုပ်ဆောင်ချက်</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <!--[if BLOCK]><![endif]--><?php if($item->image): ?>
                            <img src="<?php echo e(Storage::url($item->image)); ?>" alt="<?php echo e($item->name); ?>" class="h-16 w-16 rounded-lg object-cover">
                            <?php else: ?>
                            <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 myanmar-text"><?php echo e($item->name_mm); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($item->name); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 myanmar-text"><?php echo e($item->category->name_mm); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($item->category->name); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e(number_format($item->price, 0)); ?> Ks
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-1">
                                <!--[if BLOCK]><![endif]--><?php if($item->is_available): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 myanmar-text">
                                    ရရှိနိုင်သော
                                </span>
                                <?php else: ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 myanmar-text">
                                    မရရှိနိုင်သော
                                </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                
                                <!--[if BLOCK]><![endif]--><?php if($item->is_active): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 myanmar-text">
                                    အသုံးပြုနေသော
                                </span>
                                <?php else: ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 myanmar-text">
                                    ပိတ်ထားသော
                                </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button wire:click="toggleAvailability(<?php echo e($item->id); ?>)" class="text-blue-600 hover:text-blue-900" title="ရရှိနိုင်မှု ပြောင်းရန်">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                                <button wire:click="edit(<?php echo e($item->id); ?>)" class="text-indigo-600 hover:text-indigo-900" title="ပြင်ဆင်ရန်">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete(<?php echo e($item->id); ?>)" class="text-red-600 hover:text-red-900" title="ဖျက်ရန်">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 myanmar-text">
                            ပစ္စည်း မတွေ့ပါ
                        </td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($items->links()); ?>

        </div>
    </div>

    <!-- Create/Edit Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 myanmar-text">
                    <?php echo e($editMode ? 'ပစ္စည်း ပြင်ဆင်ရန်' : 'ပစ္စည်းအသစ် ထည့်ရန်'); ?>

                </h3>
            </div>

            <form wire:submit.prevent="save">
                <div class="px-6 py-4 space-y-4">
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အမျိုးအစား *</label>
                        <select wire:model="category_id" class="input">
                            <option value="">ရွေးချယ်ပါ</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name_mm); ?> / <?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

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
                        <textarea wire:model="description" rows="3" class="input" placeholder="ပစ္စည်းအကြောင်း ဖော်ပြချက်..."></textarea>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ဈေး (Kyat) *</label>
                        <input type="number" wire:model="price" class="input" placeholder="3000" min="0" step="1">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ပုံ</label>
                        <input type="file" wire:model="image" accept="image/*" class="input">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <!--[if BLOCK]><![endif]--><?php if($image): ?>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 myanmar-text">အသစ်ရွေးချယ်ထားသော ပုံ:</p>
                            <img src="<?php echo e($image->temporaryUrl()); ?>" class="mt-2 h-40 w-40 object-cover rounded-lg border-2 border-gray-200">
                        </div>
                        <?php elseif($editMode && $existingImage): ?>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 myanmar-text">လက်ရှိ ပုံ:</p>
                            <img src="<?php echo e(Storage::url($existingImage)); ?>" class="mt-2 h-40 w-40 object-cover rounded-lg border-2 border-gray-200">
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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

                    <!-- Checkboxes -->
                    <div class="flex space-x-6">
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="is_available" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700 myanmar-text">ရရှိနိုင်သော</span>
                        </label>

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
                        <h3 class="text-lg font-medium text-gray-900 myanmar-text">ပစ္စည်း ဖျက်ရန် သေချာပါသလား?</h3>
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
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/admin/items-management.blade.php ENDPATH**/ ?>