<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Today's Sales -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-primary-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">ယနေ့ ရောင်းအား</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ number_format($todaySales, 0) }} Ks</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Orders -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">ယနေ့ အော်ဒါ</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $todayOrders }}</dd>
                            <dd class="text-xs text-gray-500 myanmar-text">ပြီးသွားသော: {{ $completedOrdersToday }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Items -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">စုစုပေါင်း ပစ္စည်း</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $totalItems }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Status -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">စားပွဲများ</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $occupiedTables }}/{{ $totalTables }}</dd>
                            <dd class="text-xs text-gray-500 myanmar-text">အသုံးပြုနေသော</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Expenses -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">ယနေ့ အသုံးစရိတ်</dt>
                            <dd class="text-lg font-semibold text-red-600">{{ number_format($todayExpenses, 0) }} Ks</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Expenses -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">လစဉ် အသုံးစရိတ်</dt>
                            <dd class="text-lg font-semibold text-orange-600">{{ number_format($monthlyExpenses, 0) }} Ks</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gross Profit -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">စုစုပေါင်း အသားတင်ရငွေ</dt>
                            <dd class="text-lg font-semibold text-purple-600">{{ number_format($todayGrossProfit, 0) }} Ks</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Net Profit/Loss -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 {{ $todayNetProfit >= 0 ? 'bg-green-500' : 'bg-red-500' }} rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($todayNetProfit >= 0)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @endif
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate myanmar-text">
                                {{ $todayNetProfit >= 0 ? 'အမြတ်' : 'အရှုံး' }}
                            </dt>
                            <dd class="text-lg font-semibold {{ $todayNetProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format(abs($todayNetProfit), 0) }} Ks
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Transparency Section -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">ယနေ့ ငွေကြေးအသေးစိတ်</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Subtotal -->
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">စုစုပေါင်း (Subtotal)</p>
                            <p class="text-xl font-bold text-blue-600">{{ number_format($todaySubtotal, 0) }} Ks</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Tax -->
                <div class="bg-indigo-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">အခွန် (Tax)</p>
                            <p class="text-xl font-bold text-indigo-600">{{ number_format($todayTax, 0) }} Ks</p>
                        </div>
                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Service Charge -->
                <div class="bg-teal-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">ဝန်ဆောင်ခ (Service)</p>
                            <p class="text-xl font-bold text-teal-600">{{ number_format($todayServiceCharge, 0) }} Ks</p>
                        </div>
                        <svg class="w-8 h-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Discount -->
                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">လျှော့ဈေး (Discount)</p>
                            <p class="text-xl font-bold text-yellow-600">{{ number_format($todayDiscount, 0) }} Ks</p>
                        </div>
                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                </div>

                <!-- FOC -->
                <div class="bg-pink-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">အခမဲ့ (FOC)</p>
                            <p class="text-xl font-bold text-pink-600">{{ number_format($todayFOC, 0) }} Ks</p>
                        </div>
                        <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Total Sales -->
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">စုစုပေါင်း ရငွေ (Total)</p>
                            <p class="text-xl font-bold text-green-600">{{ number_format($todaySales, 0) }} Ks</p>
                        </div>
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Expenses -->
                <div class="bg-red-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">အသုံးစရိတ် (Expenses)</p>
                            <p class="text-xl font-bold text-red-600">{{ number_format($todayExpenses, 0) }} Ks</p>
                        </div>
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Net Profit -->
                <div class="bg-{{ $todayNetProfit >= 0 ? 'emerald' : 'rose' }}-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 myanmar-text">{{ $todayNetProfit >= 0 ? 'အမြတ်' : 'အရှုံး' }} (Net)</p>
                            <p class="text-xl font-bold text-{{ $todayNetProfit >= 0 ? 'emerald' : 'rose' }}-600">{{ number_format(abs($todayNetProfit), 0) }} Ks</p>
                        </div>
                        <svg class="w-8 h-8 text-{{ $todayNetProfit >= 0 ? 'emerald' : 'rose' }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($todayNetProfit >= 0)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @endif
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Calculation Formula -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2 myanmar-text">တွက်ချက်ပုံ:</h4>
                <div class="text-sm text-gray-600 space-y-1 myanmar-text">
                    <p>• စုစုပေါင်း ရငွေ = စုစုပေါင်း + အခွန် + ဝန်ဆောင်ခ - လျှော့ဈေး</p>
                    <p>• အသားတင်ရငွေ = စုစုပေါင်း ရငွေ - လျှော့ဈေး</p>
                    <p>• အမြတ်/အရှုံး = အသားတင်ရငွေ - အသုံးစရိတ်</p>
                    <p class="text-xs text-gray-500 mt-2">* FOC ပစ္စည်းများသည် စာရင်းတွင် ပါဝင်သော်လည်း ငွေတောင်းခံခြင်း မရှိပါ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Orders Alert -->
    @if($pendingOrders > 0)
    <div class="bg-orange-50 border-l-4 border-orange-400 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-orange-700">
                    <span class="myanmar-text font-medium">သတိပေးချက်:</span> 
                    <span class="myanmar-text">စောင့်ဆိုင်းနေသော အော်ဒါ {{ $pendingOrders }} ခု ရှိပါသည်။</span>
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Top Selling Items -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 myanmar-text">အရောင်းရဆုံး ပစ္စည်းများ</h3>
                    <span class="text-xs text-gray-500 myanmar-text">(ယနေ့)</span>
                </div>
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
                <p class="text-sm text-gray-500 text-center py-4 myanmar-text">ယနေ့ ရောင်းချမှု မရှိသေးပါ</p>
                @endif
            </div>
        </div>

        <!-- Sales by Category -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 myanmar-text">အမျိုးအစားအလိုက် ရောင်းအား</h3>
                    <span class="text-xs text-gray-500 myanmar-text">(ယနေ့)</span>
                </div>
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
                <p class="text-sm text-gray-500 text-center py-4 myanmar-text">ယနေ့ ရောင်းချမှု မရှိသေးပါ</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 myanmar-text">လတ်တလော အော်ဒါများ</h3>
                <button wire:click="refresh" class="text-sm text-primary-600 hover:text-primary-800 myanmar-text">
                    <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    ပြန်လည်ဖော်ပြရန်
                </button>
            </div>
            @if($recentOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အော်ဒါနံပါတ်</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">စားပွဲ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အမျိုးအစား</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">စုစုပေါင်း</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အခြေအနေ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အချိန်</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentOrders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $order->order_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($order->table)
                                    <span class="myanmar-text">{{ $order->table->name }}</span>
                                @else
                                    <span class="myanmar-text">ပါဆယ်ယူမည်</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="myanmar-text">{{ $order->order_type === 'dine_in' ? 'ဆိုင်တွင်းစားမည်' : 'ပါဆယ်ယူမည်' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($order->total, 0) }} Ks
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->status === 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 myanmar-text">
                                    စောင့်ဆိုင်းဆဲ
                                </span>
                                @elseif($order->status === 'completed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 myanmar-text">
                                    ပြီးစီး
                                </span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 myanmar-text">
                                    ပယ်ဖျက်ပြီး
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('h:i A') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-sm text-gray-500 text-center py-4 myanmar-text">အော်ဒါ မရှိသေးပါ</p>
            @endif
        </div>
    </div>

    <!-- Recent Expenses -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 myanmar-text">မကြာသေးမီ အသုံးစရိတ်များ</h3>
                <a href="{{ route('admin.expenses.index') }}" class="text-sm text-primary-600 hover:text-primary-800 myanmar-text">အားလုံးကြည့်ရန် →</a>
            </div>
            @if($recentExpenses->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">
                                ရက်စွဲ
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">
                                အမျိုးအစား
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">
                                ဖော်ပြချက်
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">
                                ပမာဏ
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">
                                မှတ်တမ်းတင်သူ
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentExpenses as $expense)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $expense->expense_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 myanmar-text">
                                {{ $expense->category }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $expense->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">
                                {{ number_format($expense->amount, 0) }} Ks
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $expense->user->name ?? 'N/A' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-sm text-gray-500 text-center py-4 myanmar-text">အသုံးစရိတ် မရှိသေးပါ</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 myanmar-text">အမြန်လုပ်ဆောင်ချက်များ</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.items.index') }}" class="btn btn-outline text-center">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="myanmar-text">ပစ္စည်းများ</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline text-center">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span class="myanmar-text">အမျိုးအစားများ</span>
                </a>
                <a href="{{ route('admin.tables.index') }}" class="btn btn-outline text-center">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span class="myanmar-text">စားပွဲများ</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline text-center">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="myanmar-text">Users</span>
                </a>
            </div>
        </div>
        </div>
    </div>
</div>
