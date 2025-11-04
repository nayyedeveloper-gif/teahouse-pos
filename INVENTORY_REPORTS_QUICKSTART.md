# 🚀 Inventory & Reports Quick Start Guide

## ⚡ RAPID IMPLEMENTATION PLAN

Since we have limited time, here's the fastest way to get Inventory and Reports working:

---

## 📦 INVENTORY MANAGEMENT - MINIMAL VIABLE PRODUCT

### Phase 1: Essential Models (30 mins)

```bash
# Models already created:
# - Supplier
# - StockItem  
# - PurchaseOrder

# Create basic Livewire components:
php artisan make:livewire Admin/Inventory/SupplierManagement
php artisan make:livewire Admin/Inventory/StockItemManagement
php artisan make:livewire Admin/Inventory/PurchaseOrderManagement
```

### Phase 2: Supplier Management (Simplest First)

**Model: `app/Models/Supplier.php`**
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name', 'name_mm', 'contact_person', 
        'phone', 'email', 'address', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
```

**Component: `app/Livewire/Admin/Inventory/SupplierManagement.php`**
```php
<?php
namespace App\Livewire\Admin\Inventory;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    
    public $supplierId, $name, $name_mm, $contact_person;
    public $phone, $email, $address, $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'name_mm' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:50',
        'email' => 'nullable|email',
        'contact_person' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->supplierId = null;
        $this->name = '';
        $this->name_mm = '';
        $this->contact_person = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->is_active = true;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            Supplier::findOrFail($this->supplierId)->update([
                'name' => $this->name,
                'name_mm' => $this->name_mm,
                'contact_person' => $this->contact_person,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Supplier updated successfully!');
        } else {
            Supplier::create([
                'name' => $this->name,
                'name_mm' => $this->name_mm,
                'contact_person' => $this->contact_person,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Supplier created successfully!');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->supplierId = $supplier->id;
        $this->name = $supplier->name;
        $this->name_mm = $supplier->name_mm;
        $this->contact_person = $supplier->contact_person;
        $this->phone = $supplier->phone;
        $this->email = $supplier->email;
        $this->address = $supplier->address;
        $this->is_active = $supplier->is_active;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        Supplier::findOrFail($id)->delete();
        session()->flash('message', 'Supplier deleted successfully!');
    }

    public function render()
    {
        $suppliers = Supplier::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('name_mm', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.admin.inventory.supplier-management', [
            'suppliers' => $suppliers,
        ]);
    }
}
```

**View: Copy from customer-management.blade.php and modify fields**

---

## 📊 REPORTS - MINIMAL VIABLE PRODUCT

### Phase 1: Sales Reports (Most Important)

**Component: `app/Livewire/Admin/Reports/SalesByItem.php`**
```php
<?php
namespace App\Livewire\Admin\Reports;

use App\Models\OrderItem;
use Livewire\Component;
use Carbon\Carbon;

class SalesByItem extends Component
{
    public $startDate;
    public $endDate;
    public $reportData = [];

    public function mount()
    {
        $this->startDate = Carbon::today()->format('Y-m-d');
        $this->endDate = Carbon::today()->format('Y-m-d');
        $this->generateReport();
    }

    public function generateReport()
    {
        $this->reportData = OrderItem::with('item')
            ->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ])
            ->selectRaw('item_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales, COUNT(*) as order_count')
            ->groupBy('item_id')
            ->orderByDesc('total_sales')
            ->get()
            ->map(function ($item) {
                return [
                    'item_name' => $item->item->name ?? 'Unknown',
                    'item_name_mm' => $item->item->name_mm ?? '',
                    'quantity' => $item->total_quantity,
                    'sales' => $item->total_sales,
                    'orders' => $item->order_count,
                    'avg_price' => $item->total_quantity > 0 ? $item->total_sales / $item->total_quantity : 0,
                ];
            });
    }

    public function render()
    {
        return view('livewire.admin.reports.sales-by-item');
    }
}
```

**Component: `app/Livewire/Admin/Reports/SalesByCategory.php`**
```php
<?php
namespace App\Livewire\Admin\Reports;

use App\Models\OrderItem;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesByCategory extends Component
{
    public $startDate;
    public $endDate;
    public $reportData = [];

    public function mount()
    {
        $this->startDate = Carbon::today()->format('Y-m-d');
        $this->endDate = Carbon::today()->format('Y-m-d');
        $this->generateReport();
    }

    public function generateReport()
    {
        $this->reportData = OrderItem::with('item.category')
            ->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ])
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->selectRaw('categories.id, categories.name, categories.name_mm, SUM(order_items.quantity) as total_quantity, SUM(order_items.subtotal) as total_sales, COUNT(DISTINCT order_items.order_id) as order_count')
            ->groupBy('categories.id', 'categories.name', 'categories.name_mm')
            ->orderByDesc('total_sales')
            ->get()
            ->map(function ($item) {
                return [
                    'category_name' => $item->name,
                    'category_name_mm' => $item->name_mm ?? '',
                    'quantity' => $item->total_quantity,
                    'sales' => $item->total_sales,
                    'orders' => $item->order_count,
                ];
            });
    }

    public function render()
    {
        return view('livewire.admin.reports.sales-by-category');
    }
}
```

**Component: `app/Livewire/Admin/Reports/DailySummary.php`**
```php
<?php
namespace App\Livewire\Admin\Reports;

use App\Models\Order;
use Livewire\Component;
use Carbon\Carbon;

class DailySummary extends Component
{
    public $startDate;
    public $endDate;
    public $summary = [];

    public function mount()
    {
        $this->startDate = Carbon::today()->format('Y-m-d');
        $this->endDate = Carbon::today()->format('Y-m-d');
        $this->generateReport();
    }

    public function generateReport()
    {
        $orders = Order::whereBetween('created_at', [
            $this->startDate . ' 00:00:00',
            $this->endDate . ' 23:59:59'
        ]);

        $this->summary = [
            'total_orders' => $orders->count(),
            'gross_sales' => $orders->sum('subtotal'),
            'discounts' => $orders->sum('discount_amount'),
            'taxes' => $orders->sum('tax_amount'),
            'service_charges' => $orders->sum('service_charge'),
            'net_sales' => $orders->sum('total'),
            'dine_in_orders' => Order::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->where('order_type', 'dine_in')->count(),
            'takeaway_orders' => Order::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->where('order_type', 'takeaway')->count(),
            'cash_payments' => Order::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->where('payment_method', 'cash')->sum('total'),
            'card_payments' => Order::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->where('payment_method', 'card')->sum('total'),
            'mobile_payments' => Order::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->where('payment_method', 'mobile')->sum('total'),
        ];
    }

    public function render()
    {
        return view('livewire.admin.reports.daily-summary');
    }
}
```

---

## 🎯 IMPLEMENTATION PRIORITY

### Must Have (Do First):
1. ✅ Supplier Management (Simplest)
2. ✅ Sales Reports (Most Useful)

### Nice to Have (Do Later):
3. Stock Items Management
4. Purchase Orders
5. Customer Analytics
6. Peak Hours Analysis

---

## 📝 QUICK COMMANDS

```bash
# Create all Livewire components:
php artisan make:livewire Admin/Inventory/SupplierManagement
php artisan make:livewire Admin/Inventory/StockItemManagement
php artisan make:livewire Admin/Inventory/PurchaseOrderManagement

php artisan make:livewire Admin/Reports/SalesByItem
php artisan make:livewire Admin/Reports/SalesByCategory
php artisan make:livewire Admin/Reports/DailySummary
php artisan make:livewire Admin/Reports/CustomerAnalytics
```

---

## 🚀 ROUTES TO ADD

```php
// routes/web.php

// Inventory routes
Route::middleware(['auth', 'role:admin'])->prefix('admin/inventory')->name('admin.inventory.')->group(function () {
    Route::get('/suppliers', \App\Livewire\Admin\Inventory\SupplierManagement::class)->name('suppliers');
    Route::get('/stock-items', \App\Livewire\Admin\Inventory\StockItemManagement::class)->name('stock-items');
    Route::get('/purchase-orders', \App\Livewire\Admin\Inventory\PurchaseOrderManagement::class)->name('purchase-orders');
});

// Reports routes
Route::middleware(['auth', 'role:admin'])->prefix('admin/reports')->name('admin.reports.')->group(function () {
    Route::get('/sales-by-item', \App\Livewire\Admin\Reports\SalesByItem::class)->name('sales-by-item');
    Route::get('/sales-by-category', \App\Livewire\Admin\Reports\SalesByCategory::class)->name('sales-by-category');
    Route::get('/daily-summary', \App\Livewire\Admin\Reports\DailySummary::class)->name('daily-summary');
    Route::get('/customer-analytics', \App\Livewire\Admin\Reports\CustomerAnalytics::class)->name('customer-analytics');
});
```

---

## 🎨 NAVIGATION TO ADD

```html
<!-- In navigation.blade.php -->

<!-- Inventory Dropdown -->
<x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <button class="flex items-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <span class="myanmar-text">ကုန်ပစ္စည်း</span>
        </button>
    </x-slot>
    <x-slot name="content">
        <x-dropdown-link :href="route('admin.inventory.suppliers')">
            Suppliers
        </x-dropdown-link>
        <x-dropdown-link :href="route('admin.inventory.stock-items')">
            Stock Items
        </x-dropdown-link>
        <x-dropdown-link :href="route('admin.inventory.purchase-orders')">
            Purchase Orders
        </x-dropdown-link>
    </x-slot>
</x-dropdown>

<!-- Reports Dropdown -->
<x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <button class="flex items-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span class="myanmar-text">အစီရင်ခံစာ</span>
        </button>
    </x-slot>
    <x-slot name="content">
        <x-dropdown-link :href="route('admin.reports.sales-by-item')">
            Sales by Item
        </x-dropdown-link>
        <x-dropdown-link :href="route('admin.reports.sales-by-category')">
            Sales by Category
        </x-dropdown-link>
        <x-dropdown-link :href="route('admin.reports.daily-summary')">
            Daily Summary
        </x-dropdown-link>
        <x-dropdown-link :href="route('admin.reports.customer-analytics')">
            Customer Analytics
        </x-dropdown-link>
    </x-slot>
</x-dropdown>
```

---

## ⚡ FASTEST IMPLEMENTATION PATH

### Day 1 (2-3 hours):
1. Copy Supplier model code above
2. Copy SupplierManagement component code
3. Copy customer-management.blade.php view and modify for suppliers
4. Add routes
5. Test

### Day 2 (2-3 hours):
1. Copy all 3 Reports components above
2. Create simple views with tables
3. Add routes
4. Test

### Day 3 (Optional):
1. Stock Items Management
2. Purchase Orders
3. Polish UI

---

## 📊 SIMPLE REPORT VIEW TEMPLATE

```html
<!-- sales-by-item.blade.php -->
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6">Sales by Item</h2>
        
        <!-- Date Range -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid grid-cols-3 gap-4">
                <input type="date" wire:model="startDate" class="input">
                <input type="date" wire:model="endDate" class="input">
                <button wire:click="generateReport" class="btn btn-primary">
                    Generate Report
                </button>
            </div>
        </div>

        <!-- Results Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Item</th>
                        <th class="px-6 py-3 text-right">Quantity</th>
                        <th class="px-6 py-3 text-right">Sales</th>
                        <th class="px-6 py-3 text-right">Orders</th>
                        <th class="px-6 py-3 text-right">Avg Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData as $row)
                    <tr>
                        <td class="px-6 py-4">
                            {{ $row['item_name'] }}
                            @if($row['item_name_mm'])
                            <div class="text-sm text-gray-500 myanmar-text">{{ $row['item_name_mm'] }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">{{ $row['quantity'] }}</td>
                        <td class="px-6 py-4 text-right">{{ number_format($row['sales']) }} Ks</td>
                        <td class="px-6 py-4 text-right">{{ $row['orders'] }}</td>
                        <td class="px-6 py-4 text-right">{{ number_format($row['avg_price']) }} Ks</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
```

---

## 🎯 SUCCESS CRITERIA

### Inventory:
- [ ] Can add/edit/delete suppliers
- [ ] Can search suppliers
- [ ] Myanmar text displays

### Reports:
- [ ] Can view sales by item
- [ ] Can view sales by category
- [ ] Can view daily summary
- [ ] Can select date range
- [ ] Data displays correctly

---

## ⏱️ TIME ESTIMATE

**Minimal Implementation:**
- Supplier Management: 1-2 hours
- 3 Basic Reports: 2-3 hours
- Routes & Navigation: 30 mins
- Testing: 1 hour

**Total: 4-6 hours for working system**

---

## 💡 PRO TIPS

1. **Copy & Modify:** Use customer-management as template
2. **Start Simple:** Get basic CRUD working first
3. **Test Often:** Test each component before moving on
4. **Myanmar Later:** Add Myanmar text after functionality works
5. **Polish Last:** Make it pretty after it works

---

## 🚀 READY TO START!

Follow this guide step-by-step and you'll have Inventory & Reports working in less than a day!

**Start with:** Supplier Management (easiest)
**Then:** Sales Reports (most useful)
**Finally:** Polish and add remaining features

Good luck! 🎉
