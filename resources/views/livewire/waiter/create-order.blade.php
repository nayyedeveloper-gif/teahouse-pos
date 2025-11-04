<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 myanmar-text">
                        @if($table)
                            {{ $table->name_mm ?? $table->name }}
                        @else
                            ပါဆယ်ယူမည်
                        @endif
                    </h2>
                    <p class="text-sm text-gray-600 myanmar-text">
                        @if($isEditMode)
                            အော်ဒါ #{{ $existingOrder->order_number }} ကို ပြင်ဆင်နေသည်
                        @else
                            အော်ဒါအသစ်ယူရန်
                        @endif
                    </p>
                </div>
                <a href="{{ route('waiter.tables.index') }}" class="btn btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="myanmar-text">နောက်သို့</span>
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side: Menu Items -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Search -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <input 
                        type="text" 
                        wire:model.live="searchTerm" 
                        placeholder="ရှာဖွေရန်..."
                        class="form-input"
                    >
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex overflow-x-auto space-x-2 pb-2">
                        @foreach($categories as $category)
                            <button 
                                wire:click="selectCategory({{ $category->id }})"
                                class="flex-shrink-0 px-4 py-2 rounded-lg font-medium transition-colors {{ $selectedCategory == $category->id ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                            >
                                <span class="myanmar-text">{{ $category->name_mm }}</span>
                                <span class="text-xs ml-1">({{ $category->active_items_count }})</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Items Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @forelse($items as $item)
                        <button 
                            wire:click="addToCart({{ $item->id }})"
                            class="pos-item-card hover:scale-105 transition-transform"
                        >
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto mb-2 bg-primary-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 text-sm mb-1">{{ $item->name }}</h3>
                                <p class="text-xs text-gray-600 myanmar-text mb-2">{{ $item->name_mm }}</p>
                                <p class="text-primary-600 font-bold">{{ number_format($item->price, 0) }} Ks</p>
                            </div>
                        </button>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 myanmar-text">ပစ္စည်းများ မရှိပါ</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Side: Cart -->
            <div class="lg:col-span-1 space-y-4">
                <!-- Customer Lookup -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <button 
                        wire:click="$toggle('showCustomerLookup')"
                        class="w-full flex items-center justify-between text-left"
                    >
                        <span class="font-semibold text-gray-900 myanmar-text">ဖောက်သည် ရှာဖွေရန်</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    @if($showCustomerLookup)
                    <div class="mt-4 space-y-3">
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                wire:model="customer_phone"
                                placeholder="09xxxxxxxxx"
                                class="flex-1 px-3 py-2 border rounded-lg text-sm"
                            >
                            <button 
                                wire:click="searchCustomer"
                                class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm hover:bg-primary-700"
                            >
                                <span class="myanmar-text">ရှာမည်</span>
                            </button>
                        </div>

                        @if($customer)
                        <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $customer->name }}</p>
                                    @if($customer->name_mm)
                                    <p class="text-sm text-gray-600 myanmar-text">{{ $customer->name_mm }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500">{{ $customer->customer_code }}</p>
                                </div>
                                <button 
                                    wire:click="clearCustomer"
                                    class="text-red-600 hover:text-red-800"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="text-sm space-y-1">
                                <p class="myanmar-text">
                                    <span class="text-gray-600">ရရှိနိုင်သော Points:</span>
                                    <span class="font-bold text-green-600">{{ number_format($customer->loyalty_points) }}</span>
                                </p>
                                <p class="myanmar-text">
                                    <span class="text-gray-600">စုစုပေါင်းသုံးစွဲမှု:</span>
                                    <span class="font-semibold">{{ number_format($customer->total_spent) }} Ks</span>
                                </p>
                            </div>

                            @if($customer->loyalty_points >= 100)
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">
                                    Points လျှော့ဈေးယူမည်
                                </label>
                                <input 
                                    type="number" 
                                    wire:model.live="loyalty_points_to_redeem"
                                    min="0"
                                    max="{{ $customer->loyalty_points }}"
                                    step="100"
                                    class="w-full px-3 py-2 border rounded-lg text-sm"
                                    placeholder="100, 200, 300..."
                                >
                                @if($loyalty_points_to_redeem > 0)
                                <p class="text-xs text-green-600 mt-1 myanmar-text">
                                    လျှော့ဈေး: {{ number_format(($loyalty_points_to_redeem / 100) * 1000) }} Ks
                                </p>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endif

                        @if(session()->has('customer_error'))
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600 myanmar-text">{{ session('customer_error') }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Cart -->
                <div class="bg-white rounded-lg shadow-sm sticky top-24">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 myanmar-text">အော်ဒါစာရင်း</h3>
                        <p class="text-sm text-gray-600">{{ count($cart) }} items</p>
                    </div>

                    <div class="p-4 max-h-96 overflow-y-auto">
                        @forelse($cart as $key => $item)
                            <div class="mb-4 pb-4 border-b border-gray-200 last:border-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-sm">{{ $item['name'] }}</h4>
                                        <p class="text-xs text-gray-600 myanmar-text">{{ $item['name_mm'] }}</p>
                                    </div>
                                    <button 
                                        wire:click="removeFromCart('{{ $key }}')"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center space-x-2 mb-2">
                                    <button 
                                        wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})"
                                        class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span class="w-12 text-center font-semibold">{{ $item['quantity'] }}</span>
                                    <button 
                                        wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})"
                                        class="w-8 h-8 rounded-full bg-primary-600 hover:bg-primary-700 text-white flex items-center justify-center"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Price -->
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">{{ number_format($item['price'], 0) }} Ks × {{ $item['quantity'] }}</span>
                                    <span class="font-bold text-gray-900">{{ number_format($item['subtotal'], 0) }} Ks</span>
                                </div>

                                <!-- FOC Quantity -->
                                <div class="mb-2">
                                    <div class="flex items-center space-x-2">
                                        <label class="text-sm text-gray-700 myanmar-text">FOC:</label>
                                        <input 
                                            type="number" 
                                            wire:change="updateFocQuantity('{{ $key }}', $event.target.value)"
                                            value="{{ $item['foc_quantity'] ?? 0 }}"
                                            min="0"
                                            max="{{ $item['quantity'] }}"
                                            class="w-20 text-sm border-gray-300 rounded-lg text-center"
                                        >
                                        <span class="text-xs text-gray-500">/ {{ $item['quantity'] }}</span>
                                    </div>
                                    @if(($item['foc_quantity'] ?? 0) > 0)
                                    <p class="text-xs text-green-600 mt-1 myanmar-text">
                                        {{ $item['foc_quantity'] }} ခွက် အခမဲ့
                                    </p>
                                    @endif
                                </div>

                                <!-- Notes -->
                                <input 
                                    type="text" 
                                    wire:change="updateItemNotes('{{ $key }}', $event.target.value)"
                                    value="{{ $item['notes'] }}"
                                    placeholder="မှတ်ချက်..."
                                    class="w-full text-sm border-gray-300 rounded-lg"
                                >
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-gray-500 text-sm myanmar-text">အော်ဒါစာရင်း အလွတ်</p>
                            </div>
                        @endforelse
                    </div>

                    @if(count($cart) > 0)
                        <div class="p-4 border-t border-gray-200">
                            <!-- Order Notes -->
                            <div class="mb-4">
                                <label class="form-label myanmar-text">မှတ်ချက်</label>
                                <textarea 
                                    wire:model="notes"
                                    rows="2"
                                    placeholder="အော်ဒါအတွက် မှတ်ချက်..."
                                    class="form-textarea"
                                ></textarea>
                            </div>

                            <!-- Total -->
                            <div class="mb-4 p-3 bg-gray-50 rounded-lg space-y-2">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600 myanmar-text">စုစုပေါင်း</span>
                                    <span class="font-semibold">{{ number_format($this->subtotal, 0) }} Ks</span>
                                </div>
                                
                                @if($customer && $loyalty_points_to_redeem > 0)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-green-600 myanmar-text">Loyalty လျှော့ဈေး</span>
                                    <span class="font-semibold text-green-600">-{{ number_format(($loyalty_points_to_redeem / 100) * 1000, 0) }} Ks</span>
                                </div>
                                @endif
                                
                                <div class="pt-2 border-t border-gray-300">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-900 myanmar-text">ပေးရန်</span>
                                        <span class="text-2xl font-bold text-primary-600">{{ number_format($this->total, 0) }} Ks</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button 
                                wire:click="submitOrder"
                                class="w-full btn btn-primary py-3 text-lg font-semibold"
                            >
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="myanmar-text">
                                @if($isEditMode)
                                    အော်ဒါပြင်ဆင်မည်
                                @else
                                    အော်ဒါတင်မည်
                                @endif
                                </span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif
</div>
