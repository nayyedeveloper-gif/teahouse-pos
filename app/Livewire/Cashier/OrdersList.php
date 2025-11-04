<?php

namespace App\Livewire\Cashier;

use App\Models\Order;
use App\Models\Table;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $tableFilter = '';
    public $dateFilter = 'today';
    
    public $selectedOrder = null;
    public $showOrderDetails = false;
    
    // Payment modal
    public $showPaymentModal = false;
    public $paymentOrder = null;
    public $paymentMethod = 'cash'; // cash, card, mobile
    public $amountReceived = 0;
    public $applyTax = false;
    public $applyService = false;
    public $discountType = 'none'; // none, percentage, fixed
    public $discountValue = 0;
    public $calculatedSubtotal = 0;
    public $calculatedTax = 0;
    public $calculatedService = 0;
    public $calculatedDiscount = 0;
    public $calculatedTotal = 0;
    public $calculatedChange = 0;
    
    // Success modal
    public $showSuccessModal = false;
    public $completedOrderId = null;

    protected $queryString = ['search', 'statusFilter', 'tableFilter', 'dateFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTableFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with(['table', 'orderItems.item', 'waiter', 'cashier'])
            ->findOrFail($orderId);
        $this->showOrderDetails = true;
    }

    public function closeOrderDetails()
    {
        $this->showOrderDetails = false;
        $this->selectedOrder = null;
    }

    public function printReceipt($orderId)
    {
        $this->selectedOrder = Order::with(['table', 'orderItems.item', 'waiter', 'cashier'])
            ->findOrFail($orderId);
        
        $this->dispatch('print-receipt', orderId: $orderId);
    }

    public function cancelOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Only allow canceling pending orders
        if ($order->status !== 'pending') {
            session()->flash('error', 'ပြီးဆုံးပြီး သို့မဟုတ် ပယ်ဖျက်ပြီး အော်ဒါကို ပယ်ဖျက်၍ မရပါ။');
            return;
        }
        
        $order->update(['status' => 'cancelled']);
        
        // Free up table if exists
        if ($order->table) {
            $order->table->update(['status' => 'available']);
        }
        
        session()->flash('message', 'အော်ဒါကို ပယ်ဖျက်ပြီးပါပြီ။');
        
        if ($this->selectedOrder && $this->selectedOrder->id == $orderId) {
            $this->closeOrderDetails();
        }
    }

    public function deleteOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Only allow deleting cancelled orders
        if ($order->status !== 'cancelled') {
            session()->flash('error', 'ပယ်ဖျက်ထားသော အော်ဒါများကိုသာ ဖျက်နိုင်ပါသည်။');
            return;
        }
        
        $order->delete();
        
        session()->flash('message', 'အော်ဒါကို ဖျက်ပြီးပါပြီ။');
        
        if ($this->selectedOrder && $this->selectedOrder->id == $orderId) {
            $this->closeOrderDetails();
        }
    }
    
    public function openPaymentModal($orderId)
    {
        $this->paymentOrder = Order::with(['table', 'orderItems.item'])->findOrFail($orderId);
        
        if ($this->paymentOrder->status !== 'pending') {
            session()->flash('error', 'Pending အော်ဒါများကိုသာ ငွေရှင်းနိုင်ပါသည်။');
            return;
        }
        
        // Reset payment fields
        $this->paymentMethod = 'cash';
        $this->amountReceived = 0;
        $this->applyTax = false;
        $this->applyService = false;
        $this->discountType = 'none';
        $this->discountValue = 0;
        
        $this->calculatePayment();
        $this->showPaymentModal = true;
    }
    
    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->paymentOrder = null;
    }
    
    public function updatedApplyTax()
    {
        $this->calculatePayment();
    }
    
    public function updatedApplyService()
    {
        $this->calculatePayment();
    }
    
    public function updatedDiscountType()
    {
        $this->discountValue = 0;
        $this->calculatePayment();
    }
    
    public function updatedDiscountValue()
    {
        $this->calculatePayment();
    }
    
    public function updatedPaymentMethod()
    {
        // Reset amount received when payment method changes
        if ($this->paymentMethod !== 'cash') {
            $this->amountReceived = $this->calculatedTotal;
        } else {
            $this->amountReceived = 0;
        }
        $this->calculatePayment();
    }
    
    public function updatedAmountReceived()
    {
        $this->calculatePayment();
    }
    
    public function calculatePayment()
    {
        if (!$this->paymentOrder) return;
        
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        
        // Subtotal from order items
        $this->calculatedSubtotal = $this->paymentOrder->orderItems->sum('subtotal');
        
        // Tax
        if ($this->applyTax) {
            $taxPercentage = $settings['tax_percentage'] ?? 0;
            $this->calculatedTax = $this->calculatedSubtotal * ($taxPercentage / 100);
        } else {
            $this->calculatedTax = 0;
        }
        
        // Service charge
        if ($this->applyService) {
            $serviceCharge = $settings['service_charge'] ?? 0;
            $this->calculatedService = $serviceCharge;
        } else {
            $this->calculatedService = 0;
        }
        
        // Discount
        if ($this->discountType === 'percentage') {
            $this->calculatedDiscount = $this->calculatedSubtotal * ($this->discountValue / 100);
        } elseif ($this->discountType === 'fixed') {
            $this->calculatedDiscount = $this->discountValue;
        } else {
            $this->calculatedDiscount = 0;
        }
        
        // Total
        $this->calculatedTotal = $this->calculatedSubtotal 
                                + $this->calculatedTax 
                                + $this->calculatedService 
                                - $this->calculatedDiscount;
        
        // Ensure total is not negative
        $this->calculatedTotal = max(0, $this->calculatedTotal);
        
        // Calculate change for cash payments
        if ($this->paymentMethod === 'cash' && $this->amountReceived > 0) {
            $this->calculatedChange = $this->amountReceived - $this->calculatedTotal;
        } else {
            $this->calculatedChange = 0;
        }
    }
    
    public function processPayment()
    {
        if (!$this->paymentOrder) return;
        
        // Validate cash payment
        if ($this->paymentMethod === 'cash' && $this->amountReceived < $this->calculatedTotal) {
            session()->flash('error', 'ပေးငွေ မလုံလောက်ပါ။');
            return;
        }
        
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        
        // Update order
        $this->paymentOrder->update([
            'subtotal' => $this->calculatedSubtotal,
            'tax_amount' => $this->calculatedTax,
            'tax_percentage' => $this->applyTax ? ($settings['tax_percentage'] ?? 0) : 0,
            'service_charge' => $this->calculatedService,
            'discount_amount' => $this->calculatedDiscount,
            'discount_percentage' => $this->discountType === 'percentage' ? $this->discountValue : 0,
            'total' => $this->calculatedTotal,
            'payment_method' => $this->paymentMethod,
            'amount_received' => $this->paymentMethod === 'cash' ? $this->amountReceived : $this->calculatedTotal,
            'change_amount' => $this->calculatedChange,
            'status' => 'completed',
            'cashier_id' => auth()->id(),
            'completed_at' => now(),
        ]);
        
        // Free up table
        if ($this->paymentOrder->table) {
            $this->paymentOrder->table->update(['status' => 'available']);
        }
        
        // Store completed order ID for success modal
        $this->completedOrderId = $this->paymentOrder->id;
        
        // Close payment modal and show success modal
        $this->closePaymentModal();
        $this->showSuccessModal = true;
        
        if ($this->selectedOrder && $this->selectedOrder->id == $this->completedOrderId) {
            $this->closeOrderDetails();
        }
    }
    
    public function closeSuccessModal()
    {
        $this->showSuccessModal = false;
        $this->completedOrderId = null;
    }
    
    public function printCompletedReceipt()
    {
        if ($this->completedOrderId) {
            $this->dispatch('print-payment-receipt', orderId: $this->completedOrderId);
            $this->closeSuccessModal();
        }
    }

    public function render()
    {
        $query = Order::with(['table', 'orderItems', 'waiter', 'cashier'])
            ->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('table', function($q) {
                      $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('name_mm', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->tableFilter) {
            $query->where('table_id', $this->tableFilter);
        }

        if ($this->dateFilter) {
            switch ($this->dateFilter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', today()->subDay());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }
        }

        $orders = $query->paginate(20);
        $tables = Table::active()->ordered()->get();

        return view('livewire.cashier.orders-list', [
            'orders' => $orders,
            'tables' => $tables,
        ]);
    }
}
