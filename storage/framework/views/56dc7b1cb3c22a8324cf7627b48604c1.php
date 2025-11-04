<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 myanmar-text">ကိုယ်ရေးအချက်အလက်</h1>
            <p class="mt-2 text-sm text-gray-600 myanmar-text">
                သင့်အကောင့်အချက်အလက်များကို စီမံခန့်ခွဲပါ
            </p>
        </div>

        <!-- Success Messages -->
        <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <?php if(session()->has('password_success')): ?>
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <?php echo e(session('password_success')); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="space-y-6">
            <!-- Profile Information -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold text-gray-900 myanmar-text">
                        ကိုယ်ရေးအချက်အလက်
                    </h2>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updateProfile" class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="form-label myanmar-text">အမည်</label>
                            <input type="text" wire:model="name" class="form-input" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="form-label myanmar-text">အီးမေးလ်</label>
                            <input type="email" wire:model="email" class="form-input" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="form-label myanmar-text">ဖုန်းနံပါတ်</label>
                            <input type="text" wire:model="phone" class="form-input">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Role (Read-only) -->
                        <div>
                            <label class="form-label myanmar-text">ရာထူး</label>
                            <input type="text" value="<?php echo e(auth()->user()->roles->first()->name ?? 'N/A'); ?>" class="form-input bg-gray-100" readonly>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="myanmar-text">သိမ်းဆံးမည်</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold text-gray-900 myanmar-text">
                        လျို့ဝှက်နံပါတ်ပြောင်လဲရန်
                    </h2>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updatePassword" class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label class="form-label myanmar-text">လက်ရှိလျို့ဝှက်နံပါတ်</label>
                            <input type="password" wire:model="current_password" class="form-input" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- New Password -->
                        <div>
                            <label class="form-label myanmar-text">လျို့ဝှက်နံပါတ်အသသ်</label>
                            <input type="password" wire:model="password" class="form-input" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="form-label myanmar-text">လျို့ဝှက်နံပါတ်အတည်ပြုရန်</label>
                            <input type="password" wire:model="password_confirmation" class="form-input" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="myanmar-text">လျို့ဝှက်နံပါတ်ပြောင်မည်</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/profile/edit-profile.blade.php ENDPATH**/ ?>