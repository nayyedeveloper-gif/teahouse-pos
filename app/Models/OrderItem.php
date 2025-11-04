<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
        'foc_quantity',
        'price',
        'subtotal',
        'is_foc',
        'notes',
        'status',
        'is_printed',
        'printed_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'foc_quantity' => 'integer',
            'price' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'is_foc' => 'boolean',
            'is_printed' => 'boolean',
            'printed_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($orderItem) {
            // Calculate subtotal based on chargeable quantity (quantity - foc_quantity)
            $focQuantity = $orderItem->foc_quantity ?? 0;
            $chargeableQuantity = $orderItem->quantity - $focQuantity;
            $orderItem->subtotal = $chargeableQuantity * $orderItem->price;
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function scopeUnprinted($query)
    {
        return $query->where('is_printed', false);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
