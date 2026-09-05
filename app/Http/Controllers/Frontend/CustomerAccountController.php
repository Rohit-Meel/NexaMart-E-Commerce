<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerAccountController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CUSTOMER ACCOUNT DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | GET LOGGED-IN CUSTOMER
        |--------------------------------------------------------------------------
        */

        /** @var Customer|null $customer */
        $customer = Auth::guard('customer')->user();


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER LOGIN CHECK
        |--------------------------------------------------------------------------
        */

        if (!$customer) {

            return redirect()
                ->route('login')
                ->with('error', 'Please login to access your account.');

        }


        /*
        |--------------------------------------------------------------------------
        | LOAD CUSTOMER RELATIONSHIPS
        |--------------------------------------------------------------------------
        */

        $customer->load([
            'addresses',

            'orders' => function ($query) {

                $query->latest();

            },

            'wishlists',

            'carts',
        ]);


        /*
        |--------------------------------------------------------------------------
        | ORDER COUNTS
        |--------------------------------------------------------------------------
        */

        $totalOrders = $customer->orders->count();


        $pendingOrders = $customer->orders
            ->whereIn('order_status', [
                'pending',
                'confirmed',
                'processing',
                'shipped',
            ])
            ->count();


        $deliveredOrders = $customer->orders
            ->where(
                'order_status',
                'delivered'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SPENT
        |--------------------------------------------------------------------------
        */

        $totalSpent = $customer->orders
            ->whereNotIn('order_status', [
                'cancelled',
            ])
            ->sum('total_amount');


        /*
        |--------------------------------------------------------------------------
        | WISHLIST COUNT
        |--------------------------------------------------------------------------
        */

        $wishlistCount = $customer->wishlists->count();


        /*
        |--------------------------------------------------------------------------
        | CART COUNT
        |--------------------------------------------------------------------------
        */

        $cartCount = $customer->carts->sum('quantity');


        /*
        |--------------------------------------------------------------------------
        | RECENT ORDERS
        |--------------------------------------------------------------------------
        */

        $recentOrders = $customer->orders
            ->take(5);


        /*
        |--------------------------------------------------------------------------
        | DEFAULT ADDRESS
        |--------------------------------------------------------------------------
        */

        $defaultAddress = $customer->addresses
            ->firstWhere(
                'is_default',
                true
            );


        /*
        |--------------------------------------------------------------------------
        | RETURN ACCOUNT DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.account.index',
            compact(
                'customer',
                'totalOrders',
                'pendingOrders',
                'deliveredOrders',
                'totalSpent',
                'wishlistCount',
                'cartCount',
                'recentOrders',
                'defaultAddress'
            )
        );
    }
}