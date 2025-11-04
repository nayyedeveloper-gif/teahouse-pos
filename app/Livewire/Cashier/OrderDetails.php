<?php

namespace App\Livewire\Cashier;

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

    public function printReceipt()
    {
        // Receipt printing logic will be added later
        session()->flash('success', 'Receipt sent to printer!');
    }

    public function render()
    {
        return view('livewire.cashier.order-details');
    }
}
