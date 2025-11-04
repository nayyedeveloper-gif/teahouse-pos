<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'ip_address',
        'port',
        'is_active',
        'paper_width',
    ];

    protected function casts(): array
    {
        return [
            'port' => 'integer',
            'is_active' => 'boolean',
            'paper_width' => 'integer',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeKitchen($query)
    {
        return $query->where('type', 'kitchen');
    }

    public function scopeBar($query)
    {
        return $query->where('type', 'bar');
    }

    public function scopeReceipt($query)
    {
        return $query->where('type', 'receipt');
    }
}
