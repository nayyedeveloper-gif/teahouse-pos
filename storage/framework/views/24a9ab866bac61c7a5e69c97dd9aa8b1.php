<div x-data="{ activeTab: 'general' }">
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
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 myanmar-text">စနစ် ဆက်တင်များ</h2>
        <p class="mt-1 text-sm text-gray-600 myanmar-text">လုပ်ငန်းနှင့် စနစ် ဆက်တင်များကို သတ်မှတ်ပါ။</p>
    </div>

    <!-- Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button type="button" @click="activeTab = 'general'" 
                    :class="activeTab === 'general' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <span class="myanmar-text">General</span>
                </button>
                <button type="button" @click="activeTab = 'signage'" 
                    :class="activeTab === 'signage' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Digital Signage
                </button>
                <button type="button" @click="activeTab = 'system'" 
                    :class="activeTab === 'system' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <span class="myanmar-text">Developer Settings</span>
                </button>
            </nav>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <!-- General Tab -->
        <div x-show="activeTab === 'general'" class="space-y-6">
            <!-- App Settings -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">အက်ပ်ဆက်တင်များ</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- App Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အက်ပ်အမည် *</label>
                        <input type="text" wire:model="app_name" class="input myanmar-text" placeholder="Thar Cho POS">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['app_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Logo Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">လိုဂို</label>
                        
                        <!--[if BLOCK]><![endif]--><?php if($current_logo): ?>
                            <div class="mb-3 flex items-center space-x-4">
                                <img src="<?php echo e(Storage::url($current_logo)); ?>" alt="Current Logo" class="h-20 w-20 object-contain border rounded">
                                <button type="button" wire:click="deleteLogo" class="btn btn-danger btn-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span class="myanmar-text">ဖျက်မည်</span>
                                </button>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <input type="file" wire:model="logo" accept="image/*" class="input">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <p class="text-xs text-gray-500 mt-1 myanmar-text">PNG, JPG သို့မဟုတ် GIF (အများဆုံး 2MB)</p>
                        
                        <!--[if BLOCK]><![endif]--><?php if($logo): ?>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 myanmar-text">အသစ်ရွေးချယ်ထားသော ပုံ:</p>
                                <img src="<?php echo e($logo->temporaryUrl()); ?>" alt="Preview" class="mt-2 h-20 w-20 object-contain border rounded">
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <!-- Business Information -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">လုပ်ငန်း အချက်အလက်များ</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Business Name (English) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Business Name (English) *</label>
                        <input type="text" wire:model="business_name" class="input" placeholder="Thar Cho Cafe">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['business_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Business Name (Myanmar) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">လုပ်ငန်းအမည် (မြန်မာ) *</label>
                        <input type="text" wire:model="business_name_mm" class="input myanmar-text" placeholder="သာချိုကော်ဖီဆိုင်">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['business_name_mm'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Business Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">လိပ်စာ</label>
                        <textarea wire:model="business_address" rows="2" class="input" placeholder="လုပ်ငန်း လိပ်စာ..."></textarea>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['business_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Business Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ဖုန်းနံပါတ်</label>
                        <input type="text" wire:model="business_phone" class="input" placeholder="09xxxxxxxxx">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['business_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Business Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အီးမေးလ်</label>
                        <input type="email" wire:model="business_email" class="input" placeholder="info@tharchocafe.com">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['business_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <!-- Tax & Charges -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900 myanmar-text">အခွန်နှင့် ဝန်ဆောင်မှု ကြေး</h3>
                    <p class="text-sm text-gray-600 mt-1 myanmar-text">
                        ဤဆက်တင်များကို Cashier POS တွင် အလိုအလျောက် အသုံးပြုမည်ဖြစ်ပါသည်။
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Default Tax Percentage -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">မူလ အခွန် ရာခိုင်နှုန်း *</label>
                        <div class="relative">
                            <input type="number" wire:model="default_tax_percentage" class="input pr-8" placeholder="0" min="0" max="100" step="0.01">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">%</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 myanmar-text">Cashier POS တွင် အလိုအလျောက် ထည့်သွင်းမည်</p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['default_tax_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Default Service Charge -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">မူလ ဝန်ဆောင်မှု ကြေး *</label>
                        <div class="relative">
                            <input type="number" wire:model="default_service_charge" class="input pr-12" placeholder="0" min="0" step="1">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Ks</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 myanmar-text">Cashier POS တွင် အလိုအလျောက် ထည့်သွင်းမည်</p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['default_service_charge'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <p class="mt-2 text-xs text-gray-500 myanmar-text">
                    ဤတန်ဖိုးများသည် အော်ဒါအသစ်များအတွက် မူလတန်ဖိုး ဖြစ်ပါသည်။ အော်ဒါတစ်ခုချင်းစီတွင် ပြောင်းလဲနိုင်ပါသည်။
                </p>
            </div>

            <!-- Receipt Settings -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">ငွေလက်ခံ ဆက်တင်များ</h3>
                
                <div class="space-y-4">
                    <!-- Receipt Header -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ငွေလက်ခံ ခေါင်းစီး</label>
                        <textarea wire:model="receipt_header" rows="3" class="input myanmar-text" placeholder="ကြိုဆိုပါသည်..."></textarea>
                        <p class="mt-1 text-xs text-gray-500 myanmar-text">ငွေလက်ခံ အပေါ်ဆုံးတွင် ပြသမည့် စာသား</p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['receipt_header'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Receipt Footer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ငွေလက်ခံ အောက်ခြေ</label>
                        <textarea wire:model="receipt_footer" rows="3" class="input myanmar-text" placeholder="ကျေးဇူးတင်ပါသည်..."></textarea>
                        <p class="mt-1 text-xs text-gray-500 myanmar-text">ငွေလက်ခံ အောက်ဆုံးတွင် ပြသမည့် စာသား</p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['receipt_footer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Show Logo on Receipt -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="show_logo_on_receipt" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700 myanmar-text">ငွေလက်ခံတွင် လိုဂို ပြသရန်</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- System Settings -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">စနစ် ဆက်တင်များ</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Currency Symbol -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ငွေကြေး သင်္ကေတ *</label>
                        <input type="text" wire:model="currency_symbol" class="input" placeholder="Ks">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['currency_symbol'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Timezone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အချိန်ဇုန် *</label>
                        <select wire:model="timezone" class="input">
                            <option value="Asia/Yangon">Asia/Yangon (Myanmar)</option>
                            <option value="Asia/Bangkok">Asia/Bangkok (Thailand)</option>
                            <option value="Asia/Singapore">Asia/Singapore</option>
                            <option value="UTC">UTC</option>
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Date Format -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရက်စွဲ ပုံစံ *</label>
                        <select wire:model="date_format" class="input">
                            <option value="Y-m-d">YYYY-MM-DD (2024-01-15)</option>
                            <option value="d/m/Y">DD/MM/YYYY (15/01/2024)</option>
                            <option value="m/d/Y">MM/DD/YYYY (01/15/2024)</option>
                            <option value="d-M-Y">DD-MMM-YYYY (15-Jan-2024)</option>
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['date_format'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Time Format -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အချိန် ပုံစံ *</label>
                        <select wire:model="time_format" class="input">
                            <option value="H:i">24-hour (14:30)</option>
                            <option value="h:i A">12-hour (02:30 PM)</option>
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['time_format'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <!-- Receipt Preview -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">ငွေလက်ခံ အစမ်းကြည့်ရှုမှု</h3>
                
                <div class="bg-gray-50 p-6 rounded border-2 border-dashed border-gray-300 font-mono text-sm">
                    <div class="text-center mb-4">
                        <!-- Logo Preview -->
                        <!--[if BLOCK]><![endif]--><?php if($show_logo_on_receipt && ($current_logo || $logo)): ?>
                            <div class="mb-3 flex justify-center">
                                <!--[if BLOCK]><![endif]--><?php if($logo): ?>
                                    <img src="<?php echo e($logo->temporaryUrl()); ?>" alt="Logo Preview" class="h-16 w-16 object-contain">
                                <?php elseif($current_logo): ?>
                                    <img src="<?php echo e(Storage::url($current_logo)); ?>" alt="Logo" class="h-16 w-16 object-contain">
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <!--[if BLOCK]><![endif]--><?php if($receipt_header): ?>
                        <div class="mb-2 myanmar-text"><?php echo e($receipt_header); ?></div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="font-bold text-lg myanmar-text"><?php echo e($business_name_mm); ?></div>
                        <div><?php echo e($business_name); ?></div>
                        <!--[if BLOCK]><![endif]--><?php if($business_address): ?>
                        <div class="text-xs mt-1"><?php echo e($business_address); ?></div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($business_phone): ?>
                        <div class="text-xs">Tel: <?php echo e($business_phone); ?></div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    
                    <div class="border-t border-b border-gray-400 py-2 my-2">
                        <div class="flex justify-between">
                            <span>Order #:</span>
                            <span>20240001</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Date:</span>
                            <span><?php echo e(now()->format($date_format)); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Time:</span>
                            <span><?php echo e(now()->format($time_format)); ?></span>
                        </div>
                    </div>
                    
                    <div class="my-2">
                        <div class="flex justify-between">
                            <span>Sample Item 1</span>
                            <span>5,000 <?php echo e($currency_symbol); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Sample Item 2</span>
                            <span>3,000 <?php echo e($currency_symbol); ?></span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-400 pt-2 mt-2">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span>8,000 <?php echo e($currency_symbol); ?></span>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($default_tax_percentage > 0): ?>
                        <div class="flex justify-between">
                            <span>Tax (<?php echo e($default_tax_percentage); ?>%):</span>
                            <span><?php echo e(number_format(8000 * $default_tax_percentage / 100)); ?> <?php echo e($currency_symbol); ?></span>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($default_service_charge > 0): ?>
                        <div class="flex justify-between">
                            <span>Service Charge:</span>
                            <span><?php echo e(number_format($default_service_charge)); ?> <?php echo e($currency_symbol); ?></span>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="flex justify-between font-bold text-base mt-1">
                            <span>TOTAL:</span>
                            <span><?php echo e(number_format(8000 + (8000 * $default_tax_percentage / 100) + $default_service_charge)); ?> <?php echo e($currency_symbol); ?></span>
                        </div>
                    </div>
                    
                    <!--[if BLOCK]><![endif]--><?php if($receipt_footer): ?>
                    <div class="text-center mt-4 text-xs myanmar-text">
                        <?php echo e($receipt_footer); ?>

                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

        </div>

        <!-- Digital Signage Tab -->
        <div x-show="activeTab === 'signage'" class="space-y-6">
            <!-- Signage Control -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <div class="flex items-center space-x-2 mb-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Digital Signage Control</h3>
                </div>
                
                <div class="space-y-4">
                    <!-- Enable/Disable -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900 myanmar-text">Digital Signage ဖွင့်ရန်</label>
                            <p class="text-xs text-gray-500 myanmar-text">Digital Signage Display ကို ဖွင့်/ပိတ် လုပ်ပါ</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="signage_enabled" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>

                    <!-- Promotional Message -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Promotional Message</label>
                        <textarea wire:model="promotional_message" rows="3" class="input" placeholder="🎉 Welcome! Special offers available today! 🎉"></textarea>
                        <p class="mt-1 text-xs text-gray-500 myanmar-text">ဤစာသားသည် Digital Signage Display ထိပ်တွင် scroll လုပ်ပြီး ပြသမည်။</p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['promotional_message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <!-- Display Settings -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">Display ဆက်တင်များ</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Rotation Speed -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Category Rotation Speed (seconds)</label>
                        <input type="number" wire:model="signage_rotation_speed" class="input" min="5" max="60" step="5">
                        <p class="mt-1 text-xs text-gray-500 myanmar-text">Category များ အလိုအလျောက် ပြောင်းမည့် အချိန် (စက္ကန့်)</p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['signage_rotation_speed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Auto Refresh -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Auto Refresh (minutes)</label>
                        <input type="number" wire:model="signage_auto_refresh" class="input" min="1" max="60" step="1">
                        <p class="mt-1 text-xs text-gray-500 myanmar-text">စျေးနှုန်းများ အလိုအလျောက် update လုပ်မည့် အချိန် (မိနစ်)</p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['signage_auto_refresh'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Theme -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Theme</label>
                        <select wire:model="signage_theme" class="input">
                            <option value="dark">Dark (Recommended for TV)</option>
                            <option value="light">Light</option>
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['signage_theme'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <!-- Content Settings -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">Content ဆက်တင်များ</h3>
                
                <div class="space-y-3">
                    <!-- Show Prices -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900 myanmar-text">စျေးနှုန်းများ ပြသရန်</label>
                            <p class="text-xs text-gray-500 myanmar-text">Item စျေးနှုန်းများကို ပြသမည်</p>
                        </div>
                        <input type="checkbox" wire:model="signage_show_prices" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500">
                    </div>

                    <!-- Show Descriptions -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900 myanmar-text">အကြောင်းအရာ ပြသရန်</label>
                            <p class="text-xs text-gray-500 myanmar-text">Item ၏ အကြောင်းအရာကို ပြသမည်</p>
                        </div>
                        <input type="checkbox" wire:model="signage_show_descriptions" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500">
                    </div>

                    <!-- Show Availability -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900 myanmar-text">ရရှိနိုင်မှု Status ပြသရန်</label>
                            <p class="text-xs text-gray-500 myanmar-text">Available/Sold Out badge များကို ပြသမည်</p>
                        </div>
                        <input type="checkbox" wire:model="signage_show_availability" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500">
                    </div>

                    <!-- Show Media/Ads -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900 myanmar-text">Videos/Ads ပြသရန်</label>
                            <p class="text-xs text-gray-500 myanmar-text">Menu items များကြားတွင် videos နဲ့ promotional images များ ပြသမည်</p>
                        </div>
                        <input type="checkbox" wire:model="signage_show_media" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500">
                    </div>
                </div>
            </div>

            <!-- Quick Access -->
            <div class="bg-gradient-to-r from-primary-50 to-primary-100 rounded-lg shadow-sm p-4 md:p-6 border border-primary-200">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="flex items-center space-x-2 mb-1">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900">Quick Access</h3>
                        </div>
                        <p class="text-sm text-gray-600 myanmar-text">Digital Signage Display ကို ဖွင့်ရန်</p>
                    </div>
                    <a href="<?php echo e(route('display.signage')); ?>" target="_blank" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Open Display
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="p-3 bg-white rounded border border-primary-200">
                        <p class="text-xs text-gray-500 mb-1 myanmar-text">Display URL:</p>
                        <p class="text-xs text-gray-600 font-mono break-all"><?php echo e(url('/display/signage')); ?></p>
                        <button onclick="navigator.clipboard.writeText('<?php echo e(url('/display/signage')); ?>')" class="mt-2 text-xs text-primary-600 hover:text-primary-800 flex items-center space-x-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                            </svg>
                            <span>Copy URL</span>
                        </button>
                    </div>
                    <div class="p-3 bg-white rounded border border-primary-200">
                        <a href="<?php echo e(route('admin.signage-media.index')); ?>" class="flex items-center text-sm text-primary-600 hover:text-primary-800">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <span class="myanmar-text">Manage Media</span>
                        </a>
                    </div>
                    <div class="p-3 bg-white rounded border border-primary-200">
                        <a href="<?php echo e(route('admin.signage-analytics.index')); ?>" class="flex items-center text-sm text-primary-600 hover:text-primary-800">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="myanmar-text">View Analytics</span>
                        </a>
                    </div>
                    <div class="p-3 bg-white rounded border border-primary-200 text-center">
                        <p class="text-xs text-gray-500 mb-2 myanmar-text">QR Code:</p>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo e(urlencode(url('/display/signage'))); ?>" alt="QR Code" class="mx-auto">
                        <p class="text-xs text-gray-500 mt-1 myanmar-text">Scan to open</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Tab -->
        <div x-show="activeTab === 'system'" class="space-y-6">
            <!-- Auto Print Settings -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <div class="flex items-center space-x-2 mb-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 myanmar-text">အလိုအလျောက် Print လုပ်ခြင်း</h3>
                </div>
                
                <div class="space-y-4">
                    <!-- Kitchen Auto Print -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900 myanmar-text">မီးဖိုချောင်သို့ အလိုအလျောက် Print လုပ်ရန်</label>
                            <p class="text-xs text-gray-500 myanmar-text">အော်ဒါ အသစ်တစ်ခု ဖန်တီးသည့်အခါ မီးဖိုချောင်သို့ အလိုအလျောက် print လုပ်မည်</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="auto_print_kitchen" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>

                    <!-- Bar Auto Print -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900 myanmar-text">ဘားသို့ အလိုအလျောက် Print လုပ်ရန်</label>
                            <p class="text-xs text-gray-500 myanmar-text">အော်ဒါ အသစ်တစ်ခု ဖန်တီးသည့်အခါ ဘားသို့ အလိုအလျောက် print လုပ်မည်</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="auto_print_bar" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>

                    <!-- Receipt Auto Print -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-medium text-gray-900 myanmar-text">ငွေလက်ခံဖြတ်ပိုင်း အလိုအလျောက် Print လုပ်ရန်</label>
                            <p class="text-xs text-gray-500 myanmar-text">ငွေပေးချေမှု ပြီးစီးသည့်အခါ ငွေလက်ခံဖြတ်ပိုင်း အလိုအလျောက် print လုပ်မည်</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="auto_print_receipt" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-blue-800 myanmar-text">
                                <strong>မှတ်ချက်:</strong> Printer များကို Printer Management စာမျက်နှာတွင် configure လုပ်ရန် လိုအပ်ပါသည်။ 
                                Auto-print ကို ပိတ်ထားပါက manual print လုပ်ရန် လိုအပ်ပါမည်။
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Food Court Card System -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <div class="flex items-center space-x-2 mb-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 myanmar-text">Food Court Card System</h3>
                </div>
                
                <div class="space-y-4">
                    <!-- Enable Card System -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border-2 border-primary-200">
                        <div>
                            <label class="text-sm font-medium text-gray-900 myanmar-text">Card System ကို အသုံးပြုမည်</label>
                            <p class="text-xs text-gray-500 myanmar-text">Prepaid card system ကို ဖွင့်/ပိတ် လုပ်နိုင်ပါသည်</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="card_system_enabled" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>

                    <div x-show="$wire.card_system_enabled" class="space-y-4">
                        <!-- Bonus Promotion -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <label class="text-sm font-medium text-gray-900 myanmar-text">Bonus Promotion ကို အသုံးပြုမည်</label>
                                <p class="text-xs text-gray-500 myanmar-text">Card load လုပ်သည့်အခါ bonus ပေးမည်</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="card_bonus_enabled" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                            </label>
                        </div>

                        <div x-show="$wire.card_bonus_enabled" class="pl-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Bonus ရာခိုင်နှုန်း (%)</label>
                            <div class="relative">
                                <input type="number" wire:model="card_bonus_percentage" class="input pr-8" placeholder="10" min="0" max="100" step="0.1">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">%</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 myanmar-text">
                                ဥပမာ: 10% ဆိုလျှင် 10,000 Ks load လုပ်သည့်အခါ 11,000 Ks balance ရရှိမည်
                            </p>
                        </div>

                        <!-- Card Expiry -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <label class="text-sm font-medium text-gray-900 myanmar-text">Card သက်တမ်း သတ်မှတ်မည်</label>
                                <p class="text-xs text-gray-500 myanmar-text">Card များကို သက်တမ်း သတ်မှတ်မည်</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="card_expiry_enabled" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                            </label>
                        </div>

                        <div x-show="$wire.card_expiry_enabled" class="pl-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">သက်တမ်း (လ)</label>
                            <input type="number" wire:model="card_expiry_months" class="input" placeholder="12" min="1" max="60">
                            <p class="text-xs text-gray-500 mt-1 myanmar-text">
                                Card ထုတ်ပေးသည့်နေ့မှ စတင်၍ သက်တမ်း သတ်မှတ်မည်
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-yellow-800 myanmar-text">
                                <strong>သတိပြုရန်:</strong> Card System ကို ပိတ်ထားပါက Cashier POS တွင် card payment option မပေါ်ပါ။ 
                                Card Management သည် Admin Menu တွင် ရှိပါသည်။
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- System Information -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">စနစ် အချက်အလက်</h3>
                
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="font-medium text-gray-700">Developer:</dt>
                            <dd class="text-gray-600 mt-1">Nay Ye Maung</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700">Version:</dt>
                            <dd class="text-gray-600 mt-1">2.0</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700">Laravel:</dt>
                            <dd class="text-gray-600 mt-1"><?php echo e(app()->version()); ?></dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700">PHP:</dt>
                            <dd class="text-gray-600 mt-1"><?php echo e(PHP_VERSION); ?></dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700">Environment:</dt>
                            <dd class="text-gray-600 mt-1"><?php echo e(config('app.env')); ?></dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700">Debug Mode:</dt>
                            <dd class="text-gray-600 mt-1"><?php echo e(config('app.debug') ? 'Enabled' : 'Disabled'); ?></dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Change Logs -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Change Logs</h3>
                
                <div class="space-y-3">
                    <div class="border-l-4 border-green-400 bg-green-50 p-3 rounded">
                        <div class="flex items-start">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                v2.0
                            </span>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">November 3, 2025</p>
                                <ul class="mt-1 text-sm text-gray-600 list-disc list-inside space-y-1">
                                    <li>Added Users Management with CRUD operations</li>
                                    <li>Added Excel export for Users and Reports</li>
                                    <li>Added password show/hide toggle</li>
                                    <li>Improved modal consistency</li>
                                    <li>Added API documentation</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="border-l-4 border-blue-400 bg-blue-50 p-3 rounded">
                        <div class="flex items-start">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                v1.0
                            </span>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">October 2025</p>
                                <ul class="mt-1 text-sm text-gray-600 list-disc list-inside space-y-1">
                                    <li>Initial release</li>
                                    <li>POS system with order management</li>
                                    <li>Receipt printing</li>
                                    <li>Basic reporting</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Logs -->
            <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Error Logs</h3>
                    <span class="text-xs text-gray-500 myanmar-text">နောက်ဆုံး 10 ခု</span>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <?php
                        $logFile = storage_path('logs/laravel.log');
                        $logs = [];
                        if (file_exists($logFile)) {
                            $content = file_get_contents($logFile);
                            preg_match_all('/\[(\d{4}-\d{2}-\d{2}[^\]]+)\] (\w+)\.(\w+): (.+)/', $content, $matches, PREG_SET_ORDER);
                            $logs = array_slice(array_reverse($matches), 0, 10);
                        }
                    ?>

                    <!--[if BLOCK]><![endif]--><?php if(empty($logs)): ?>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 myanmar-text">အမှားအယွင်း မတွေ့ပါ</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-white border border-gray-200 rounded p-3 text-xs">
                                    <div class="flex items-start justify-between">
                                        <span class="font-mono text-gray-500"><?php echo e($log[1]); ?></span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                            <?php echo e($log[3] === 'ERROR' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                            <?php echo e($log[3]); ?>

                                        </span>
                                    </div>
                                    <p class="mt-1 text-gray-700 break-all"><?php echo e(Str::limit($log[4], 200)); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

        </div>

        <!-- Save Button (Fixed at bottom for all tabs) -->
        <div class="mt-6 flex justify-end">
            <button type="submit" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                <span class="myanmar-text">သိမ်းဆည်းမည်</span>
            </button>
        </div>
    </form>

</div>
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/admin/settings-management.blade.php ENDPATH**/ ?>