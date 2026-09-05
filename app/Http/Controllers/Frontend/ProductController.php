<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */

        $query = Product::with([
                'category',
                'brand',
                'reviews'
            ])
            ->where('status', true);


        /*
        |--------------------------------------------------------------------------
        | SINGLE CATEGORY FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $query->whereHas('category', function ($q) use ($request) {

                $q->where(
                    'slug',
                    $request->category
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY SIDEBAR FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('categories')) {

            $categories = (array) $request->categories;

            $query->whereHas('category', function ($q) use ($categories) {

                $q->whereIn(
                    'slug',
                    $categories
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | BRAND FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('brand')) {

            $query->whereHas('brand', function ($q) use ($request) {

                $q->where(
                    'slug',
                    $request->brand
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | MULTIPLE BRAND FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('brands')) {

            $brands = (array) $request->brands;

            $query->whereHas('brand', function ($q) use ($brands) {

                $q->whereIn(
                    'slug',
                    $brands
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | PRICE FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('min_price')) {

            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        if ($request->filled('max_price')) {

            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RATING FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('rating')) {

            $rating = (int) $request->rating;

            $query->whereHas('reviews', function ($q) use ($rating) {

                $q->select('product_id')
                    ->groupBy('product_id')
                    ->havingRaw(
                        'AVG(rating) >= ?',
                        [$rating]
                    );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */

        switch ($request->sort) {

            case 'price-low':

                $query->orderBy(
                    'price',
                    'asc'
                );

                break;


            case 'price-high':

                $query->orderBy(
                    'price',
                    'desc'
                );

                break;


            case 'rating':

                $query->withAvg(
                    'reviews',
                    'rating'
                )
                ->orderByDesc(
                    'reviews_avg_rating'
                );

                break;


            default:

                $query->latest();

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */

        $products = $query
            ->paginate(12)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories = Category::where(
                'status',
                true
            )
            ->withCount([
                'products' => function ($query) {

                    $query->where(
                        'status',
                        true
                    );

                }
            ])
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | BRANDS
        |--------------------------------------------------------------------------
        */

        $brands = Brand::where(
                'status',
                true
            )
            ->withCount([
                'products' => function ($query) {

                    $query->where(
                        'status',
                        true
                    );

                }
            ])
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.products.index',
            compact(
                'products',
                'categories',
                'brands'
            )
        );
    }
}