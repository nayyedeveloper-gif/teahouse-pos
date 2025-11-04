# 🚀 Advanced Features Implementation Guide

## Overview
This document provides a complete guide for the three advanced features:
1. **Inventory Management System**
2. **Customer Database & Loyalty Program**
3. **Advanced Reports & Analytics**

---

## 1. 📦 INVENTORY MANAGEMENT SYSTEM

### Database Schema

#### Tables Created:
1. **suppliers** - Supplier information
2. **stock_items** - Raw materials/ingredients
3. **purchase_orders** - Purchase orders from suppliers
4. **purchase_order_items** - PO line items
5. **stock_adjustments** - Stock changes (add/remove/damage)
6. **item_stock_usage** - Link menu items to stock items

### Features:

#### A. Supplier Management
```php
// Suppliers table structure
- id
- name (English)
- name_mm (Myanmar)
- contact_person
- phone
- email
- address
- is_active
- timestamps
```

**Use Cases:**
- Add/Edit/Delete suppliers
- Track supplier contact information
- Manage active/inactive suppliers

#### B. Stock Items Management
```php
// Stock items table structure
- id
- name (English)
- name_mm (Myanmar)
- sku (Stock Keeping Unit)
- unit (kg, liter, piece, etc.)
- current_stock
- minimum_stock (for alerts)
- unit_cost
- is_active
- timestamps
```

**Features:**
- Track current stock levels
- Set minimum stock alerts
- Monitor unit costs
- Support multiple units (kg, liter, piece, etc.)

#### C. Purchase Orders
```php
// Purchase orders structure
- id
- po_number (unique)
- supplier_id
- user_id (who created)
- order_date
- expected_delivery_date
- received_date
- status (pending/received/cancelled)
- total_amount
- notes
- timestamps
```

**Workflow:**
1. Create PO → Status: Pending
2. Receive goods → Status: Received (stock updated)
3. Can cancel if needed → Status: Cancelled

#### D. Stock Adjustments
```php
// Stock adjustments structure
- id
- stock_item_id
- user_id
- type (add/remove/damage/expired/correction)
- quantity
- previous_stock
- new_stock
- reason
- timestamps
```

**Types:**
- **Add**: Receive new stock
- **Remove**: Use stock
- **Damage**: Damaged goods
- **Expired**: Expired items
- **Correction**: Fix errors

#### E. Menu Item Stock Usage
```php
// Link menu items to stock items
- id
- item_id (menu item)
- stock_item_id (raw material)
- quantity_used (per menu item)
- timestamps
```

**Example:**
```
Coffee (menu item) uses:
- Coffee beans: 15g
- Milk: 100ml
- Sugar: 5g
```

### Implementation Steps:

#### Step 1: Create Models
```bash
php artisan make:model Supplier
php artisan make:model StockItem
php artisan make:model PurchaseOrder
php artisan make:model PurchaseOrderItem
php artisan make:model StockAdjustment
php artisan make:model ItemStockUsage
```

#### Step 2: Create Livewire Components
```bash
php artisan make:livewire Admin/SupplierManagement
php artisan make:livewire Admin/StockItemManagement
php artisan make:livewire Admin/PurchaseOrderManagement
php artisan make:livewire Admin/StockAdjustments
php artisan make:livewire Admin/LowStockAlerts
```

#### Step 3: Add Routes
```php
// routes/web.php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/suppliers', \App\Livewire\Admin\SupplierManagement::class)->name('suppliers.index');
    Route::get('/stock-items', \App\Livewire\Admin\StockItemManagement::class)->name('stock-items.index');
    Route::get('/purchase-orders', \App\Livewire\Admin\PurchaseOrderManagement::class)->name('purchase-orders.index');
    Route::get('/stock-adjustments', \App\Livewire\Admin\StockAdjustments::class)->name('stock-adjustments.index');
    Route::get('/low-stock-alerts', \App\Livewire\Admin\LowStockAlerts::class)->name('low-stock-alerts');
});
```

#### Step 4: Auto Stock Deduction
```php
// In OrderObserver or OrderItem creation
public function created(OrderItem $orderItem)
{
    // Get stock usage for this menu item
    $stockUsages = ItemStockUsage::where('item_id', $orderItem->item_id)->get();
    
    foreach ($stockUsages as $usage) {
        $stockItem = StockItem::find($usage->stock_item_id);
        $quantityToDeduct = $usage->quantity_used * $orderItem->quantity;
        
        // Create stock adjustment
        StockAdjustment::create([
            'stock_item_id' => $stockItem->id,
            'user_id' => auth()->id(),
            'type' => 'remove',
            'quantity' => $quantityToDeduct,
            'previous_stock' => $stockItem->current_stock,
            'new_stock' => $stockItem->current_stock - $quantityToDeduct,
            'reason' => 'Order #' . $orderItem->order->order_number,
        ]);
        
        // Update stock
        $stockItem->decrement('current_stock', $quantityToDeduct);
        
        // Check low stock alert
        if ($stockItem->current_stock <= $stockItem->minimum_stock) {
            // Send notification or alert
        }
    }
}
```

---

## 2. 👥 CUSTOMER DATABASE & LOYALTY PROGRAM

### Database Schema

#### Tables Created:
1. **customers** - Customer information
2. **customer_loyalty_transactions** - Loyalty points history
3. **orders.customer_id** - Link orders to customers

### Features:

#### A. Customer Management
```php
// Customers table structure
- id
- customer_code (unique, auto-generated)
- name
- name_mm (Myanmar name)
- phone (unique)
- email
- date_of_birth
- gender (male/female/other)
- address
- loyalty_points (current balance)
- total_spent (lifetime)
- visit_count
- last_visit_at
- is_active
- notes
- timestamps
```

**Features:**
- Auto-generate customer code (e.g., CUST0001)
- Track customer demographics
- Monitor spending patterns
- Record visit history

#### B. Loyalty Program
```php
// Loyalty transactions structure
- id
- customer_id
- order_id
- type (earn/redeem/expire/adjust)
- points
- balance_before
- balance_after
- description
- timestamps
```

**Transaction Types:**
- **Earn**: Customer earns points from purchase
- **Redeem**: Customer uses points for discount
- **Expire**: Points expired
- **Adjust**: Manual adjustment by admin

#### C. Points Calculation
```php
// Example: 1 point per 1000 Ks spent
$pointsEarned = floor($orderTotal / 1000);

// Example: 100 points = 1000 Ks discount
$discountAmount = ($pointsRedeemed / 100) * 1000;
```

### Implementation Steps:

#### Step 1: Create Models
```bash
php artisan make:model Customer
php artisan make:model CustomerLoyaltyTransaction
```

#### Step 2: Create Livewire Components
```bash
php artisan make:livewire Admin/CustomerManagement
php artisan make:livewire Admin/CustomerDetails
php artisan make:livewire Admin/LoyaltySettings
php artisan make:livewire Cashier/CustomerLookup
```

#### Step 3: Add to Order Creation
```php
// In CreateOrder component
public $customer_id = null;
public $customer_phone = '';
public $loyalty_points_to_redeem = 0;

public function searchCustomer()
{
    $customer = Customer::where('phone', $this->customer_phone)->first();
    
    if ($customer) {
        $this->customer_id = $customer->id;
        // Show customer info and available points
    }
}

public function submitOrder()
{
    // ... existing order creation code ...
    
    if ($this->customer_id) {
        $customer = Customer::find($this->customer_id);
        
        // Redeem points if requested
        if ($this->loyalty_points_to_redeem > 0) {
            $discountAmount = ($this->loyalty_points_to_redeem / 100) * 1000;
            $order->discount_amount += $discountAmount;
            
            // Record redemption
            CustomerLoyaltyTransaction::create([
                'customer_id' => $customer->id,
                'order_id' => $order->id,
                'type' => 'redeem',
                'points' => -$this->loyalty_points_to_redeem,
                'balance_before' => $customer->loyalty_points,
                'balance_after' => $customer->loyalty_points - $this->loyalty_points_to_redeem,
                'description' => 'Redeemed for Order #' . $order->order_number,
            ]);
            
            $customer->decrement('loyalty_points', $this->loyalty_points_to_redeem);
        }
        
        // Earn points from this order
        $pointsEarned = floor($order->total / 1000);
        
        CustomerLoyaltyTransaction::create([
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'type' => 'earn',
            'points' => $pointsEarned,
            'balance_before' => $customer->loyalty_points,
            'balance_after' => $customer->loyalty_points + $pointsEarned,
            'description' => 'Earned from Order #' . $order->order_number,
        ]);
        
        // Update customer stats
        $customer->increment('loyalty_points', $pointsEarned);
        $customer->increment('total_spent', $order->total);
        $customer->increment('visit_count');
        $customer->update(['last_visit_at' => now()]);
    }
}
```

#### Step 4: Customer Reports
- Top customers by spending
- Customer visit frequency
- Loyalty points usage
- Customer demographics
- Birthday promotions

---

## 3. 📊 ADVANCED REPORTS & ANALYTICS

### Database Schema

#### Tables Created:
1. **report_caches** - Cache report data for performance
2. **daily_sales_summaries** - Pre-calculated daily summaries

### Reports Available:

#### A. Sales by Item
```php
// Query example
$salesByItem = OrderItem::with('item')
    ->whereBetween('created_at', [$startDate, $endDate])
    ->selectRaw('item_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales')
    ->groupBy('item_id')
    ->orderByDesc('total_sales')
    ->get();
```

**Metrics:**
- Total quantity sold
- Total revenue
- Average price
- Profit margin (if cost tracked)

#### B. Sales by Category
```php
// Query example
$salesByCategory = OrderItem::with('item.category')
    ->whereBetween('created_at', [$startDate, $endDate])
    ->join('items', 'order_items.item_id', '=', 'items.id')
    ->selectRaw('items.category_id, SUM(order_items.quantity) as total_quantity, SUM(order_items.subtotal) as total_sales')
    ->groupBy('items.category_id')
    ->orderByDesc('total_sales')
    ->get();
```

**Metrics:**
- Revenue by category
- Quantity sold by category
- Category performance trends

#### C. Sales by Waiter
```php
// Query example
$salesByWaiter = Order::with('waiter')
    ->whereBetween('created_at', [$startDate, $endDate])
    ->selectRaw('waiter_id, COUNT(*) as total_orders, SUM(total) as total_sales')
    ->groupBy('waiter_id')
    ->orderByDesc('total_sales')
    ->get();
```

**Metrics:**
- Orders per waiter
- Revenue per waiter
- Average order value
- Performance rankings

#### D. Profit/Loss Report
```php
// Calculate profit
$revenue = Order::whereBetween('created_at', [$startDate, $endDate])
    ->sum('total');

$expenses = Expense::whereBetween('date', [$startDate, $endDate])
    ->sum('amount');

$costOfGoodsSold = // Calculate from inventory if tracked

$grossProfit = $revenue - $costOfGoodsSold;
$netProfit = $grossProfit - $expenses;
```

**Metrics:**
- Total revenue
- Cost of goods sold (COGS)
- Gross profit
- Operating expenses
- Net profit
- Profit margin %

#### E. Daily Sales Summary
```php
// Auto-generate at end of day (scheduled task)
DailySalesSummary::create([
    'date' => today(),
    'total_orders' => Order::whereDate('created_at', today())->count(),
    'gross_sales' => Order::whereDate('created_at', today())->sum('subtotal'),
    'discounts' => Order::whereDate('created_at', today())->sum('discount_amount'),
    'taxes' => Order::whereDate('created_at', today())->sum('tax_amount'),
    'service_charges' => Order::whereDate('created_at', today())->sum('service_charge'),
    'net_sales' => Order::whereDate('created_at', today())->sum('total'),
    'dine_in_orders' => Order::whereDate('created_at', today())->where('order_type', 'dine_in')->count(),
    'takeaway_orders' => Order::whereDate('created_at', today())->where('order_type', 'takeaway')->count(),
    'cash_payments' => Order::whereDate('created_at', today())->where('payment_method', 'cash')->sum('total'),
    'card_payments' => Order::whereDate('created_at', today())->where('payment_method', 'card')->sum('total'),
    'mobile_payments' => Order::whereDate('created_at', today())->where('payment_method', 'mobile')->sum('total'),
]);
```

#### F. Peak Hours Analysis
```php
// Query example
$peakHours = Order::whereBetween('created_at', [$startDate, $endDate])
    ->selectRaw('HOUR(created_at) as hour, COUNT(*) as order_count, SUM(total) as total_sales')
    ->groupBy('hour')
    ->orderBy('hour')
    ->get();
```

#### G. Customer Analytics
```php
// Top customers
$topCustomers = Customer::orderByDesc('total_spent')
    ->limit(10)
    ->get();

// New vs returning customers
$newCustomers = Customer::whereBetween('created_at', [$startDate, $endDate])->count();
$returningCustomers = Customer::where('visit_count', '>', 1)
    ->whereBetween('last_visit_at', [$startDate, $endDate])
    ->count();
```

### Implementation Steps:

#### Step 1: Create Report Models
```bash
php artisan make:model ReportCache
php artisan make:model DailySalesSummary
```

#### Step 2: Create Report Services
```bash
php artisan make:class Services/ReportService
```

```php
// app/Services/ReportService.php
class ReportService
{
    public function getSalesByItem($startDate, $endDate)
    {
        // Check cache first
        $cacheKey = 'sales_by_item_' . $startDate . '_' . $endDate;
        
        return Cache::remember($cacheKey, 3600, function () use ($startDate, $endDate) {
            return OrderItem::with('item')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('item_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales')
                ->groupBy('item_id')
                ->orderByDesc('total_sales')
                ->get();
        });
    }
    
    // ... other report methods
}
```

#### Step 3: Create Livewire Components
```bash
php artisan make:livewire Admin/Reports/SalesByItem
php artisan make:livewire Admin/Reports/SalesByCategory
php artisan make:livewire Admin/Reports/SalesByWaiter
php artisan make:livewire Admin/Reports/ProfitLoss
php artisan make:livewire Admin/Reports/PeakHours
php artisan make:livewire Admin/Reports/CustomerAnalytics
```

#### Step 4: Schedule Daily Summary
```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Generate daily summary at midnight
    $schedule->call(function () {
        app(ReportService::class)->generateDailySummary(yesterday());
    })->dailyAt('00:05');
}
```

#### Step 5: Export to Excel
```bash
composer require maatwebsite/excel
php artisan make:export SalesByItemExport
```

```php
// app/Exports/SalesByItemExport.php
class SalesByItemExport implements FromCollection, WithHeadings
{
    protected $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function collection()
    {
        return $this->data;
    }
    
    public function headings(): array
    {
        return ['Item Name', 'Quantity Sold', 'Total Sales', 'Average Price'];
    }
}
```

---

## 📈 IMPLEMENTATION PRIORITY

### Phase 1: Foundation (Week 1)
1. ✅ Create all migrations
2. ✅ Run migrations
3. Create all models with relationships
4. Create basic CRUD for each module

### Phase 2: Core Features (Week 2)
1. **Inventory:**
   - Supplier management UI
   - Stock items management UI
   - Purchase order creation
   - Stock adjustment UI

2. **Customers:**
   - Customer registration
   - Customer lookup in POS
   - Basic loyalty points

3. **Reports:**
   - Sales by item report
   - Sales by category report
   - Daily summary report

### Phase 3: Advanced Features (Week 3)
1. **Inventory:**
   - Auto stock deduction on orders
   - Low stock alerts
   - Stock reports

2. **Customers:**
   - Points redemption in POS
   - Customer analytics
   - Birthday promotions

3. **Reports:**
   - Profit/loss report
   - Peak hours analysis
   - Export to Excel

### Phase 4: Polish & Optimization (Week 4)
1. Report caching
2. Performance optimization
3. UI/UX improvements
4. Testing
5. Documentation

---

## 🎯 QUICK START CHECKLIST

### For Inventory Management:
- [ ] Run migrations
- [ ] Create Supplier model & component
- [ ] Create StockItem model & component
- [ ] Create PurchaseOrder model & component
- [ ] Add navigation links
- [ ] Test CRUD operations
- [ ] Implement auto stock deduction
- [ ] Setup low stock alerts

### For Customer Database:
- [ ] Run migrations
- [ ] Create Customer model & component
- [ ] Add customer lookup to POS
- [ ] Implement loyalty points earning
- [ ] Implement loyalty points redemption
- [ ] Create customer reports
- [ ] Test end-to-end flow

### For Advanced Reports:
- [ ] Run migrations
- [ ] Create ReportService
- [ ] Create report components
- [ ] Implement caching
- [ ] Add export functionality
- [ ] Schedule daily summaries
- [ ] Create dashboard widgets

---

## 📚 ADDITIONAL RESOURCES

### Models to Create:
```bash
php artisan make:model Supplier
php artisan make:model StockItem
php artisan make:model PurchaseOrder
php artisan make:model PurchaseOrderItem
php artisan make:model StockAdjustment
php artisan make:model ItemStockUsage
php artisan make:model Customer
php artisan make:model CustomerLoyaltyTransaction
php artisan make:model ReportCache
php artisan make:model DailySalesSummary
```

### Services to Create:
```bash
php artisan make:class Services/InventoryService
php artisan make:class Services/CustomerService
php artisan make:class Services/ReportService
php artisan make:class Services/LoyaltyService
```

### Observers to Create:
```bash
php artisan make:observer OrderObserver
php artisan make:observer OrderItemObserver
php artisan make:observer CustomerObserver
```

---

## 🚀 READY TO IMPLEMENT!

All database tables are created and ready. Follow the implementation steps above to build out each feature.

**Estimated Development Time:**
- Inventory Management: 2-3 weeks
- Customer Database: 1-2 weeks
- Advanced Reports: 1-2 weeks
- **Total: 4-7 weeks for full implementation**

**Priority Order:**
1. Customer Database (most immediate value)
2. Advanced Reports (business insights)
3. Inventory Management (operational efficiency)

Good luck! 🎉
