<?php

namespace App\Livewire\Admin;

use App\Models\Item;
use App\Models\Order;
use App\Models\Table;
use App\Models\User;
use App\Models\Expense;
use App\Models\StockItem;
use App\Models\PurchaseOrder;
use App\Models\Customer;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $todaySales = 0;
    public $todayOrders = 0;
    public $totalItems = 0;
    public $totalTables = 0;
    public $occupiedTables = 0;
    public $pendingOrders = 0;
    public $completedOrdersToday = 0;
    public $todayExpenses = 0;
    public $monthlyExpenses = 0;
    public $todayGrossProfit = 0;
    public $todayNetProfit = 0;
    public $todayTax = 0;
    public $todayDiscount = 0;
    public $todayServiceCharge = 0;
    public $todayFOC = 0;
    public $todaySubtotal = 0;
    public $recentExpenses = [];
    public $recentOrders = [];
    public $topSellingItems = [];
    public $salesByCategory = [];
    
    // Inventory stats
    public $totalStockItems = 0;
    public $lowStockItems = 0;
    public $pendingPurchaseOrders = 0;
    public $totalCustomers = 0;

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // Today's sales and breakdown
        $todayOrders = Order::today()->completed();
        
        $this->todaySales = $todayOrders->sum('total');
        $this->todaySubtotal = $todayOrders->sum('subtotal');
        $this->todayTax = $todayOrders->sum('tax_amount');
        $this->todayDiscount = $todayOrders->sum('discount_amount');
        $this->todayServiceCharge = $todayOrders->sum('service_charge');

        // Today's orders count
        $this->todayOrders = Order::today()->count();

        // Completed orders today
        $this->completedOrdersToday = Order::today()->completed()->count();

        // Calculate FOC items value today
        $this->todayFOC = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereDate('orders.created_at', today())
            ->where('orders.status', 'completed')
            ->where('order_items.is_foc', true)
            ->sum('order_items.subtotal');

        // Total items
        $this->totalItems = Item::count();

        // Total tables
        $this->totalTables = Table::count();

        // Occupied tables
        $this->occupiedTables = Table::where('status', 'occupied')->count();

        // Pending orders
        $this->pendingOrders = Order::pending()->count();

        // Today's expenses
        $this->todayExpenses = Expense::whereDate('expense_date', today())->sum('amount');

        // Monthly expenses
        $this->monthlyExpenses = Expense::whereYear('expense_date', now()->year)
            ->whereMonth('expense_date', now()->month)
            ->sum('amount');

        // Calculate profit
        $this->todayGrossProfit = $this->todaySales - $this->todayDiscount;
        $this->todayNetProfit = $this->todayGrossProfit - $this->todayExpenses;

        // Recent expenses (last 5)
        $this->recentExpenses = Expense::with('user')
            ->latest('expense_date')
            ->take(5)
            ->get();

        // Recent orders (last 10)
        $this->recentOrders = Order::with(['table', 'waiter', 'cashier'])
            ->latest()
            ->take(10)
            ->get();

        // Top selling items (today)
        $this->topSellingItems = DB::table('order_items')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereDate('orders.created_at', today())
            ->where('orders.status', 'completed')
            ->select(
                'items.name',
                'items.name_mm',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_sales')
            )
            ->groupBy('items.id', 'items.name', 'items.name_mm')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        // Sales by category (today)
        $this->salesByCategory = DB::table('order_items')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereDate('orders.created_at', today())
            ->where('orders.status', 'completed')
            ->select(
                'categories.name',
                'categories.name_mm',
                DB::raw('SUM(order_items.subtotal) as total_sales'),
                DB::raw('COUNT(DISTINCT orders.id) as order_count')
            )
            ->groupBy('categories.id', 'categories.name', 'categories.name_mm')
            ->orderByDesc('total_sales')
            ->get();
            
        // Inventory stats
        $this->totalStockItems = StockItem::count();
        $this->lowStockItems = StockItem::lowStock()->count();
        $this->pendingPurchaseOrders = PurchaseOrder::pending()->count();
        $this->totalCustomers = Customer::count();
    }

    public function refresh()
    {
        $this->loadDashboardData();
        $this->dispatch('dashboard-refreshed');
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
