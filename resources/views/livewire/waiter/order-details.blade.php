<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 myanmar-text">
                    အော်ဒါ #{{ $order->order_number }}
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $order->created_at->format('d M Y, h:i A') }}
                </p>
            </div>
            <a href="{{ route('waiter.orders.index') }}" class="btn btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="myanmar-text">နောက်သို့</span>
            </a>
        </div>

        <!-- Order Info Card -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Table/Type -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 myanmar-text">စားပွဲ</h3>
                        @if($order->table)
                            <p class="text-lg font-semibold text-gray-900">
                                <span class="myanmar-text">{{ $order->table->name_mm ?? $order->table->name }}</span>
                            </p>
                        @else
                            <p class="text-lg font-semibold text-gray-900 myanmar-text">ပါဆယ်ယူမည်</p>
                        @endif
                    </div>

                    <!-- Waiter -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 myanmar-text">ဝန်ထမ်း</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->waiter->name }}</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 myanmar-text">အခြေအနေ</h3>
                        @if($order->status === 'pending')
                            <span class="badge badge-warning text-lg">
                                <span class="myanmar-text">စောင့်ဆိုင်းဆဲ</span>
                            </span>
                        @elseif($order->status === 'preparing')
                            <span class="badge badge-info text-lg">
                                <span class="myanmar-text">ပြင်ဆင်နေသည်</span>
                            </span>
                        @elseif($order->status === 'ready')
                            <span class="badge badge-primary text-lg">
                                <span class="myanmar-text">အဆင်သင့်</span>
                            </span>
                        @elseif($order->status === 'completed')
                            <span class="badge badge-success text-lg">
                                <span class="myanmar-text">ပြီးစီး</span>
                            </span>
                        @else
                            <span class="badge badge-danger text-lg">
                                <span class="myanmar-text">ပယ်ဖျက်</span>
                            </span>
                        @endif
                    </div>
                </div>

                @if($order->notes)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500 mb-2 myanmar-text">မှတ်ချက်</h3>
                        <p class="text-gray-900">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-6">
            <div class="card-header">
                <h2 class="text-lg font-bold text-gray-900 myanmar-text">အမျိုးအမည်များ</h2>
            </div>
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="myanmar-text">ပစ္စည်း</th>
                                <th class="text-center myanmar-text">အရေအတွက်</th>
                                <th class="text-right myanmar-text">ဈေးနှုန်း</th>
                                <th class="text-right myanmar-text">စုစုပေါင်း</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $orderItem)
                                <tr>
                                    <td>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $orderItem->item->name }}</p>
                                            <p class="text-sm text-gray-600 myanmar-text">{{ $orderItem->item->name_mm }}</p>
                                            @if($orderItem->notes)
                                                <p class="text-xs text-gray-500 italic mt-1">{{ $orderItem->notes }}</p>
                                            @endif
                                            @if($orderItem->is_foc)
                                                <span class="badge badge-success mt-1">FOC</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-semibold">{{ $orderItem->quantity }}</span>
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($orderItem->price, 0) }} Ks
                                    </td>
                                    <td class="text-right font-semibold">
                                        @if($orderItem->is_foc)
                                            <span class="text-green-600">FOC</span>
                                        @else
                                            {{ number_format($orderItem->subtotal, 0) }} Ks
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">စုစုပေါင်း</span>
                        <span class="font-semibold">{{ number_format($order->subtotal, 0) }} Ks</span>
                    </div>

                    @if($order->tax_amount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 myanmar-text">အခွန် ({{ $order->tax_percentage }}%)</span>
                            <span class="font-semibold">{{ number_format($order->tax_amount, 0) }} Ks</span>
                        </div>
                    @endif

                    @if($order->discount_amount > 0)
                        <div class="flex justify-between text-sm text-red-600">
                            <span class="myanmar-text">လျှော့်ဇေး ({{ $order->discount_percentage }}%)</span>
                            <span class="font-semibold">-{{ number_format($order->discount_amount, 0) }} Ks</span>
                        </div>
                    @endif

                    @if($order->service_charge > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 myanmar-text">ဝန်ဆောင်ခ</span>
                            <span class="font-semibold">{{ number_format($order->service_charge, 0) }} Ks</span>
                        </div>
                    @endif

                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900 myanmar-text">စုစုပေါင်း</span>
                            <span class="text-2xl font-bold text-primary-600">{{ number_format($order->total, 0) }} Ks</span>
                        </div>
                    </div>
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
</div>
