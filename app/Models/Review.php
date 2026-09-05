<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'order_id',
        'rating',
        'comment',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
        'status' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Review belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Review belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Review can belong to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}