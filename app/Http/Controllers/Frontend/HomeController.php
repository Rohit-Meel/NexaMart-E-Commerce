<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | ACTIVE BANNERS
        |--------------------------------------------------------------------------
        */

        $banners = Banner::query()
            ->where('status', true)

            ->where(function ($query) {
                $query->whereNull('start_at')
                    ->orWhere('start_at', '<=', now());
            })

            ->where(function ($query) {
                $query->whereNull('end_at')
                    ->orWhere('end_at', '>=', now());
            })

            ->orderBy('sort_order', 'asc')
            ->orderByDesc('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | FEATURED PRODUCTS
        |--------------------------------------------------------------------------
        */

        $featuredProducts = Product::with([
                'category',
                'brand'
            ])
            ->withCount('reviews')
            ->where('status', true)
            ->where('featured', true)
            ->latest()
            ->take(4)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | LATEST PRODUCTS
        |--------------------------------------------------------------------------
        */

        $latestProducts = Product::with([
                'category',
                'brand'
            ])
            ->withCount('reviews')
            ->where('status', true)
            ->latest()
            ->take(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | BRANDS
        |--------------------------------------------------------------------------
        */

        $brands = Brand::where('status', true)
            ->latest()
            ->take(6)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories = Category::where('status', true)
            ->latest()
            ->take(6)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER WISHLIST
        |--------------------------------------------------------------------------
        */

        $wishlistProductIds = collect();

        $customer = Auth::guard('customer')->user();

        if ($customer) {

            $wishlistProductIds = Wishlist::where(
                    'customer_id',
                    $customer->id
                )
                ->pluck('product_id');
        }


        /*
        |--------------------------------------------------------------------------
        | HOME VIEW
        |--------------------------------------------------------------------------
        */

        return view('frontend.home.index', compact(
            'banners',
            'featuredProducts',
            'latestProducts',
            'brands',
            'categories',
            'wishlistProductIds'
        ));
    }
}