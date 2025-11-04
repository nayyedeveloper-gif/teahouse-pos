<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Expense;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ReportsManagement extends Component
{
    public $reportType = 'daily';
    public $startDate;
    public $endDate;
    
    public $totalSales = 0;
    public $totalOrders = 0;
    public $averageOrderValue = 0;
    public $totalTax = 0;
    public $totalDiscount = 0;
    public $totalServiceCharge = 0;
    public $totalExpenses = 0;
    public $grossProfit = 0;
    public $netProfit = 0;
    
    public $topSellingItems = [];
    public $salesByCategory = [];
    public $salesByPaymentMethod = [];
    public $salesByOrderType = [];
    public $expensesByCategory = [];
    public $hourlyBreakdown = [];

    public function mount()
    {
        $this->startDate = now()->startOfDay()->format('Y-m-d');
        $this->endDate = now()->endOfDay()->format('Y-m-d');
        $this->generateReport();
    }

    public function updatedReportType()
    {
        // Auto-set date range based on report type
        switch ($this->reportType) {
            case 'daily':
                $this->startDate = now()->startOfDay()->format('Y-m-d');
                $this->endDate = now()->endOfDay()->format('Y-m-d');
                break;
            case 'weekly':
                $this->startDate = now()->startOfWeek()->format('Y-m-d');
                $this->endDate = now()->endOfWeek()->format('Y-m-d');
                break;
            case 'monthly':
                $this->startDate = now()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->endOfMonth()->format('Y-m-d');
                break;
            case 'yearly':
                $this->startDate = now()->startOfYear()->format('Y-m-d');
                $this->endDate = now()->endOfYear()->format('Y-m-d');
                break;
        }
        
        $this->generateReport();
    }

    public function generateReport()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        // Get orders in date range
        $orders = Order::whereBetween('created_at', [
            $this->startDate . ' 00:00:00',
            $this->endDate . ' 23:59:59'
        ])->where('status', 'completed');

        // Calculate totals
        $this->totalSales = $orders->sum('total');
        $this->totalOrders = $orders->count();
        $this->averageOrderValue = $this->totalOrders > 0 ? $this->totalSales / $this->totalOrders : 0;
        $this->totalTax = $orders->sum('tax_amount');
        $this->totalDiscount = $orders->sum('discount_amount');
        $this->totalServiceCharge = $orders->sum('service_charge');

        // Calculate expenses
        $this->totalExpenses = Expense::whereBetween('expense_date', [
            $this->startDate,
            $this->endDate
        ])->sum('amount');

        // Calculate profit
        $this->grossProfit = $this->totalSales - $this->totalDiscount;
        $this->netProfit = $this->grossProfit - $this->totalExpenses;

        // Top Selling Items
        $this->topSellingItems = DB::table('order_items')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ])
            ->where('orders.status', 'completed')
            ->select(
                'items.name',
                'items.name_mm',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_sales')
            )
            ->groupBy('items.id', 'items.name', 'items.name_mm')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();

        // Sales by Category
        $this->salesByCategory = DB::table('order_items')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ])
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

        // Sales by Order Type
        $this->salesByOrderType = Order::whereBetween('created_at', [
            $this->startDate . ' 00:00:00',
            $this->endDate . ' 23:59:59'
        ])
            ->where('status', 'completed')
            ->select(
                'order_type',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total) as total_sales')
            )
            ->groupBy('order_type')
            ->get();

        // Expenses by Category
        $this->expensesByCategory = Expense::whereBetween('expense_date', [
            $this->startDate,
            $this->endDate
        ])
            ->select(
                'category',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->groupBy('category')
            ->orderByDesc('total_amount')
            ->get();

        // Hourly Breakdown (for daily reports)
        if ($this->reportType === 'daily') {
            $this->hourlyBreakdown = Order::whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ])
                ->where('status', 'completed')
                ->select(
                    DB::raw('HOUR(created_at) as hour'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(total) as total_sales')
                )
                ->groupBy('hour')
                ->orderBy('hour')
                ->get();
        }

        session()->flash('message', 'အစီရင်ခံစာကို ထုတ်ယူပြီးပါပြီ။');
    }

    public function exportReport()
    {
        $orders = Order::with(['orderItems.item', 'table', 'waiter', 'cashier'])
            ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->where('status', 'completed')
            ->get();
        
        $filename = 'sales_report_' . $this->startDate . '_to_' . $this->endDate . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Summary Section
            fputcsv($file, ['SALES REPORT SUMMARY']);
            fputcsv($file, ['Period', $this->startDate . ' to ' . $this->endDate]);
            fputcsv($file, ['Total Sales', number_format($this->totalSales, 2) . ' Ks']);
            fputcsv($file, ['Total Orders', $this->totalOrders]);
            fputcsv($file, ['Average Order Value', number_format($this->averageOrderValue, 2) . ' Ks']);
            fputcsv($file, ['Total Tax', number_format($this->totalTax, 2) . ' Ks']);
            fputcsv($file, ['Total Service Charge', number_format($this->totalServiceCharge, 2) . ' Ks']);
            fputcsv($file, ['Total Discount', number_format($this->totalDiscount, 2) . ' Ks']);
            fputcsv($file, ['Total Expenses', number_format($this->totalExpenses, 2) . ' Ks']);
            fputcsv($file, ['Gross Profit', number_format($this->grossProfit, 2) . ' Ks']);
            fputcsv($file, ['Net Profit', number_format($this->netProfit, 2) . ' Ks']);
            fputcsv($file, []);
            
            // Orders Detail Section
            fputcsv($file, ['ORDERS DETAIL']);
            fputcsv($file, ['Order #', 'Date', 'Time', 'Table', 'Waiter', 'Cashier', 'Order Type', 'Payment Method', 'Subtotal', 'Tax', 'Service', 'Discount', 'Total']);
            
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('Y-m-d'),
                    $order->created_at->format('H:i:s'),
                    $order->table?->name ?? 'Takeaway',
                    $order->waiter?->name ?? '-',
                    $order->cashier?->name ?? '-',
                    $order->order_type === 'dine_in' ? 'Dine In' : 'Takeaway',
                    ucfirst($order->payment_method ?? 'cash'),
                    number_format($order->subtotal, 2),
                    number_format($order->tax_amount, 2),
                    number_format($order->service_charge, 2),
                    number_format($order->discount_amount, 2),
                    number_format($order->total, 2),
                ]);
            }
            
            fputcsv($file, []);
            
            // Top Selling Items
            if (!empty($this->topSellingItems)) {
                fputcsv($file, ['TOP SELLING ITEMS']);
                fputcsv($file, ['Item', 'Quantity Sold', 'Total Sales']);
                foreach ($this->topSellingItems as $item) {
                    fputcsv($file, [
                        $item->name,
                        $item->total_quantity,
                        number_format($item->total_sales, 2) . ' Ks',
                    ]);
                }
                fputcsv($file, []);
            }
            
            // Sales by Payment Method
            if (!empty($this->salesByPaymentMethod)) {
                fputcsv($file, ['SALES BY PAYMENT METHOD']);
                fputcsv($file, ['Payment Method', 'Orders', 'Total Sales']);
                foreach ($this->salesByPaymentMethod as $method) {
                    fputcsv($file, [
                        ucfirst($method->payment_method ?? 'cash'),
                        $method->count,
                        number_format($method->total_sales, 2) . ' Ks',
                    ]);
                }
                fputcsv($file, []);
            }
            
            // Sales by Order Type
            if (!empty($this->salesByOrderType)) {
                fputcsv($file, ['SALES BY ORDER TYPE']);
                fputcsv($file, ['Order Type', 'Orders', 'Total Sales']);
                foreach ($this->salesByOrderType as $type) {
                    fputcsv($file, [
                        $type->order_type === 'dine_in' ? 'Dine In' : 'Takeaway',
                        $type->count,
                        number_format($type->total_sales, 2) . ' Ks',
                    ]);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        return view('livewire.admin.reports-management');
    }
}
