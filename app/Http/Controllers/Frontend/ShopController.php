<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOP INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | SHOP QUERY
        |--------------------------------------------------------------------------
        */

        $shops = Vendor::query()
            ->where('status', true)

            /*
            | Search by shop name
            */

            ->when($request->filled('search'), function ($query) use ($request) {

                $search = $request->search;

                $query->where(
                    'shop_name',
                    'like',
                    '%' . $search . '%'
                );

            })

            /*
            | Filter shops according to product category
            */

            ->when($request->filled('category'), function ($query) use ($request) {

                $categorySlug = $request->category;

                $query->whereHas('products.category', function ($categoryQuery) use ($categorySlug) {

                    $categoryQuery->where(
                        'slug',
                        $categorySlug
                    );

                });

            })

            /*
            | Load products and their categories
            */

            ->with([
                'products.category'
            ])

            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories = Category::query()
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN SHOP PAGE
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.shops.index',
            compact(
                'shops',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOP DETAIL
    |--------------------------------------------------------------------------
    */

    public function show($shop_slug)
    {
        /*
        |--------------------------------------------------------------------------
        | FIND SHOP
        |--------------------------------------------------------------------------
        */

        $shop = Vendor::query()
            ->where('shop_slug', $shop_slug)
            ->where('status', true)
            ->with([
                'products' => function ($query) {

                    $query->where('status', true)
                        ->with([
                            'category',
                            'brand',
                            'images'
                        ])
                        ->withCount('reviews');

                }
            ])
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | SHOP PRODUCTS
        |--------------------------------------------------------------------------
        */

        $products = $shop->products;


        /*
        |--------------------------------------------------------------------------
        | SHOP CATEGORIES
        |--------------------------------------------------------------------------
        */

        $shopCategories = $products
            ->pluck('category')
            ->filter()
            ->unique('id')
            ->values();


        /*
        |--------------------------------------------------------------------------
        | RETURN SHOP DETAIL PAGE
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.shops.show',
            compact(
                'shop',
                'products',
                'shopCategories'
            )
        );
    }
}