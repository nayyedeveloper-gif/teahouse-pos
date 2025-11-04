<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 myanmar-text">အော်ဒါများ</h1>
                <p class="mt-2 text-sm text-gray-600 myanmar-text">
                    သင်ယူထားသော အော်ဒါများ
                </p>
            </div>
            <a href="{{ route('waiter.tables.index') }}" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="myanmar-text">အော်ဒါအသစ်</span>
            </a>
        </div>

        <!-- Filters -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Search -->
            <div>
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="ရှာဖွေရန်..."
                    class="form-input"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <select wire:model.live="statusFilter" class="form-select">
                    <option value="all">အားလုံး</option>
                    <option value="pending">စောင့်ဆိုင်းဆဲ</option>
                    <option value="completed">ငွေရှင်းပြီး</option>
                    <option value="cancelled">ပယ်ဖျက်</option>
                </select>
            </div>
        </div>

        <!-- Orders List -->
        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="card hover:shadow-md transition-shadow cursor-pointer" wire:click="viewOrder({{ $order->id }})">
                    <div class="card-body">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <!-- Order Number & Table -->
                                <div class="flex items-center space-x-4 mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">
                                        #{{ $order->order_number }}
                                    </h3>
                                    @if($order->table)
                                        <span class="text-sm text-gray-600">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="myanmar-text">{{ $order->table->name_mm ?? $order->table->name }}</span>
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-600 myanmar-text">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            ပါဆယ်ယူမည်
                                        </span>
                                    @endif
                                </div>

                                <!-- Items Count & Time -->
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span>
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        {{ $order->items->count() }} items
                                    </span>
                                    <span>
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $order->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <!-- Notes -->
                                @if($order->notes)
                                    <div class="mt-2 text-sm text-gray-600 italic">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        {{ $order->notes }}
                                    </div>
                                @endif
                            </div>

                            <div class="text-right">
                                <!-- Status Badge -->
                                <div class="mb-2">
                                    @if($order->status === 'pending')
                                        <span class="badge badge-warning">
                                            <span class="myanmar-text">စောင့်ဆိုင်းဆဲ</span>
                                        </span>
                                    @elseif($order->status === 'completed')
                                        <span class="badge badge-success">
                                            <span class="myanmar-text">ပြီးစီး</span>
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <span class="myanmar-text">ပယ်ဖျက်</span>
                                        </span>
                                    @endif
                                </div>

                                <!-- Total -->
                                <div class="text-xl font-bold text-primary-600">
                                    {{ number_format($order->total, 0) }} Ks
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2 myanmar-text">အော်ဒါများ မရှိသေးပါ</h3>
                        <p class="text-gray-600 mb-4">No orders found</p>
                        <a href="{{ route('waiter.tables.index') }}" class="btn btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="myanmar-text">အော်ဒါအသစ်ယူမည်</span>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
