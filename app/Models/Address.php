<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'address_type',
        'full_name',
        'phone',
        'address',
        'area',
        'city',
        'state',
        'pincode',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Address belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Address can be used by many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}