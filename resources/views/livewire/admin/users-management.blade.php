<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if (session()->has('message'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
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
        <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
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
                <h2 class="text-2xl font-bold text-gray-900">Users Management</h2>
                <p class="mt-1 text-sm text-gray-600 myanmar-text">အသုံးပြုသူများကို ထည့်သွင်း၊ ပြင်ဆင်၊ ဖျက်ပစ်နိုင်ပါသည်။</p>
            </div>
            <div class="flex gap-3">
                <button wire:click="exportExcel" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="myanmar-text">Excel ထုတ်မည်</span>
                </button>
                <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="myanmar-text">အသုံးပြုသူအသစ် ထည့်ရန်</span>
                </button>
            </div>
        </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 md:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ရှာဖွေရန်</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="အမည်၊ အီးမေးလ် သို့မဟုတ် ဖုန်း..." class="input">
            </div>

            <!-- Role Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အခန်းကဏ္ဍ</label>
                <select wire:model.live="roleFilter" class="input">
                    <option value="">အားလုံး</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}">
                        @if($role->name === 'admin') စီမံခန့်ခွဲသူ
                        @elseif($role->name === 'cashier') ငွေကိုင်
                        @elseif($role->name === 'waiter') စားပွဲထိုး
                        @elseif($role->name === 'kitchen') မီးဖိုချောင်
                        @elseif($role->name === 'bar') ဘား
                        @else {{ $role->name }}
                        @endif
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အခြေအနေ</label>
                <select wire:model.live="statusFilter" class="input">
                    <option value="">အားလုံး</option>
                    <option value="active">အသုံးပြုနေသော</option>
                    <option value="inactive">ပိတ်ထားသော</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အမည်</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အီးမေးလ်</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">ဖုန်း</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အခန်းကဏ္ဍ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">အခြေအနေ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider myanmar-text">လုပ်ဆောင်ချက်</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="{{ $user->id === auth()->id() ? 'bg-blue-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                        <span class="ml-2 text-xs text-blue-600 myanmar-text">(သင်)</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->phone ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach($user->roles as $role)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($role->name === 'admin') bg-purple-100 text-purple-800
                                @elseif($role->name === 'cashier') bg-green-100 text-green-800
                                @elseif($role->name === 'waiter') bg-blue-100 text-blue-800
                                @elseif($role->name === 'kitchen') bg-orange-100 text-orange-800
                                @elseif($role->name === 'bar') bg-pink-100 text-pink-800
                                @else bg-gray-100 text-gray-800
                                @endif
                                myanmar-text">
                                @if($role->name === 'admin') စီမံခန့်ခွဲသူ
                                @elseif($role->name === 'cashier') ငွေကိုင်
                                @elseif($role->name === 'waiter') စားပွဲထိုး
                                @elseif($role->name === 'kitchen') မီးဖိုချောင်
                                @elseif($role->name === 'bar') ဘား
                                @else {{ $role->name }}
                                @endif
                            </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 myanmar-text">
                                အသုံးပြုနေသော
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 myanmar-text">
                                ပိတ်ထားသော
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button wire:click="toggleActive({{ $user->id }})" class="text-blue-600 hover:text-blue-900" title="အခြေအနေ ပြောင်းရန်">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                                <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900" title="ပြင်ဆင်ရန်">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                @if($user->id !== auth()->id())
                                <button wire:click="confirmDelete({{ $user->id }})" class="text-red-600 hover:text-red-900" title="ဖျက်ရန်">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 myanmar-text">
                            အသုံးပြုသူ မတွေ့ပါ
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-xl font-bold text-gray-900 myanmar-text">
                    {{ $editMode ? 'အသုံးပြုသူ ပြင်ဆင်ရန်' : 'အသုံးပြုသူအသစ် ထည့်ရန်' }}
                </h3>
            </div>

            <form wire:submit.prevent="save" class="flex-1 overflow-y-auto">
                <div class="px-6 py-6 space-y-5">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အမည် *</label>
                        <input type="text" wire:model="name" class="input" placeholder="Mg Mg">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အီးမေးလ် *</label>
                        <input type="email" wire:model="email" class="input" placeholder="user@example.com">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">ဖုန်းနံပါတ်</label>
                        <input type="text" wire:model="phone" class="input" placeholder="09xxxxxxxxx">
                        @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">အခန်းကဏ္ဍ *</label>
                        <select wire:model="selectedRole" class="input">
                            <option value="">ရွေးချယ်ပါ</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">
                                @if($role->name === 'admin') စီမံခန့်ခွဲသူ / Admin
                                @elseif($role->name === 'cashier') ငွေကိုင် / Cashier
                                @elseif($role->name === 'waiter') စားပွဲထိုး / Waiter
                                @elseif($role->name === 'kitchen') မီးဖိုချောင် / Kitchen
                                @elseif($role->name === 'bar') ဘား / Bar
                                @else {{ $role->name }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @error('selectedRole') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">
                            စကားဝှက် {{ $editMode ? '(ပြောင်းလိုပါက သာ ဖြည့်ပါ)' : '*' }}
                        </label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" wire:model="password" class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700 mb-1 myanmar-text">
                            စကားဝှက် အတည်ပြုရန် {{ $editMode ? '' : '*' }}
                        </label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" wire:model="password_confirmation" class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Active Checkbox -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700 myanmar-text">အသုံးပြုနေသော</span>
                        </label>
                    </div>
                </div>
            </form>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" wire:click="closeModal" class="px-6 py-2.5 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100 transition-colors myanmar-text">
                    မလုပ်တော့ပါ
                </button>
                <button type="button" wire:click="save" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors myanmar-text">
                    {{ $editMode ? 'ပြင်ဆင်မည်' : 'ထည့်သွင်းမည်' }}
                </button>
            </div>
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
                        <h3 class="text-lg font-medium text-gray-900 myanmar-text">အသုံးပြုသူ ဖျက်ရန် သေချာပါသလား?</h3>
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
</div>
