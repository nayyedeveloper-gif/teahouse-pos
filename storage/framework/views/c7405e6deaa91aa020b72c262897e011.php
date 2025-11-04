<div>
    <!-- Success Message -->
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
    <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
        <p class="text-sm text-green-700"><?php echo e(session('message')); ?></p>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900">Digital Signage Media</h2>
            </div>
            <p class="mt-1 text-sm text-gray-600 myanmar-text">Videos နဲ့ Images များကို စီမံခန့်ခွဲပါ</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Media
        </button>
    </div>

    <!-- Media Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $mediaItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition-shadow">
            <!-- Media Preview -->
            <div class="aspect-video bg-gray-100 relative">
                <!--[if BLOCK]><![endif]--><?php if($media->type === 'video'): ?>
                    <video class="w-full h-full object-cover" muted>
                        <source src="<?php echo e(Storage::url($media->file_path)); ?>" type="video/mp4">
                    </video>
                    <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path>
                        </svg>
                    </div>
                <?php else: ?>
                    <img src="<?php echo e(Storage::url($media->file_path)); ?>" alt="<?php echo e($media->title); ?>" class="w-full h-full object-cover">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                
                <!-- Status Badge -->
                <div class="absolute top-2 right-2">
                    <!--[if BLOCK]><![endif]--><?php if($media->is_active): ?>
                    <span class="px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">Active</span>
                    <?php else: ?>
                    <span class="px-2 py-1 bg-gray-500 text-white text-xs font-semibold rounded-full">Inactive</span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Type Badge -->
                <div class="absolute top-2 left-2">
                    <span class="px-2 py-1 bg-primary-500 text-white text-xs font-semibold rounded-full flex items-center space-x-1">
                        <!--[if BLOCK]><![endif]--><?php if($media->type === 'video'): ?>
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                            </svg>
                            <span>Video</span>
                        <?php else: ?>
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Image</span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </span>
                </div>
            </div>

            <!-- Media Info -->
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 truncate myanmar-text"><?php echo e($media->title_mm ?? $media->title); ?></h3>
                <p class="text-sm text-gray-500 truncate"><?php echo e($media->title); ?></p>
                
                <div class="mt-2 flex items-center text-xs text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <?php echo e($media->duration); ?> seconds
                </div>

                <!-- Actions -->
                <div class="mt-4 flex items-center justify-between">
                    <button wire:click="toggleActive(<?php echo e($media->id); ?>)" class="text-sm text-gray-600 hover:text-primary-600">
                        <!--[if BLOCK]><![endif]--><?php if($media->is_active): ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <?php else: ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </button>
                    
                    <div class="flex space-x-2">
                        <button wire:click="edit(<?php echo e($media->id); ?>)" class="text-sm text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        <button wire:click="delete(<?php echo e($media->id); ?>)" wire:confirm="Are you sure you want to delete this media?" class="text-sm text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <p class="mt-2 text-gray-500 myanmar-text">Media မရှိသေးပါ။ Add Media ကို နှိပ်ပြီး စတင်ပါ။</p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        <?php echo e($mediaItems->links()); ?>

    </div>

    <!-- Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <?php echo e($editingId ? 'Edit Media' : 'Add New Media'); ?>

                </h3>

                <form wire:submit.prevent="save" class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <input type="text" wire:model="title" class="input" placeholder="Summer Sale Promo">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Title MM -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Title (Myanmar)</label>
                        <input type="text" wire:model="title_mm" class="input myanmar-text" placeholder="နွေရာသီ အထူးလျှော့စျေး">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['title_mm'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Media Type *</label>
                        <select wire:model="type" class="input">
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <?php echo e($type === 'video' ? 'Video File' : 'Image File'); ?> *
                        </label>
                        <input type="file" wire:model="file" class="input" accept="<?php echo e($type === 'video' ? 'video/*' : 'image/*'); ?>">
                        <p class="mt-1 text-xs text-gray-500">
                            <?php echo e($type === 'video' ? 'MP4, WebM, MOV (Max 50MB)' : 'JPG, PNG, GIF (Max 50MB)'); ?>

                        </p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <!--[if BLOCK]><![endif]--><?php if($file): ?>
                        <div class="mt-2 text-sm text-green-600">File selected: <?php echo e($file->getClientOriginalName()); ?></div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Duration (seconds) *
                        </label>
                        <input type="number" wire:model="duration" class="input" min="1" max="300">
                        <p class="mt-1 text-xs text-gray-500 myanmar-text">
                            <?php echo e($type === 'video' ? 'Video အတွက် duration သည် အလိုအလျောက် သတ်မှတ်မည်' : 'Image ပြသမည့် အချိန်'); ?>

                        </p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['duration'];
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea wire:model="description" rows="2" class="input" placeholder="Optional description"></textarea>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="is_active" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500">
                        <label class="ml-2 text-sm text-gray-700">Active (Show in display)</label>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="closeModal" class="btn btn-outline">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <?php echo e($editingId ? 'Update' : 'Save'); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/admin/signage-media-management.blade.php ENDPATH**/ ?>