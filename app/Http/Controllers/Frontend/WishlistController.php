<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | WISHLIST PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {

            return redirect()
                ->route('login')
                ->with(
                    'info',
                    'Please login to view your wishlist.'
                );
        }


        $wishlistItems = Wishlist::where(
            'customer_id',
            $customer->id
        )
            ->with([
                'product.category',
                'product.brand',
                'product.reviews'
            ])
            ->latest()
            ->get();


        return view(
            'frontend.wishlist.index',
            compact('wishlistItems')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD TO WISHLIST
    |--------------------------------------------------------------------------
    */

    public function add(Request $request, $productId)
    {
        $customer = Auth::guard('customer')->user();


        if (!$customer) {

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => 'Please login to add products to your wishlist.',
                ], 401);
            }


            return redirect()
                ->route('login')
                ->with(
                    'info',
                    'Please login to add products to your wishlist.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK PRODUCT
        |--------------------------------------------------------------------------
        */

        $product = Product::where(
            'status',
            true
        )->find($productId);


        if (!$product) {

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.',
                ], 404);
            }


            return back()
                ->with(
                    'error',
                    'Product not found.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK ALREADY EXISTS
        |--------------------------------------------------------------------------
        */

        $wishlistExists = Wishlist::where(
            'customer_id',
            $customer->id
        )
            ->where(
                'product_id',
                $product->id
            )
            ->exists();


        if ($wishlistExists) {

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => true,
                    'message' => 'Product is already in your wishlist.',
                    'already_added' => true,
                    'product_id' => $product->id,
                ]);
            }


            return back()
                ->with(
                    'info',
                    'Product is already in your wishlist.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE WISHLIST
        |--------------------------------------------------------------------------
        */

        $wishlist = new Wishlist();

        $wishlist->customer_id = $customer->id;

        $wishlist->product_id = $product->id;

        $wishlist->save();


        /*
        |--------------------------------------------------------------------------
        | AJAX RESPONSE
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully!',
                'product_id' => $product->id,
                'wishlist_count' => Wishlist::where(
                    'customer_id',
                    $customer->id
                )->count(),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL RESPONSE
        |--------------------------------------------------------------------------
        */

        return back()
            ->with(
                'success',
                'Product added to wishlist successfully!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE FROM WISHLIST
    |--------------------------------------------------------------------------
    */

    public function remove(Request $request, $productId)
    {
        $customer = Auth::guard('customer')->user();


        if (!$customer) {

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => 'Please login first.',
                ], 401);
            }


            return redirect()
                ->route('login')
                ->with(
                    'info',
                    'Please login first.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE WISHLIST ITEM
        |--------------------------------------------------------------------------
        */

        $deleted = Wishlist::where(
            'customer_id',
            $customer->id
        )
            ->where(
                'product_id',
                $productId
            )
            ->delete();


        if (!$deleted) {

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => 'Wishlist item not found.',
                ], 404);
            }


            return back()
                ->with(
                    'error',
                    'Wishlist item not found.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | AJAX RESPONSE
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist.',
                'product_id' => (int) $productId,
                'wishlist_count' => Wishlist::where(
                    'customer_id',
                    $customer->id
                )->count(),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL RESPONSE
        |--------------------------------------------------------------------------
        */

        return back()
            ->with(
                'success',
                'Product removed from wishlist.'
            );
    }
}