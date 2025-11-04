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
        <h2 class="text-2xl font-bold text-gray-900 myanmar-text">အော်ဒါများ စီမံခန့်ခွဲမှု</h2>
        <p class="mt-1 text-sm text-gray-600 myanmar-text">အော်ဒါများကို ကြည့်ရှု၊ စီမံခန့်ခွဲနိုင်ပါသည်။</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 md:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရှာဖွေရန်</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="အော်ဒါနံပါတ်..." class="input">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အခြေအနေ</label>
                <select wire:model.live="statusFilter" class="input">
                    <option value="">အားလုံး</option>
                    <option value="pending">စောင့်ဆိုင်းဆဲ / Pending</option>
                    <option value="completed">ငွေရှင်းပြီး / Completed</option>
                    <option value="cancelled">ပယ်ဖျက် / Cancelled</option>
                </select>
            </div>

            <!-- Table Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">စားပွဲ</label>
                <select wire:model.live="tableFilter" class="input">
                    <option value="">အားလုံး</option>
                    @foreach($tables as $table)
                    <option value="{{ $table->id }}">{{ $table->name_mm }} / {{ $table->name }}</option>
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

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အော်ဒါနံပါတ်</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">စားပွဲ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">ပစ္စည်းများ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">စုစုပေါင်း</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အခြေအနေ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အချိန်</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">လုပ်ဆောင်ချက်</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                            <div class="text-xs text-gray-500 myanmar-text">
                                {{ $order->order_type === 'dine_in' ? 'ဆိုင်တွင်းစားမည်' : 'ပါဆယ်ယူမည်' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($order->table)
                            <div class="text-sm text-gray-900 myanmar-text">{{ $order->table->name_mm }}</div>
                            <div class="text-xs text-gray-500">{{ $order->table->name }}</div>
                            @else
                            <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->orderItems->count() }} <span class="myanmar-text">မျိုး</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ number_format($order->total, 0) }} Ks
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($order->status === 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 myanmar-text">
                                စောင့်ဆိုင်းဆဲ
                            </span>
                            @elseif($order->status === 'completed')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 myanmar-text">
                                ပြီးစီး
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 myanmar-text">
                                ပယ်ဖျက်
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-3">
                                <button wire:click="viewOrder({{ $order->id }})" class="text-indigo-600 hover:text-indigo-900 myanmar-text">
                                    ကြည့်ရန်
                                </button>
                                @if($order->status === 'cancelled')
                                <button wire:click="deleteOrder({{ $order->id }})" 
                                        wire:confirm="ဤအော်ဒါကို ဖျက်ပစ်မှာ သေချာပါသလား?"
                                        class="text-red-600 hover:text-red-900 myanmar-text">
                                    ဖျက်ရန်
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 myanmar-text">
                            အော်ဒါ မတွေ့ပါ
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Order Details Modal -->
    @if($showOrderDetails && $selectedOrder)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 myanmar-text">အော်ဒါ အသေးစိတ်</h3>
                    <p class="text-sm text-gray-500">{{ $selectedOrder->order_number }}</p>
                </div>
                <button wire:click="closeOrderDetails" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-4">
                <!-- Order Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 myanmar-text">စားပွဲ</p>
                        <p class="text-base font-medium myanmar-text">
                            {{ $selectedOrder->table ? $selectedOrder->table->name_mm : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 myanmar-text">အမျိုးအစား</p>
                        <p class="text-base font-medium myanmar-text">
                            {{ $selectedOrder->order_type === 'dine_in' ? 'ဆိုင်တွင်းစားမည်' : 'ပါဆယ်ယူမည်' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 myanmar-text">စားပွဲထိုး</p>
                        <p class="text-base font-medium">
                            {{ $selectedOrder->waiter ? $selectedOrder->waiter->name : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 myanmar-text">အချိန်</p>
                        <p class="text-base font-medium">
                            {{ $selectedOrder->created_at->format('Y-m-d H:i') }}
                        </p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-3 myanmar-text">မှာယူထားသော ပစ္စည်းများ</h4>
                    <div class="space-y-2">
                        @foreach($selectedOrder->orderItems as $item)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 myanmar-text">{{ $item->item->name_mm }}</p>
                                <p class="text-xs text-gray-500">{{ $item->item->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-900">{{ $item->quantity }} x {{ number_format($item->price, 0) }} Ks</p>
                                <p class="text-sm font-medium text-gray-900">{{ number_format($item->subtotal, 0) }} Ks</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Total -->
                <div class="border-t border-gray-200 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">စုစုပေါင်း</span>
                        <span class="font-medium">{{ number_format($selectedOrder->subtotal, 0) }} Ks</span>
                    </div>
                    @if($selectedOrder->tax_amount > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">အခွန် ({{ $selectedOrder->tax_percentage }}%)</span>
                        <span class="font-medium">{{ number_format($selectedOrder->tax_amount, 0) }} Ks</span>
                    </div>
                    @endif
                    @if($selectedOrder->service_charge > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 myanmar-text">ဝန်ဆောင်မှု ကြေး</span>
                        <span class="font-medium">{{ number_format($selectedOrder->service_charge, 0) }} Ks</span>
                    </div>
                    @endif
                    @if($selectedOrder->discount_amount > 0)
                    <div class="flex justify-between text-sm text-red-600">
                        <span class="myanmar-text">လျှော့ဈေး</span>
                        <span class="font-medium">-{{ number_format($selectedOrder->discount_amount, 0) }} Ks</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-lg font-bold border-t border-gray-300 pt-2">
                        <span class="myanmar-text">စုစုပေါင်း ပေးရန်</span>
                        <span>{{ number_format($selectedOrder->total, 0) }} Ks</span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                <div class="flex space-x-2">
                    <button wire:click="printReceipt({{ $selectedOrder->id }})" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span class="myanmar-text">ပရင့်ထုတ်မည်</span>
                    </button>
                    
                    @if($selectedOrder->status === 'pending')
                    <button wire:click="cancelOrder({{ $selectedOrder->id }})" 
                            onclick="return confirm('ဤအော်ဒါကို ပယ်ဖျက်မှာ သေချာပါသလား?')"
                            class="btn bg-yellow-600 hover:bg-yellow-700 text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="myanmar-text">ပယ်ဖျက်မည်</span>
                    </button>
                    @endif
                    
                    @if($selectedOrder->status === 'cancelled')
                    <button wire:click="deleteOrder({{ $selectedOrder->id }})" 
                            wire:confirm="ဤအော်ဒါကို လုံးဝဖျက်ပစ်မှာ သေချာပါသလား? ဤလုပ်ဆောင်ချက်ကို နောက်ပြန်ပြောင်း၍မရပါ။"
                            class="btn bg-red-600 hover:bg-red-700 text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span class="myanmar-text">ဖျက်မည်</span>
                    </button>
                    @endif
                </div>
                
                <button wire:click="closeOrderDetails" class="btn btn-outline">
                    <span class="myanmar-text">ပိတ်မည်</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Hidden Receipt Template for Printing -->
    @if($selectedOrder)
    <div id="receipt-print-{{ $selectedOrder->id }}" class="hidden">
        <div style="width: 280px; font-family: 'Courier New', monospace; font-size: 11px; padding: 5px;">
            <div style="text-align: center; margin-bottom: 10px;">
                @php
                    $logo = \App\Models\Setting::get('app_logo');
                    $showLogo = \App\Models\Setting::get('show_logo_on_receipt', false);
                @endphp
                @if($logo && $showLogo)
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" style="max-width: 100px; max-height: 100px; margin: 0 auto; display: block;">
                </div>
                @endif
                <div style="font-size: 16px; font-weight: bold;">{{ \App\Models\Setting::get('business_name_mm', config('app.name')) }}</div>
                <div style="font-size: 13px;">{{ \App\Models\Setting::get('business_name', 'Thar Cho Cafe') }}</div>
                <div style="font-size: 13px; margin-top: 5px;">{{ \App\Models\Setting::get('business_address', '') }}</div>
                <div style="font-size: 13px;">Tel: {{ \App\Models\Setting::get('business_phone', '') }}</div>
            </div>
            
            <div style="border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 5px 0; margin: 10px 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>Order #:</td>
                        <td style="text-align: right;">{{ $selectedOrder->order_number }}</td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td style="text-align: right;">{{ $selectedOrder->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @if($selectedOrder->table)
                    <tr>
                        <td>Table:</td>
                        <td style="text-align: right;">{{ $selectedOrder->table->name }}</td>
                    </tr>
                    @endif
                    @if($selectedOrder->waiter)
                    <tr>
                        <td>Waiter:</td>
                        <td style="text-align: right;">{{ $selectedOrder->waiter->name }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            
            <div style="margin: 10px 0;">
                @foreach($selectedOrder->orderItems as $item)
                <div style="margin-bottom: 5px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 70%;">{{ $item->item->name }}</td>
                            <td style="text-align: right; width: 30%;">{{ number_format($item->subtotal, 0) }}</td>
                        </tr>
                    </table>
                    <div style="font-size: 10px; color: #666; padding-left: 10px;">
                        {{ $item->quantity }} x {{ number_format($item->price, 0) }}
                    </div>
                </div>
                @endforeach
            </div>
            
            <div style="border-top: 1px dashed #000; padding-top: 5px; margin-top: 10px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>Subtotal:</td>
                        <td style="text-align: right;">{{ number_format($selectedOrder->subtotal, 0) }}</td>
                    </tr>
                    @if($selectedOrder->tax_amount > 0)
                    <tr>
                        <td>Tax ({{ $selectedOrder->tax_percentage }}%):</td>
                        <td style="text-align: right;">{{ number_format($selectedOrder->tax_amount, 0) }}</td>
                    </tr>
                    @endif
                    @if($selectedOrder->service_charge > 0)
                    <tr>
                        <td>Service Charge:</td>
                        <td style="text-align: right;">{{ number_format($selectedOrder->service_charge, 0) }}</td>
                    </tr>
                    @endif
                    @if($selectedOrder->discount_amount > 0)
                    <tr>
                        <td>Discount:</td>
                        <td style="text-align: right;">-{{ number_format($selectedOrder->discount_amount, 0) }}</td>
                    </tr>
                    @endif
                    <tr style="font-size: 14px; font-weight: bold; border-top: 1px solid #000;">
                        <td style="padding-top: 5px;">TOTAL:</td>
                        <td style="text-align: right; padding-top: 5px;">{{ number_format($selectedOrder->total, 0) }} Ks</td>
                    </tr>
                </table>
            </div>
            
            <div style="text-align: center; margin-top: 15px; font-size: 11px;">
                <div>{{ \App\Models\Setting::get('receipt_footer', 'Thank you for your visit!') }}</div>
                <div style="margin-top: 5px;">{{ now()->format('Y-m-d H:i:s') }}</div>
            </div>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('print-receipt', (event) => {
                const orderId = event.orderId;
                const receiptContent = document.getElementById('receipt-print-' + orderId);
                
                if (receiptContent) {
                    const printWindow = window.open('', '_blank', 'width=400,height=600');
                    printWindow.document.write('<html><head><title>Receipt</title>');
                    printWindow.document.write('<style>@page { size: 80mm auto; margin: 0; } body { margin: 0; padding: 0; } @media print { body { margin: 0; padding: 0; } }</style>');
                    printWindow.document.write('</head><body>');
                    printWindow.document.write(receiptContent.innerHTML);
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                    
                    setTimeout(() => {
                        printWindow.print();
                        printWindow.close();
                    }, 250);
                }
            });
        });
    </script>
</div>
