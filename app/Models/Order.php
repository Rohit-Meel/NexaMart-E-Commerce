<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'address_id',
        'order_number',
        'subtotal',
        'discount',
        'shipping_charge',
        'tax',
        'total_amount',
        'coupon_code',
        'payment_method',
        'payment_status',
        'order_status',
        'customer_note',
        'placed_at',
    ];


    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_charge' => 'decimal:2',
        'tax' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'placed_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function address()
    {
        return $this->belongsTo(Address::class);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}