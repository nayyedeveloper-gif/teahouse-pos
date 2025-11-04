<div wire:poll.5s>
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

    <!-- Error Message -->
    @if (session()->has('error'))
    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 myanmar-text">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 myanmar-text">စားပွဲများ စီမံခန့်ခွဲမှု</h2>
            <p class="mt-1 text-sm text-gray-600 myanmar-text">စားပွဲများကို ထည့်သွင်း၊ ပြင်ဆင်၊ ဖျက်ပစ်နိုင်ပါသည်။</p>
        </div>
        <button wire:click="create" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span class="myanmar-text">စားပွဲအသစ် ထည့်ရန်</span>
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 md:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရှာဖွေရန်</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="စားပွဲအမည် ရှာရန်..." class="input">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အခြေအနေ</label>
                <select wire:model.live="statusFilter" class="input">
                    <option value="">အားလုံး</option>
                    <option value="available">ရရှိနိုင်သော / Available</option>
                    <option value="occupied">အသုံးပြုနေသော / Occupied</option>
                    <option value="reserved">ကြိုတင်မှာထားသော / Reserved</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tables Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        @forelse($tables as $table)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border-2 
            @if($table->status === 'available') border-green-200
            @elseif($table->status === 'occupied') border-red-200
            @else border-yellow-200
            @endif
            hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 myanmar-text">{{ $table->name_mm }}</h3>
                        <p class="text-sm text-gray-500">{{ $table->name }}</p>
                    </div>
                    <div>
                        @if($table->status === 'available')
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 myanmar-text">
                            ရရှိနိုင်သော
                        </span>
                        @elseif($table->status === 'occupied')
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 myanmar-text">
                            အသုံးပြုနေသော
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 myanmar-text">
                            ကြိုတင်မှာထားသော
                        </span>
                        @endif
                    </div>
                </div>

                <div class="space-y-3 mb-4">
                    <div class="flex items-center text-sm">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-gray-600 myanmar-text">ဧည့်သည်:</span>
                        <span class="ml-2 font-medium">{{ $table->capacity }} <span class="myanmar-text">ဦး</span></span>
                    </div>

                    <div class="flex items-center text-sm">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="text-gray-600 myanmar-text">စုစုပေါင်း အော်ဒါ:</span>
                        <span class="ml-2 font-medium">{{ $table->orders_count }}</span>
                    </div>

                    @if(!$table->is_active)
                    <div class="flex items-center text-sm text-red-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                        <span class="myanmar-text">ပိတ်ထားသော</span>
                    </div>
                    @endif

                    @if($table->activeOrder)
                    <div class="flex items-center text-sm text-blue-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span class="myanmar-text">လက်ရှိ အော်ဒါ:</span>
                        <span class="ml-2 font-medium">{{ $table->activeOrder->order_number }}</span>
                    </div>
                    @endif
                </div>

                <!-- Active Order Details -->
                @if($table->activeOrder)
                <div class="mb-4 pb-4 border-b border-gray-200 bg-blue-50 -mx-6 px-6 py-3">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-xs font-semibold text-blue-800 myanmar-text">လက်ရှိ အော်ဒါ</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            <span class="myanmar-text">စောင့်ဆိုင်းဆဲ</span>
                        </span>
                    </div>
                    <div class="text-xs text-blue-700 space-y-1">
                        <div class="myanmar-text">ပစ္စည်း: {{ $table->activeOrder->orderItems->count() }} မျိုး</div>
                        <div class="font-semibold">စုစုပေါင်း: {{ number_format($table->activeOrder->total, 0) }} Ks</div>
                    </div>
                    <button wire:click="viewTableOrders({{ $table->id }})" class="mt-2 w-full text-xs bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded myanmar-text">
                        အော်ဒါ ကြည့်ရန်
                    </button>
                </div>
                @endif

                <!-- Quick Status Change -->
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <p class="text-xs text-gray-500 mb-2 myanmar-text">အမြန် အခြေအနေပြောင်းရန်:</p>
                    <div class="flex space-x-2">
                        <button wire:click="changeStatus({{ $table->id }}, 'available')" 
                                class="flex-1 px-2 py-1 text-xs rounded {{ $table->status === 'available' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            <span class="myanmar-text">ရရှိနိုင်သော</span>
                        </button>
                        <button wire:click="changeStatus({{ $table->id }}, 'reserved')" 
                                class="flex-1 px-2 py-1 text-xs rounded {{ $table->status === 'reserved' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            <span class="myanmar-text">မှာထားသော</span>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <button wire:click="toggleActive({{ $table->id }})" class="text-blue-600 hover:text-blue-900" title="အခြေအနေ ပြောင်းရန်">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                    <button wire:click="edit({{ $table->id }})" class="text-indigo-600 hover:text-indigo-900" title="ပြင်ဆင်ရန်">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button wire:click="confirmDelete({{ $table->id }})" class="text-red-600 hover:text-red-900" title="ဖျက်ရန်">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 myanmar-text">စားပွဲ မတွေ့ပါ</h3>
                <p class="mt-1 text-sm text-gray-500 myanmar-text">စားပွဲအသစ် ထည့်သွင်းပါ။</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($tables->hasPages())
    <div class="mt-6">
        {{ $tables->links() }}
    </div>
    @endif

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 myanmar-text">
                    {{ $editMode ? 'စားပွဲ ပြင်ဆင်ရန်' : 'စားပွဲအသစ် ထည့်ရန်' }}
                </h3>
            </div>

            <form wire:submit.prevent="save">
                <div class="px-6 py-4 space-y-4">
                    <!-- Name (English) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name (English) *</label>
                        <input type="text" wire:model="name" class="input" placeholder="Table 1">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Name (Myanmar) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အမည် (မြန်မာ) *</label>
                        <input type="text" wire:model="name_mm" class="input myanmar-text" placeholder="စားပွဲ ၁">
                        @error('name_mm') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ဧည့်သည် အရေအတွက် *</label>
                        <input type="number" wire:model="capacity" class="input" placeholder="4" min="1" max="50">
                        @error('capacity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အခြေအနေ *</label>
                        <select wire:model="status" class="input">
                            <option value="available">ရရှိနိုင်သော / Available</option>
                            <option value="occupied">အသုံးပြုနေသော / Occupied</option>
                            <option value="reserved">ကြိုတင်မှာထားသော / Reserved</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">စီစဉ်မှု အစဉ်</label>
                        <input type="number" wire:model="sort_order" class="input" min="0">
                        @error('sort_order') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                        <h3 class="text-lg font-medium text-gray-900 myanmar-text">စားပွဲ ဖျက်ရန် သေချာပါသလား?</h3>
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
