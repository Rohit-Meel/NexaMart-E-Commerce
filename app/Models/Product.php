<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'category_id',
        'sub_category_id',
        'brand_id',
        'vendor_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'sku',
        'thumbnail',
        'status',
        'featured',
    ];


    protected $casts = [

        'price' => 'decimal:2',

        'sale_price' => 'decimal:2',

        'stock' => 'integer',

        'status' => 'boolean',

        'featured' => 'boolean',

    ];


    /*
    |--------------------------------------------------------------------------
    | CATEGORY
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(
            Category::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SUB CATEGORY
    |--------------------------------------------------------------------------
    */

    public function subCategory()
    {
        return $this->belongsTo(
            SubCategory::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BRAND
    |--------------------------------------------------------------------------
    */

    public function brand()
    {
        return $this->belongsTo(
            Brand::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VENDOR
    |--------------------------------------------------------------------------
    */

    public function vendor()
    {
        return $this->belongsTo(
            Vendor::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCT IMAGES
    |--------------------------------------------------------------------------
    */

    public function images()
    {
        return $this->hasMany(
            ProductImage::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CARTS
    |--------------------------------------------------------------------------
    */

    public function carts()
    {
        return $this->hasMany(
            Cart::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | WISHLISTS
    |--------------------------------------------------------------------------
    */

    public function wishlists()
    {
        return $this->hasMany(
            Wishlist::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ORDER ITEMS
    |--------------------------------------------------------------------------
    */

    public function orderItems()
    {
        return $this->hasMany(
            OrderItem::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REVIEWS
    |--------------------------------------------------------------------------
    */

    public function reviews()
    {
        return $this->hasMany(
            Review::class
        );
    }
}