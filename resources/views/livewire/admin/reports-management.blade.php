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
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 myanmar-text">အစီရင်ခံစာများ</h2>
        <p class="mt-1 text-sm text-gray-600 myanmar-text">ရောင်းအားနှင့် လုပ်ငန်း အစီရင်ခံစာများကို ကြည့်ရှုပါ။</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 md:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Report Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အစီရင်ခံစာ အမျိုးအစား</label>
                <select wire:model.live="reportType" class="input">
                    <option value="daily">ယနေ့ / Daily</option>
                    <option value="weekly">ဤအပတ် / Weekly</option>
                    <option value="monthly">ဤလ / Monthly</option>
                    <option value="yearly">ဤနှစ် / Yearly</option>
                    <option value="custom">စိတ်ကြိုက် / Custom</option>
                </select>
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">စတင်သည့်ရက်</label>
                <input type="date" wire:model="startDate" class="input">
                @error('startDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- End Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ပြီးဆုံးသည့်ရက်</label>
                <input type="date" wire:model="endDate" class="input">
                @error('endDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Export Button -->
            <div class="flex items-end">
                <button wire:click="exportReport" class="btn bg-green-600 hover:bg-green-700 text-white w-full">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="myanmar-text">Excel ထုတ်မည်</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
        <!-- Total Sales -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">စုစုပေါင်း ရောင်းအား</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ number_format($totalSales, 0) }} Ks</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">စုစုပေါင်း အော်ဒါ</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $totalOrders }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Average Order Value -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">ပျမ်းမျှ တန်ဖိုး</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ number_format($averageOrderValue, 0) }} Ks</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Total Tax -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">စုစုပေါင်း အခွန်</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ number_format($totalTax, 0) }} Ks</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Total Discount -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">လျှော့ဈေး</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ number_format($totalDiscount, 0) }} Ks</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">အသုံးစရိတ်</dt>
                        <dd class="text-lg font-semibold text-red-600">{{ number_format($totalExpenses, 0) }} Ks</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Gross Profit -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">အသားတင်ရငွေ</dt>
                        <dd class="text-lg font-semibold text-indigo-600">{{ number_format($grossProfit, 0) }} Ks</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 {{ $netProfit >= 0 ? 'bg-green-600' : 'bg-red-600' }} rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($netProfit >= 0)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @endif
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">{{ $netProfit >= 0 ? 'အမြတ်' : 'အရှုံး' }}</dt>
                        <dd class="text-lg font-semibold {{ $netProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ number_format(abs($netProfit), 0) }} Ks</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6">
        <!-- Top Selling Items -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">အရောင်းရဆုံး ပစ္စည်းများ</h3>
            @if($topSellingItems->count() > 0)
            <div class="space-y-3">
                @foreach($topSellingItems as $item)
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 myanmar-text">{{ $item->name_mm }}</p>
                        <p class="text-xs text-gray-500">{{ $item->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ $item->total_quantity }} <span class="myanmar-text">ခု</span></p>
                        <p class="text-xs text-gray-500">{{ number_format($item->total_sales, 0) }} Ks</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-500 text-center py-4 myanmar-text">ဒေတာ မရှိသေးပါ</p>
            @endif
        </div>

        <!-- Sales by Category -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">အမျိုးအစားအလိုက် ရောင်းအား</h3>
            @if($salesByCategory->count() > 0)
            <div class="space-y-3">
                @foreach($salesByCategory as $category)
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 myanmar-text">{{ $category->name_mm }}</p>
                        <p class="text-xs text-gray-500">{{ $category->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ number_format($category->total_sales, 0) }} Ks</p>
                        <p class="text-xs text-gray-500 myanmar-text">{{ $category->order_count }} အော်ဒါ</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-500 text-center py-4 myanmar-text">ဒေတာ မရှိသေးပါ</p>
            @endif
        </div>

        <!-- Expenses by Category -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">အမျိုးအစားအလိုက် အသုံးစရိတ်</h3>
            @if($expensesByCategory->count() > 0)
            <div class="space-y-3">
                @foreach($expensesByCategory as $expense)
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 myanmar-text">{{ $expense->category }}</p>
                        <p class="text-xs text-gray-500 myanmar-text">{{ $expense->count }} ကြိမ်</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-red-600">{{ number_format($expense->total_amount, 0) }} Ks</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-500 text-center py-4 myanmar-text">ဒေတာ မရှိသေးပါ</p>
            @endif
        </div>
    </div>

    <!-- Sales by Order Type -->
    <div class="bg-white rounded-lg shadow-sm p-4 md:p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">အော်ဒါ အမျိုးအစားအလိုက် ရောင်းအား</h3>
        @if($salesByOrderType->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($salesByOrderType as $type)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 myanmar-text">
                            {{ $type->order_type === 'dine_in' ? 'ဆိုင်တွင်းစားမည်' : 'ပါဆယ်ယူမည်' }}
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($type->total_sales, 0) }} Ks</p>
                        <p class="text-xs text-gray-500 mt-1 myanmar-text">{{ $type->count }} အော်ဒါ</p>
                    </div>
                    <div>
                        @if($type->order_type === 'dine_in')
                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @else
                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-500 text-center py-4 myanmar-text">ဒေတာ မရှိသေးပါ</p>
        @endif
    </div>

    <!-- Hourly Breakdown (for daily reports) -->
    @if($reportType === 'daily' && $hourlyBreakdown->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">နာရီအလိုက် ရောင်းအား</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အချိန်</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အော်ဒါ အရေအတွက်</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">ရောင်းအား</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($hourlyBreakdown as $hour)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ str_pad($hour->hour, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($hour->hour + 1, 2, '0', STR_PAD_LEFT) }}:00
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $hour->order_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($hour->total_sales, 0) }} Ks
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
