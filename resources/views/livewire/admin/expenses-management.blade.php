<div>
    <!-- Success Message -->
    @if (session()->has('message'))
    <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700 myanmar-text">{{ session('message') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 myanmar-text">အသုံးစရိတ်များ စီမံခန့်ခွဲမှု</h2>
            <p class="mt-1 text-sm text-gray-600 myanmar-text">အသုံးစရိတ်များကို ထည့်သွင်း၊ ပြင်ဆင်၊ ဖျက်ပစ်နိုင်ပါသည်။</p>
        </div>
        <button wire:click="create" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span class="myanmar-text">အသုံးစရိတ်အသစ် ထည့်ရန်</span>
        </button>
    </div>

    <!-- Total Amount Card -->
    <div class="bg-gradient-to-r from-red-500 to-pink-600 rounded-lg shadow-sm p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90 myanmar-text">စုစုပေါင်း အသုံးစရိတ်</p>
                <p class="text-3xl font-bold mt-1">{{ number_format($totalAmount, 0) }} Ks</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 md:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရှာဖွေရန်</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="ဖော်ပြချက်..." class="input">
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အမျိုးအစား</label>
                <select wire:model.live="categoryFilter" class="input">
                    <option value="">အားလုံး</option>
                    @foreach($categories as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရက်စွဲ</label>
                <select wire:model.live="dateFilter" class="input">
                    <option value="today">ယနေ့ / Today</option>
                    <option value="yesterday">မနေ့က / Yesterday</option>
                    <option value="week">ဤအပတ် / This Week</option>
                    <option value="month">ဤလ / This Month</option>
                    <option value="">အားလုံး / All</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">ရက်စွဲ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အမျိုးအစား</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">ဖော်ပြချက်</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">ပမာဏ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">ပေးချေမှု</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">လုပ်ဆောင်ချက်</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($expenses as $expense)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $expense->expense_date->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 myanmar-text">
                                {{ $categories[$expense->category] ?? $expense->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $expense->description }}</div>
                            @if($expense->receipt_number)
                            <div class="text-xs text-gray-500">Receipt: {{ $expense->receipt_number }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">
                            {{ number_format($expense->amount, 0) }} Ks
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ucfirst($expense->payment_method ?? 'Cash') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button wire:click="edit({{ $expense->id }})" class="text-indigo-600 hover:text-indigo-900" title="ပြင်ဆင်ရန်">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $expense->id }})" class="text-red-600 hover:text-red-900" title="ဖျက်ရန်">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 myanmar-text">
                            အသုံးစရိတ် မတွေ့ပါ
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $expenses->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 myanmar-text">
                    {{ $editMode ? 'အသုံးစရိတ် ပြင်ဆင်ရန်' : 'အသုံးစရိတ်အသစ် ထည့်ရန်' }}
                </h3>
            </div>

            <form wire:submit.prevent="save">
                <div class="px-6 py-4 space-y-4">
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အမျိုးအစား *</label>
                        <select wire:model="category" class="input">
                            <option value="">ရွေးချယ်ပါ</option>
                            @foreach($categories as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ဖော်ပြချက် *</label>
                        <input type="text" wire:model="description" class="input" placeholder="အသုံးစရိတ် ဖော်ပြချက်...">
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ပမာဏ (Ks) *</label>
                        <input type="number" wire:model="amount" class="input" placeholder="0" min="0" step="0.01">
                        @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Expense Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရက်စွဲ *</label>
                        <input type="date" wire:model="expense_date" class="input">
                        @error('expense_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ပေးချေမှု နည်းလမ်း</label>
                        <select wire:model="payment_method" class="input">
                            <option value="cash">ငွေသား / Cash</option>
                            <option value="bank_transfer">ဘဏ်လွှဲ / Bank Transfer</option>
                            <option value="card">ကတ် / Card</option>
                            <option value="mobile_payment">မိုဘိုင်းငွေ / Mobile Payment</option>
                        </select>
                        @error('payment_method') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Receipt Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ငွေလက်ခံ နံပါတ်</label>
                        <input type="text" wire:model="receipt_number" class="input" placeholder="Receipt #">
                        @error('receipt_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">မှတ်ချက်</label>
                        <textarea wire:model="notes" rows="3" class="input" placeholder="အခြား မှတ်ချက်များ..."></textarea>
                        @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" wire:click="closeModal" class="btn btn-outline">
                        <span class="myanmar-text">မလုပ်တော့ပါ</span>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span class="myanmar-text">{{ $editMode ? 'ပြင်ဆင်မည်' : 'ထည့်သွင်းမည်' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($deleteConfirm)
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
                        <h3 class="text-lg font-medium text-gray-900 myanmar-text">အသုံးစရိတ် ဖျက်ရန် သေချာပါသလား?</h3>
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
    @endif
</div>
