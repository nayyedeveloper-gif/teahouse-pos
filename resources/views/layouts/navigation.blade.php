<nav class="bg-white border-b border-gray-200" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        @php
                            $logo = App\Models\Setting::get('app_logo');
                            $appName = App\Models\Setting::get('app_name', config('app.name'));
                        @endphp
                        @if($logo)
                            <img src="{{ Storage::url($logo) }}" alt="Logo" class="h-8 w-8 object-contain">
                        @else
                            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        @endif
                        <span class="font-bold text-xl text-gray-900 myanmar-text">{{ $appName }}</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @role('admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            Categories
                        </x-nav-link>
                        <x-nav-link :href="route('admin.items.index')" :active="request()->routeIs('admin.items.*')">
                            Items
                        </x-nav-link>
                        <x-nav-link :href="route('admin.tables.index')" :active="request()->routeIs('admin.tables.*')">
                            Tables
                        </x-nav-link>
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            Orders
                        </x-nav-link>
                        <x-nav-link :href="route('admin.expenses.index')" :active="request()->routeIs('admin.expenses.*')">
                            Expenses
                        </x-nav-link>
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                            Reports
                        </x-nav-link>
                    @endrole
                    
                    @role('cashier')
                        <x-nav-link :href="route('cashier.dashboard')" :active="request()->routeIs('cashier.dashboard')">
                            <span class="myanmar-text">Dashboard</span>
                        </x-nav-link>
                        <x-nav-link :href="route('cashier.pos')" :active="request()->routeIs('cashier.pos')">
                            POS
                        </x-nav-link>
                        <x-nav-link :href="route('cashier.orders.index')" :active="request()->routeIs('cashier.orders.*')">
                            <span class="myanmar-text">အော်ဒါများ</span>
                        </x-nav-link>
                    @endrole
                    
                    @role('waiter')
                        <x-nav-link :href="route('waiter.dashboard')" :active="request()->routeIs('waiter.dashboard')">
                            <span class="myanmar-text">Dashboard</span>
                        </x-nav-link>
                        <x-nav-link :href="route('waiter.tables.index')" :active="request()->routeIs('waiter.tables.*')">
                            <span class="myanmar-text">စားပွဲများ</span>
                        </x-nav-link>
                        <x-nav-link :href="route('waiter.orders.index')" :active="request()->routeIs('waiter.orders.*')">
                            <span class="myanmar-text">ကျွန်ုပ်၏ အော်ဒါများ</span>
                        </x-nav-link>
                    @endrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="text-left">
                                    <div class="font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ auth()->user()->getRoleNames()->first() }}</div>
                                </div>
                            </div>
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="myanmar-text">ကိုယ်ရေးအချက်အလက်</span>
                        </x-dropdown-link>
                        
                        @role('admin')
                            <!-- Settings Section -->
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <x-dropdown-link :href="route('admin.users.index')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Users Management
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.printers.index')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Printers
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.settings.index')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                System Settings
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.qr-menu.index')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                                QR Menu
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.signage-media.index')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Signage Media
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.signage-analytics.index')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Signage Analytics
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.customers.index')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="myanmar-text">ဖောက်သည်များ</span>
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.cards.index')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span class="myanmar-text">Card Management</span>
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.inventory.suppliers')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="myanmar-text">ပစ္စည်းပေးသွင်းသူများ</span>
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.inventory.stock-items')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                                <span class="myanmar-text">ကုန်ပစ္စည်းစာရင်း</span>
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.inventory.purchase-orders')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="myanmar-text">ဝယ်ယူမှုမှတ်တမ်းများ</span>
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.reports.sales-by-item')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span class="myanmar-text">အစီရင်ခံစာများ</span>
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('admin.error-logs.index')">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                Error Logs
                            </x-dropdown-link>
                            
                            <div class="border-t border-gray-100 my-1"></div>
                        @endrole
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @role('admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Dashboard
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                    Categories
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.items.index')" :active="request()->routeIs('admin.items.*')">
                    Items
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.tables.index')" :active="request()->routeIs('admin.tables.*')">
                    Tables
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                    Orders
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.expenses.index')" :active="request()->routeIs('admin.expenses.*')">
                    Expenses
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                    Reports
                </x-responsive-nav-link>
            @endrole
            
            @role('cashier')
                <x-responsive-nav-link :href="route('cashier.dashboard')" :active="request()->routeIs('cashier.dashboard')">
                    <span class="myanmar-text">Dashboard</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cashier.pos')" :active="request()->routeIs('cashier.pos')">
                    POS
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cashier.orders.index')" :active="request()->routeIs('cashier.orders.*')">
                    <span class="myanmar-text">အော်ဒါများ</span>
                </x-responsive-nav-link>
            @endrole
            
            @role('waiter')
                <x-responsive-nav-link :href="route('waiter.dashboard')" :active="request()->routeIs('waiter.dashboard')">
                    <span class="myanmar-text">Dashboard</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('waiter.tables.index')" :active="request()->routeIs('waiter.tables.*')">
                    <span class="myanmar-text">စားပွဲများ</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('waiter.orders.index')" :active="request()->routeIs('waiter.orders.*')">
                    <span class="myanmar-text">ကျွန်ုပ်၏ အော်ဒါများ</span>
                </x-responsive-nav-link>
            @endrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    <span class="myanmar-text">ကိုယ်ရေးအချက်အလက်</span>
                </x-responsive-nav-link>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
