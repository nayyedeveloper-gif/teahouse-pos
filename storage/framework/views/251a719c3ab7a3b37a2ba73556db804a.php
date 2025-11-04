<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 myanmar-text">Card Management</h2>
                <p class="text-sm text-gray-600 myanmar-text">Food Court Card များကို စီမံခန့်ခွဲရန်</p>
            </div>
            <button wire:click="openIssueModal" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="myanmar-text">Card အသစ် ထုတ်ပေးမည်</span>
            </button>
        </div>

        <!-- Flash Messages -->
        <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <?php echo e(session('message')); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <?php if(session()->has('error')): ?>
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600 myanmar-text">စုစုပေါင်း Cards</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['total_cards'])); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600 myanmar-text">Active Cards</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['active_cards'])); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600 myanmar-text">စုစုပေါင်း Balance</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['total_balance'])); ?> Ks</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600 myanmar-text">စုစုပေါင်း Loaded</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['total_loaded'])); ?> Ks</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow mb-6 p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရှာဖွေရန်</label>
                    <input type="text" wire:model.live.debounce.300ms="search" 
                           placeholder="Card number, customer name..." 
                           class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Status</label>
                    <select wire:model.live="statusFilter" class="input">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="blocked">Blocked</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Card Type</label>
                    <select wire:model.live="cardTypeFilter" class="input">
                        <option value="all">All Types</option>
                        <option value="virtual">Virtual</option>
                        <option value="physical">Physical</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Cards Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Card Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Balance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Issued Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-mono text-sm font-medium text-gray-900"><?php echo e($card->card_number); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!--[if BLOCK]><![endif]--><?php if($card->customer): ?>
                                    <div class="text-sm text-gray-900"><?php echo e($card->customer->name); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo e($card->customer->phone); ?></div>
                                <?php else: ?>
                                    <span class="text-sm text-gray-400">-</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900"><?php echo e(number_format($card->balance)); ?> Ks</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full <?php echo e($card->card_type === 'physical' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo e(ucfirst($card->card_type)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!--[if BLOCK]><![endif]--><?php if($card->status === 'active'): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                <?php elseif($card->status === 'inactive'): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Inactive</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Blocked</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($card->issued_date->format('d M Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button wire:click="openLoadModal(<?php echo e($card->id); ?>)" 
                                        class="text-green-600 hover:text-green-900"
                                        title="Load Money">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                                <button wire:click="openDetailsModal(<?php echo e($card->id); ?>)" 
                                        class="text-blue-600 hover:text-blue-900"
                                        title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <!--[if BLOCK]><![endif]--><?php if($card->status !== 'blocked'): ?>
                                    <button wire:click="toggleStatus(<?php echo e($card->id); ?>)" 
                                            class="text-yellow-600 hover:text-yellow-900"
                                            title="Toggle Status">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="blockCard(<?php echo e($card->id); ?>)" 
                                            onclick="return confirm('Are you sure you want to block this card?')"
                                            class="text-red-600 hover:text-red-900"
                                            title="Block Card">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                        </svg>
                                    </button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 myanmar-text">
                                Card များ မတွေ့ပါ
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                <?php echo e($cards->links()); ?>

            </div>
        </div>
    </div>

    <!-- Issue Card Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showIssueModal): ?>
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium myanmar-text">Card အသစ် ထုတ်ပေးမည်</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Customer (Optional)</label>
                        <select wire:model="customer_id" class="input">
                            <option value="">No Customer</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name); ?> - <?php echo e($customer->phone); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Card Type</label>
                        <select wire:model="card_type" class="input">
                            <option value="virtual">Virtual</option>
                            <option value="physical">Physical</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Initial Balance (Ks)</label>
                        <input type="number" wire:model="initial_balance" class="input" min="0" step="100">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['initial_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Notes</label>
                        <textarea wire:model="notes" class="input" rows="2"></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 border-t flex justify-end space-x-2">
                    <button wire:click="closeIssueModal" class="btn btn-secondary">Cancel</button>
                    <button wire:click="issueCard" class="btn btn-primary">Issue Card</button>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Load Money Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showLoadModal): ?>
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium myanmar-text">ငွေထည့်သွင်းမည်</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Amount (Ks)</label>
                        <input type="number" wire:model="load_amount" class="input" min="100" step="100" autofocus>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['load_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">Payment Method</label>
                        <select wire:model="payment_method" class="input">
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="mobile_payment">Mobile Payment</option>
                        </select>
                    </div>
                </div>
                <div class="px-6 py-4 border-t flex justify-end space-x-2">
                    <button wire:click="closeLoadModal" class="btn btn-secondary">Cancel</button>
                    <button wire:click="loadMoney" class="btn btn-primary">Load Money</button>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Card Details Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showDetailsModal && $selectedCard): ?>
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 overflow-y-auto">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 my-8">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium myanmar-text">Card Details</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">Card Number</p>
                            <p class="font-mono font-medium"><?php echo e($selectedCard->card_number); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">Balance</p>
                            <p class="font-semibold text-lg"><?php echo e(number_format($selectedCard->balance)); ?> Ks</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">Customer</p>
                            <p><?php echo e($selectedCard->customer ? $selectedCard->customer->name : '-'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">Status</p>
                            <p><?php echo e(ucfirst($selectedCard->status)); ?></p>
                        </div>
                    </div>

                    <h4 class="font-medium mb-2 myanmar-text">Transaction History</h4>
                    <div class="max-h-64 overflow-y-auto border rounded">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Type</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Amount</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Balance</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $selectedCard->transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="px-4 py-2 text-xs"><?php echo e($transaction->created_at->format('d M Y H:i')); ?></td>
                                        <td class="px-4 py-2 text-xs">
                                            <span class="px-2 py-1 rounded-full <?php echo e($transaction->transaction_type === 'load' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                                <?php echo e(ucfirst($transaction->transaction_type)); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-xs text-right"><?php echo e(number_format($transaction->amount)); ?> Ks</td>
                                        <td class="px-4 py-2 text-xs text-right font-medium"><?php echo e(number_format($transaction->balance_after)); ?> Ks</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-500 text-sm">No transactions</td>
                                    </tr>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="px-6 py-4 border-t flex justify-end">
                    <button wire:click="closeDetailsModal" class="btn btn-secondary">Close</button>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /Users/developer/Downloads/teahouse-pos/resources/views/livewire/admin/card-management.blade.php ENDPATH**/ ?>