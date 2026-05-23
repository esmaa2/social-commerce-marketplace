<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'unit',
        'price',
        'quantity',
    ];

    // Casts
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Relationship: OrderItem belongs to an Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship: OrderItem belongs to a Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate total for this item
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}