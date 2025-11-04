<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 myanmar-text">နေ့စဉ် အကျဉ်းချုပ်အစီရင်ခံစာ</h2>
        
        <!-- Date Range -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="summaryStartDate" class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">စတင်ရက်</label>
                    <input type="date" id="summaryStartDate" name="summaryStartDate" wire:model="startDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label for="summaryEndDate" class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ပြီးဆုံးရက်</label>
                    <input type="date" id="summaryEndDate" name="summaryEndDate" wire:model="endDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div class="flex items-end">
                    <button type="button" wire:click="generateReport" class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                        <span class="myanmar-text">အစီရင်ခံစာ ထုတ်မည်</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Orders -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 myanmar-text">စုစုပေါင်း အော်ဒါ</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($summary['total_orders'] ?? 0) }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Gross Sales -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 myanmar-text">စုစုပေါင်း ရောင်းအား</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($summary['gross_sales'] ?? 0) }} Ks</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Discounts -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 myanmar-text">လျှော့ဈေးများ</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($summary['discounts'] ?? 0) }} Ks</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Net Sales -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 myanmar-text">သားသန့် ရောင်းအား</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($summary['net_sales'] ?? 0) }} Ks</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order Types -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 myanmar-text">အော်ဒါအမျိုးအစားများ</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 myanmar-text">ဆိုင်တွင်း စားသုံးမှု</span>
                        <span class="text-sm font-medium text-gray-900">{{ number_format($summary['dine_in_orders'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 myanmar-text">ယူသွားမှု</span>
                        <span class="text-sm font-medium text-gray-900">{{ number_format($summary['takeaway_orders'] ?? 0) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 myanmar-text">ငွေပေးချေမှုနည်းလမ်းများ</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 myanmar-text">ငွေသား</span>
                        <span class="text-sm font-medium text-gray-900">{{ number_format($summary['cash_payments'] ?? 0) }} Ks</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 myanmar-text">ကတ်</span>
                        <span class="text-sm font-medium text-gray-900">{{ number_format($summary['card_payments'] ?? 0) }} Ks</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 myanmar-text">မိုဘိုင်း</span>
                        <span class="text-sm font-medium text-gray-900">{{ number_format($summary['mobile_payments'] ?? 0) }} Ks</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Order Value -->
        <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-gray-900 myanmar-text">ပျမ်းမျှ အော်ဒါတန်ဖိုး</span>
                <span class="text-2xl font-bold text-primary-600">{{ number_format($summary['avg_order_value'] ?? 0) }} Ks</span>
            </div>
        </div>
    </div>
</div>
