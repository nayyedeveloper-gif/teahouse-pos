<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
            <p class="text-sm text-green-700 myanmar-text"><?php echo e(session('message')); ?></p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <?php if(session()->has('error')): ?>
        <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
            <p class="text-sm text-red-700 myanmar-text"><?php echo e(session('error')); ?></p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 myanmar-text">ဝယ်ယူမှုမှတ်တမ်းများ စီမံခန့်ခွဲမှု</h2>
            <button wire:click="openModal" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">
                <span class="myanmar-text">ဝယ်ယူမှုအသစ် ထည့်ရန်</span>
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="PO Number, Supplier..." class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">PO Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase myanmar-text">ပစ္စည်းပေးသွင်းသူ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase myanmar-text">ရက်စွဲ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase myanmar-text">တန်ဖိုး</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase myanmar-text">အခြေအနေ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase myanmar-text">လုပ်ဆောင်ချက်</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $purchaseOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $po): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e($po->po_number); ?></td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900"><?php echo e($po->supplier->name); ?></div>
                            <!--[if BLOCK]><![endif]--><?php if($po->supplier->name_mm): ?>
                            <div class="text-sm text-gray-500 myanmar-text"><?php echo e($po->supplier->name_mm); ?></div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($po->order_date->format('Y-m-d')); ?></td>
                        <td class="px-6 py-4 text-right text-sm font-medium text-gray-900"><?php echo e(number_format($po->total_amount)); ?> Ks</td>
                        <td class="px-6 py-4">
                            <!--[if BLOCK]><![endif]--><?php if($po->status === 'pending'): ?>
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 myanmar-text">စောင့်ဆိုင်းဆဲ</span>
                            <?php elseif($po->status === 'received'): ?>
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 myanmar-text">ရောက်ရှိပြီး</span>
                            <?php else: ?>
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 myanmar-text">ပယ်ဖျက်ပြီး</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button wire:click="edit(<?php echo e($po->id); ?>)" class="text-primary-600 hover:text-primary-900 mr-3">Edit</button>
                            <button wire:click="delete(<?php echo e($po->id); ?>)" wire:confirm="ဖျက်မှာ သေချာပါသလား?" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 myanmar-text">ဝယ်ယူမှုမှတ်တမ်း မရှိသေးပါ</td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
            <div class="px-6 py-4"><?php echo e($purchaseOrders->links()); ?></div>
        </div>

        <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="closeModal"></div>
                <div class="relative bg-white rounded-lg max-w-2xl w-full p-6">
                    <h3 class="text-lg font-medium mb-4 myanmar-text"><?php echo e($editMode ? 'ပြင်ဆင်ရန်' : 'အသစ်ထည့်ရန်'); ?></h3>
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium mb-1 myanmar-text">ပစ္စည်းပေးသွင်းသူ *</label>
                                <select wire:model="supplier_id" class="w-full px-4 py-2 border rounded-lg" required>
                                    <option value="">ရွေးချယ်ပါ...</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->name); ?> <!--[if BLOCK]><![endif]--><?php if($supplier->name_mm): ?>(<?php echo e($supplier->name_mm); ?>)<?php endif; ?><!--[if ENDBLOCK]><![endif]--></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 myanmar-text">မှာယူသည့်ရက် *</label>
                                <input type="date" wire:model="order_date" class="w-full px-4 py-2 border rounded-lg" required>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['order_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 myanmar-text">ရောက်မည့်ရက်</label>
                                <input type="date" wire:model="expected_delivery_date" class="w-full px-4 py-2 border rounded-lg">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['expected_delivery_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 myanmar-text">စုစုပေါင်းတန်ဖိုး *</label>
                                <input type="number" step="0.01" wire:model="total_amount" class="w-full px-4 py-2 border rounded-lg" required>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['total_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 myanmar-text">အခြေအနေ *</label>
                                <select wire:model="status" class="w-full px-4 py-2 border rounded-lg" required>
                                    <option value="pending">စောင့်ဆိုင်းဆဲ</option>
                                    <option value="received">ရောက်ရှိပြီး</option>
                                    <option value="cancelled">ပယ်ဖျက်ပြီး</option>
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium mb-1 myanmar-text">မှတ်ချက်</label>
                                <textarea wire:model="notes" rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 border rounded-lg myanmar-text">ပိတ်မည်</button>
                            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg myanmar-text">သိမ်းဆည်းမည်</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/admin/inventory/purchase-order-management.blade.php ENDPATH**/ ?>