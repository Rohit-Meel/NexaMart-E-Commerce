<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | OFFERS PAGE
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | OFFER PRODUCTS
        |--------------------------------------------------------------------------
        | Only active products having a valid sale price
        */

        $offerProducts = Product::query()

            ->where('status', true)

            ->whereNotNull('sale_price')

            ->whereColumn(
                'sale_price',
                '<',
                'price'
            )

            /*
            |--------------------------------------------------------------------------
            | CATEGORY FILTER
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->filled('category'),
                function ($query) use ($request) {

                    $query->whereHas(
                        'category',
                        function ($categoryQuery) use ($request) {

                            $categoryQuery->where(
                                'slug',
                                $request->category
                            );

                        }
                    );

                }
            )

            /*
            |--------------------------------------------------------------------------
            | RELATIONSHIPS
            |--------------------------------------------------------------------------
            */

            ->with([
                'category',
                'brand',
                'reviews',
                'vendor',
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
        | ACTIVE COUPONS
        |--------------------------------------------------------------------------
        */

        $now = now();

        $coupons = Coupon::query()

            ->where('status', true)

            ->where(function ($query) use ($now) {

                $query
                    ->whereNull('start_at')
                    ->orWhere(
                        'start_at',
                        '<=',
                        $now
                    );

            })

            ->where(function ($query) use ($now) {

                $query
                    ->whereNull('end_at')
                    ->orWhere(
                        'end_at',
                        '>=',
                        $now
                    );

            })

            ->where(function ($query) {

                $query
                    ->whereNull('usage_limit')
                    ->orWhereColumn(
                        'used_count',
                        '<',
                        'usage_limit'
                    );

            })

            ->latest()

            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.offers.index',
            compact(
                'offerProducts',
                'categories',
                'coupons'
            )
        );
    }
}