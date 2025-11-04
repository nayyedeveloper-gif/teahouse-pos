<?php

namespace App\Livewire\Waiter;

use App\Models\Table;
use Livewire\Component;

class TablesList extends Component
{
    public $tables;
    public $search = '';

    public function mount()
    {
        $this->loadTables();
    }

    public function loadTables()
    {
        $this->tables = Table::active()
            ->withCount(['orders as active_orders_count' => function ($query) {
                $query->where('status', 'pending');
            }])
            ->with(['orders' => function ($query) {
                $query->where('status', 'pending')
                      ->latest()
                      ->limit(1);
            }])
            ->ordered()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('name_mm', 'like', '%' . $this->search . '%');
            })
            ->get();
    }

    public function updatedSearch()
    {
        $this->loadTables();
    }

    public function selectTable($tableId)
    {
        return redirect()->route('waiter.orders.create', ['table' => $tableId]);
    }

    public function render()
    {
        return view('livewire.waiter.tables-list');
    }
}
