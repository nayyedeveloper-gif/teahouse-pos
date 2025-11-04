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
        try {
            $orders = Order::whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ]);

            $totalOrders = (clone $orders)->count();
            $totalSales = (clone $orders)->sum('total');

            $this->summary = [
                'total_orders' => $totalOrders,
                'gross_sales' => (clone $orders)->sum('subtotal'),
                'discounts' => (clone $orders)->sum('discount_amount'),
                'taxes' => (clone $orders)->sum('tax_amount'),
                'service_charges' => (clone $orders)->sum('service_charge'),
                'net_sales' => $totalSales,
                'dine_in_orders' => Order::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->where('order_type', 'dine_in')->count(),
                'takeaway_orders' => Order::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->where('order_type', 'takeaway')->count(),
                'cash_payments' => Order::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->where('payment_method', 'cash')->sum('total'),
                'card_payments' => Order::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->where('payment_method', 'card')->sum('total'),
                'mobile_payments' => Order::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->where('payment_method', 'mobile')->sum('total'),
                'avg_order_value' => $totalOrders > 0 ? $totalSales / $totalOrders : 0,
            ];
            
            session()->flash('message', 'အစီရင်ခံစာ အောင်မြင်စွာ ထုတ်ပြီးပါပြီ။ (' . $totalOrders . ' orders)');
        } catch (\Exception $e) {
            session()->flash('error', 'အစီရင်ခံစာ ထုတ်ရာတွင် အမှားရှိနေပါသည်: ' . $e->getMessage());
            $this->summary = [];
        }
    }

    public function render()
    {
        return view('livewire.admin.reports.daily-summary');
    }
}
