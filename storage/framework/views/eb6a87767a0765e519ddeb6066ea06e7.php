<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 myanmar-text">ပစ္စည်းအလိုက် ရောင်းအားအစီရင်ခံစာ</h2>
        
        <!-- Date Range -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">စတင်ရက်</label>
                    <input type="date" id="startDate" name="startDate" wire:model="startDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ပြီးဆုံးရက်</label>
                    <input type="date" id="endDate" name="endDate" wire:model="endDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div class="flex items-end">
                    <button type="button" wire:click="generateReport" class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                        <span class="myanmar-text">အစီရင်ခံစာ ထုတ်မည်</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">
                                ပစ္စည်းအမည်
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">
                                အရေအတွက်
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">
                                ရောင်းအား
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">
                                အော်ဒါအရေအတွက်
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">
                                ပျမ်းမျှစျေးနှုန်း
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($row['item_name']); ?></div>
                                <!--[if BLOCK]><![endif]--><?php if($row['item_name_mm']): ?>
                                <div class="text-sm text-gray-500 myanmar-text"><?php echo e($row['item_name_mm']); ?></div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-900">
                                <?php echo e(number_format($row['quantity'])); ?>

                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                <?php echo e(number_format($row['sales'])); ?> Ks
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-900">
                                <?php echo e($row['orders']); ?>

                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-900">
                                <?php echo e(number_format($row['avg_price'])); ?> Ks
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <p class="mt-4 text-sm text-gray-500 myanmar-text">ရောင်းအားအချက်အလက် မရှိသေးပါ</p>
                            </td>
                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                    <!--[if BLOCK]><![endif]--><?php if(count($reportData) > 0): ?>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 myanmar-text">စုစုပေါင်း</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                <?php echo e(number_format(collect($reportData)->sum('quantity'))); ?>

                            </td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                <?php echo e(number_format(collect($reportData)->sum('sales'))); ?> Ks
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                <?php echo e(collect($reportData)->sum('orders')); ?>

                            </td>
                            <td class="px-6 py-4"></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </table>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/admin/reports/sales-by-item.blade.php ENDPATH**/ ?>