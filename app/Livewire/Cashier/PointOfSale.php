<?php

namespace App\Livewire\Cashier;

use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use App\Models\Customer;
use App\Models\Setting;
use App\Models\Card;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PointOfSale extends Component
{
    public $categories;
    public $selectedCategory = null;
    public $items = [];
    public $cart = [];
    public $searchTerm = '';
    
    // Order details
    public $orderType = 'dine_in';
    public $selectedTable = null;
    public $customerName = '';
    public $customerPhone = '';
    public $notes = '';
    
    // Customer & Loyalty
    public $customer_id = null;
    public $customer = null;
    public $customer_search_phone = '';
    public $loyalty_points_to_redeem = 0;
    public $showCustomerLookup = false;
    
    // Payment
    public $subtotal = 0;
    public $taxPercentage = 0;
    public $taxAmount = 0;
    public $discountPercentage = 0;
    public $discountAmount = 0;
    public $serviceCharge = 0;
    public $total = 0;
    public $paymentMethod = 'cash';
    public $amountReceived = 0;
    public $change = 0;
    
    // Card Payment
    public $card_number = '';
    public $card = null;
    public $card_balance = 0;
    public $showCardReloadModal = false;
    public $card_reload_amount = 0;
    
    // UI State
    public $showPaymentModal = false;
    public $showSuccessModal = false;
    public $completedOrderId = null;
    public $availableTables = [];

    public function mount()
    {
        $this->loadCategories();
        $this->loadItems();
        $this->loadAvailableTables();
        $this->loadDefaultSettings();
    }
    
    public function loadDefaultSettings()
    {
        // Load default tax and service charge from settings
        $this->taxPercentage = Setting::get('default_tax_percentage', 0);
        $this->serviceCharge = Setting::get('default_service_charge', 0);
        $this->calculateTotals();
    }

    public function loadCategories()
    {
        $this->categories = Category::active()
            ->ordered()
            ->withCount('activeItems')
            ->get();

        if ($this->categories->isNotEmpty() && !$this->selectedCategory) {
            $this->selectedCategory = $this->categories->first()->id;
        }
    }

    public function loadItems()
    {
        $query = Item::active()->available()->with('category');

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('name_mm', 'like', '%' . $this->searchTerm . '%');
            });
        }

        $this->items = $query->ordered()->get();
    }

    public function loadAvailableTables()
    {
        $this->availableTables = Table::active()->available()->ordered()->get();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->loadItems();
    }

    public function updatedSearchTerm()
    {
        $this->loadItems();
    }

    public function updatedOrderType()
    {
        if ($this->orderType !== 'dine_in') {
            $this->selectedTable = null;
        }
    }
    
    public function searchCustomer()
    {
        if (empty($this->customer_search_phone)) {
            session()->flash('customer_error', 'ဖုန်းနံပါတ် ရိုက်ထည့်ပါ');
            return;
        }

        $customer = Customer::where('phone', $this->customer_search_phone)->first();

        if ($customer) {
            $this->customer = $customer;
            $this->customer_id = $customer->id;
            $this->customerName = $customer->name;
            $this->customerPhone = $customer->phone;
            session()->forget('customer_error');
        } else {
            session()->flash('customer_error', 'ဖောက်သည် မတွေ့ပါ');
            $this->clearCustomer();
        }
    }

    public function clearCustomer()
    {
        $this->customer = null;
        $this->customer_id = null;
        $this->loyalty_points_to_redeem = 0;
        $this->calculateTotals();
    }
    
    public function updatedLoyaltyPointsToRedeem()
    {
        $this->calculateTotals();
    }
    
    // Card Payment Methods
    public function checkCardBalance()
    {
        if (empty($this->card_number)) {
            session()->flash('card_error', 'Card number ရိုက်ထည့်ပါ');
            return;
        }

        $card = Card::where('card_number', $this->card_number)
            ->where('status', 'active')
            ->first();

        if ($card) {
            if (!$card->isActive()) {
                session()->flash('card_error', 'ဤ Card သက်တမ်းကုန်ဆုံးပြီး သို့မဟုတ် အသုံးပြု၍မရပါ');
                $this->card = null;
                $this->card_balance = 0;
                return;
            }

            $this->card = $card;
            $this->card_balance = $card->balance;
            session()->forget('card_error');
            
            // If sufficient balance, auto-select card payment
            if ($this->card_balance >= $this->total) {
                $this->paymentMethod = 'card';
            }
        } else {
            session()->flash('card_error', 'Card မတွေ့ပါ');
            $this->card = null;
            $this->card_balance = 0;
        }
    }
    
    public function clearCard()
    {
        $this->card = null;
        $this->card_number = '';
        $this->card_balance = 0;
        if ($this->paymentMethod === 'card') {
            $this->paymentMethod = 'cash';
        }
        session()->forget('card_error');
    }
    
    public function openCardReloadModal()
    {
        if (!$this->card) {
            session()->flash('card_error', 'Card ကို ရှာဖွေပါ');
            return;
        }
        $this->card_reload_amount = 0;
        $this->showCardReloadModal = true;
    }
    
    public function closeCardReloadModal()
    {
        $this->showCardReloadModal = false;
        $this->card_reload_amount = 0;
    }
    
    public function reloadCard()
    {
        $this->validate([
            'card_reload_amount' => 'required|numeric|min:100',
        ]);

        try {
            // Calculate bonus if enabled
            $bonusAmount = 0;
            if (Setting::get('card_bonus_enabled', false)) {
                $bonusPercentage = Setting::get('card_bonus_percentage', 0);
                $bonusAmount = ($this->card_reload_amount * $bonusPercentage) / 100;
            }

            $this->card->addBalance(
                $this->card_reload_amount,
                'cash',
                $bonusAmount,
                auth()->id()
            );

            // Refresh card balance
            $this->card->refresh();
            $this->card_balance = $this->card->balance;

            $message = "{$this->card_reload_amount} Ks ထည့်သွင်းပြီးပါပြီ";
            if ($bonusAmount > 0) {
                $message .= " (Bonus: {$bonusAmount} Ks)";
            }

            session()->flash('message', $message);
            $this->closeCardReloadModal();

        } catch (\Exception $e) {
            session()->flash('card_error', 'ငွေထည့်သွင်းရာတွင် အမှားအယွင်း ဖြစ်ပေါ်ခဲ့ပါသည်။');
        }
    }

    public function addToCart($itemId)
    {
        $item = Item::find($itemId);

        if (!$item || !$item->is_available) {
            session()->flash('error', 'Item not available');
            return;
        }

        $cartKey = 'item_' . $itemId;

        if (isset($this->cart[$cartKey])) {
            $this->cart[$cartKey]['quantity']++;
        } else {
            $this->cart[$cartKey] = [
                'item_id' => $item->id,
                'name' => $item->name,
                'name_mm' => $item->name_mm,
                'price' => $item->price,
                'quantity' => 1,
                'is_foc' => false,
                'notes' => '',
            ];
        }

        $this->calculateTotals();
    }

    public function updateQuantity($cartKey, $quantity)
    {
        if ($quantity <= 0) {
            unset($this->cart[$cartKey]);
        } else {
            $this->cart[$cartKey]['quantity'] = $quantity;
        }
        $this->calculateTotals();
    }

    public function removeFromCart($cartKey)
    {
        unset($this->cart[$cartKey]);
        $this->calculateTotals();
    }

    public function toggleFoc($cartKey)
    {
        $this->cart[$cartKey]['is_foc'] = !$this->cart[$cartKey]['is_foc'];
        $this->calculateTotals();
    }

    public function updateItemNotes($cartKey, $notes)
    {
        $this->cart[$cartKey]['notes'] = $notes;
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        
        foreach ($this->cart as $item) {
            if (!$item['is_foc']) {
                $this->subtotal += $item['price'] * $item['quantity'];
            }
        }

        // Calculate tax
        $this->taxAmount = ($this->subtotal * $this->taxPercentage) / 100;

        // Calculate discount
        if ($this->discountPercentage > 0) {
            $this->discountAmount = ($this->subtotal * $this->discountPercentage) / 100;
        }
        
        // Add loyalty discount
        $loyaltyDiscount = 0;
        if ($this->customer && $this->loyalty_points_to_redeem > 0) {
            $loyaltyDiscount = ($this->loyalty_points_to_redeem / 100) * 1000;
        }

        // Calculate total
        $this->total = $this->subtotal + $this->taxAmount - $this->discountAmount - $loyaltyDiscount + $this->serviceCharge;
        
        // Calculate change
        $this->change = max(0, $this->amountReceived - $this->total);
    }

    public function updatedTaxPercentage()
    {
        $this->calculateTotals();
    }

    public function updatedDiscountPercentage()
    {
        $this->calculateTotals();
    }

    public function updatedDiscountAmount()
    {
        if ($this->subtotal > 0) {
            $this->discountPercentage = ($this->discountAmount / $this->subtotal) * 100;
        }
        $this->calculateTotals();
    }

    public function updatedServiceCharge()
    {
        $this->calculateTotals();
    }

    public function updatedAmountReceived()
    {
        $this->calculateTotals();
    }

    public function openPaymentModal()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Cart is empty');
            return;
        }

        $this->amountReceived = $this->total;
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
    }

    public function processPayment()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Cart is empty');
            return;
        }

        if ($this->paymentMethod === 'cash' && $this->amountReceived < $this->total) {
            session()->flash('error', 'Insufficient payment amount');
            return;
        }
        
        // Validate card payment
        if ($this->paymentMethod === 'card') {
            if (!$this->card) {
                session()->flash('error', 'Card ကို ရှာဖွေပါ');
                return;
            }
            
            if (!$this->card->hasBalance($this->total)) {
                session()->flash('error', 'Card balance မလုံလောက်ပါ။ လက်ရှိ balance: ' . number_format($this->card_balance) . ' Ks');
                return;
            }
        }

        if ($this->orderType === 'dine_in' && !$this->selectedTable) {
            session()->flash('error', 'Please select a table');
            return;
        }

        try {
            DB::beginTransaction();
            
            // Calculate loyalty discount
            $loyaltyDiscount = 0;
            if ($this->customer && $this->loyalty_points_to_redeem > 0) {
                $loyaltyDiscount = ($this->loyalty_points_to_redeem / 100) * 1000;
            }

            // Create order
            $order = Order::create([
                'table_id' => $this->selectedTable,
                'customer_id' => $this->customer_id,
                'cashier_id' => auth()->id(),
                'order_type' => $this->orderType,
                'status' => 'completed',
                'subtotal' => $this->subtotal,
                'tax_amount' => $this->taxAmount,
                'tax_percentage' => $this->taxPercentage,
                'discount_amount' => $this->discountAmount + $loyaltyDiscount,
                'discount_percentage' => $this->discountPercentage,
                'service_charge' => $this->serviceCharge,
                'total' => $this->total,
                'notes' => $this->notes,
                'completed_at' => now(),
            ]);

            // Create order items
            foreach ($this->cart as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_id' => $cartItem['item_id'],
                    'quantity' => $cartItem['quantity'],
                    'price' => $cartItem['price'],
                    'subtotal' => $cartItem['is_foc'] ? 0 : ($cartItem['price'] * $cartItem['quantity']),
                    'is_foc' => $cartItem['is_foc'],
                    'notes' => $cartItem['notes'],
                    'status' => 'served',
                ]);
            }
            
            // Process card payment
            if ($this->paymentMethod === 'card' && $this->card) {
                $this->card->deductBalance($this->total, $order->id, auth()->id());
            }
            
            // Process customer loyalty points
            if ($this->customer) {
                // Redeem points if requested
                if ($this->loyalty_points_to_redeem > 0) {
                    $this->customer->redeemPoints(
                        $this->loyalty_points_to_redeem,
                        $order,
                        'Redeemed for Order #' . $order->order_number
                    );
                }
                
                // Earn points from purchase (1 point per 1000 Ks)
                $pointsEarned = floor($this->total / 1000);
                if ($pointsEarned > 0) {
                    $this->customer->earnPoints(
                        $pointsEarned,
                        $order,
                        'Earned from Order #' . $order->order_number
                    );
                }
                
                // Update customer stats
                $this->customer->increment('total_spent', $this->total);
                $this->customer->increment('visit_count');
                $this->customer->update(['last_visit_at' => now()]);
            }

            DB::commit();

            // Store completed order ID and show success modal
            $this->completedOrderId = $order->id;
            $this->closePaymentModal();
            $this->showSuccessModal = true;
            
            // Reset form
            $this->resetForm();

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to process payment: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->cart = [];
        $this->selectedTable = null;
        $this->customerName = '';
        $this->customerPhone = '';
        $this->notes = '';
        $this->customer = null;
        $this->customer_id = null;
        $this->customer_search_phone = '';
        $this->loyalty_points_to_redeem = 0;
        $this->card = null;
        $this->card_number = '';
        $this->card_balance = 0;
        $this->taxPercentage = 0;
        $this->discountPercentage = 0;
        $this->discountAmount = 0;
        $this->serviceCharge = 0;
        $this->amountReceived = 0;
        $this->paymentMethod = 'cash';
        $this->calculateTotals();
        $this->loadAvailableTables();
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
        $cardSystemEnabled = Setting::get('card_system_enabled', false);
        
        return view('livewire.cashier.point-of-sale', [
            'cardSystemEnabled' => $cardSystemEnabled,
        ]);
    }
}
