<?php

namespace App\Livewire\Cashier;

use App\Models\Order;
use App\Services\PrinterService;
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
        try {
            $printerService = new PrinterService();
            $printerService->printReceipt($this->order);
            
            session()->flash('success', 'Receipt sent to printer successfully!');
        } catch (\Exception $e) {
            logger()->error('Print receipt error: ' . $e->getMessage());
            session()->flash('error', 'Failed to print receipt: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.cashier.order-details');
    }
}
