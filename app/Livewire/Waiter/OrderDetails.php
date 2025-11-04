<?php

namespace App\Livewire\Waiter;

use App\Models\Order;
use Livewire\Component;

class OrderDetails extends Component
{
    public $orderId;
    public $order;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->loadOrder();
    }

    public function loadOrder()
    {
        $this->order = Order::with(['table', 'waiter', 'cashier', 'items.item'])
            ->findOrFail($this->orderId);
    }

    public function updateStatus($status)
    {
        $this->order->update(['status' => $status]);
        $this->loadOrder();
        session()->flash('success', 'Order status updated successfully!');
    }

    public function render()
    {
        return view('livewire.waiter.order-details');
    }
}
