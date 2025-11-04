<?php

namespace App\Livewire\Waiter;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersList extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function viewOrder($orderId)
    {
        return redirect()->route('waiter.orders.show', $orderId);
    }

    public function render()
    {
        $orders = Order::with(['table', 'waiter', 'items'])
            ->where('waiter_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('order_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('table', function ($tq) {
                          $tq->where('name', 'like', '%' . $this->search . '%')
                             ->orWhere('name_mm', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(20);

        return view('livewire.waiter.orders-list', [
            'orders' => $orders,
        ]);
    }
}
