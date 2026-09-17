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

                $query->whereHas(
                    'products.category',
                    function ($categoryQuery) use ($categorySlug) {

                        $categoryQuery->where(
                            'slug',
                            $categorySlug
                        );

                    }
                );

            })

            /*
            | Load only active products with category
            */

            ->with([
                'products' => function ($query) {

                    $query->where('status', true)
                        ->with('category');

                }
            ])

            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ALL CATEGORIES
        |--------------------------------------------------------------------------
        |
        | These categories are used on the main Shops page
        | for filtering/searching shops.
        |
        */

        $categories = Category::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN SHOP INDEX
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

            /*
            | Load only active products
            */

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
        |
        | Only this particular shop's active products.
        |
        */

        $products = $shop->products;


        /*
        |--------------------------------------------------------------------------
        | SHOP CATEGORIES
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Categories are taken ONLY from this shop's products.
        |
        */

        $shopCategories = $products
            ->filter(function ($product) {

                return $product->category !== null;

            })
            ->pluck('category')
            ->unique('id')
            ->sortBy('name')
            ->values();


        /*
        |--------------------------------------------------------------------------
        | RETURN SHOP DETAIL
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