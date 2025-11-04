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
        try {
            $this->reportData = OrderItem::with('item')
                ->whereBetween('created_at', [
                    $this->startDate . ' 00:00:00',
                    $this->endDate . ' 23:59:59'
                ])
                ->selectRaw('item_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales, COUNT(DISTINCT order_id) as order_count')
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
                })
                ->toArray();
                
            session()->flash('message', 'အစီရင်ခံစာ အောင်မြင်စွာ ထုတ်ပြီးပါပြီ။ (' . count($this->reportData) . ' items)');
        } catch (\Exception $e) {
            session()->flash('error', 'အစီရင်ခံစာ ထုတ်ရာတွင် အမှားရှိနေပါသည်: ' . $e->getMessage());
            $this->reportData = [];
        }
    }

    public function render()
    {
        return view('livewire.admin.reports.sales-by-item');
    }
}
