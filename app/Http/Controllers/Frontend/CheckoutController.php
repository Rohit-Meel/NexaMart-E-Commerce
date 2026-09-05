<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PREPARE CHECKOUT
    |--------------------------------------------------------------------------
    |
    | Cart page se selected products yahan aayenge.
    |
    */

    public function prepare(Request $request)
    {
        $customer = Customer::findOrFail(
            Auth::guard('customer')->id()
        );

        /*
        |--------------------------------------------------------------------------
        | VALIDATE SELECTED CART ITEMS
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'cart_items' => [
                'required',
                'array',
                'min:1',
            ],

            'cart_items.*' => [
                'required',
                'integer',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | CLEAN CART IDS
        |--------------------------------------------------------------------------
        */

        $cartIds = collect($request->cart_items)
            ->map(function ($id) {
                return (int) $id;
            })
            ->unique()
            ->values()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | ONLY CUSTOMER'S OWN CART ITEMS
        |--------------------------------------------------------------------------
        */

        $validCartIds = $customer->carts()
            ->whereIn('id', $cartIds)
            ->pluck('id')
            ->map(function ($id) {
                return (int) $id;
            })
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | SECURITY CHECK
        |--------------------------------------------------------------------------
        */

        if (empty($validCartIds)) {

            return redirect()
                ->route('cart')
                ->withErrors([
                    'cart' => 'Please select at least one valid product.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CLEAR OLD CHECKOUT SESSION
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'checkout_mode',
            'checkout_product_id',
            'checkout_cart_ids',
        ]);

        /*
        |--------------------------------------------------------------------------
        | STORE SELECTED CART ITEMS
        |--------------------------------------------------------------------------
        */

        session([
            'checkout_mode' => 'cart',
            'checkout_cart_ids' => $validCartIds,
        ]);

        /*
        |--------------------------------------------------------------------------
        | GO TO CHECKOUT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('checkout');
    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $customer = Customer::findOrFail(
            Auth::guard('customer')->id()
        );

        /*
        |--------------------------------------------------------------------------
        | GET CHECKOUT MODE
        |--------------------------------------------------------------------------
        */

        $checkoutMode = session('checkout_mode');


        /*
        |--------------------------------------------------------------------------
        | BUY NOW CHECKOUT
        |--------------------------------------------------------------------------
        */

        if ($checkoutMode === 'buy_now') {

            $productCartId = session('checkout_product_id');

            /*
            | If Buy Now cart ID is missing,
            | checkout cannot continue.
            */

            if (!$productCartId) {

                session()->forget([
                    'checkout_mode',
                    'checkout_product_id',
                    'checkout_cart_ids',
                ]);

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' => 'Please select a product before checkout.'
                    ]);
            }

            /*
            | Get ONLY the Buy Now cart item.
            */

            $cartItems = $customer->carts()
                ->with('product')
                ->where('id', $productCartId)
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL CART CHECKOUT
        |--------------------------------------------------------------------------
        */

        elseif ($checkoutMode === 'cart') {

            $cartIds = session(
                'checkout_cart_ids',
                []
            );

            /*
            | If no cart items were selected.
            */

            if (empty($cartIds)) {

                session()->forget([
                    'checkout_mode',
                    'checkout_product_id',
                    'checkout_cart_ids',
                ]);

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' => 'Please select products before checkout.'
                    ]);
            }

            /*
            | Get ONLY selected cart items.
            */

            $cartItems = $customer->carts()
                ->with('product')
                ->whereIn('id', $cartIds)
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | NO CHECKOUT MODE
        |--------------------------------------------------------------------------
        */

        else {

            $cartItems = collect();
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY CHECKOUT CHECK
        |--------------------------------------------------------------------------
        */

        if ($cartItems->isEmpty()) {

            session()->forget([
                'checkout_mode',
                'checkout_product_id',
                'checkout_cart_ids',
            ]);

            return redirect()
                ->route('cart')
                ->withErrors([
                    'cart' => 'Please select products before checkout.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CART CALCULATIONS
        |--------------------------------------------------------------------------
        */

        $subtotal = $cartItems->sum(function ($item) {

            return $item->price * $item->quantity;

        });

        $discount = 0;

        $shippingCharge = 0;

        $tax = 0;

        $totalAmount =
            $subtotal
            - $discount
            + $shippingCharge
            + $tax;


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER ADDRESSES
        |--------------------------------------------------------------------------
        */

        $addresses = $customer->addresses()
            ->orderByDesc('is_default')
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DEFAULT ADDRESS
        |--------------------------------------------------------------------------
        */

        $defaultAddress = $addresses
            ->where('is_default', true)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | CHECKOUT VIEW
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | checkoutMode bhi Blade ko pass kar rahe hain.
        |
        */

        return view(
            'frontend.checkout.index',
            compact(
                'customer',
                'cartItems',
                'addresses',
                'defaultAddress',
                'subtotal',
                'discount',
                'shippingCharge',
                'tax',
                'totalAmount',
                'checkoutMode'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PLACE ORDER
    |--------------------------------------------------------------------------
    */

    public function placeOrder(Request $request)
    {
        $customer = Customer::findOrFail(
            Auth::guard('customer')->id()
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'address' => [
                'required',
                'string',
                'max:500',
            ],

            'area' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'state' => [
                'required',
                'string',
                'max:100',
            ],

            'pincode' => [
                'required',
                'string',
                'max:10',
            ],

            'payment_method' => [
                'required',
                'in:cod,online',
            ],

            'customer_note' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | GET CHECKOUT MODE
        |--------------------------------------------------------------------------
        */

        $checkoutMode = session('checkout_mode');


        /*
        |--------------------------------------------------------------------------
        | BUY NOW ITEMS
        |--------------------------------------------------------------------------
        */

        if ($checkoutMode === 'buy_now') {

            $productCartId = session(
                'checkout_product_id'
            );

            if (!$productCartId) {

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' => 'Please select a product before placing the order.'
                    ]);
            }

            /*
            | Only Buy Now product.
            */

            $cartItems = $customer->carts()
                ->with('product')
                ->where('id', $productCartId)
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | SELECTED CART ITEMS
        |--------------------------------------------------------------------------
        */

        elseif ($checkoutMode === 'cart') {

            $cartIds = session(
                'checkout_cart_ids',
                []
            );

            if (empty($cartIds)) {

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' => 'Please select products before placing the order.'
                    ]);
            }

            /*
            | Only selected products.
            */

            $cartItems = $customer->carts()
                ->with('product')
                ->whereIn('id', $cartIds)
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | INVALID CHECKOUT MODE
        |--------------------------------------------------------------------------
        */

        else {

            $cartItems = collect();
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY CHECK
        |--------------------------------------------------------------------------
        */

        if ($cartItems->isEmpty()) {

            session()->forget([
                'checkout_mode',
                'checkout_product_id',
                'checkout_cart_ids',
            ]);

            return redirect()
                ->route('cart')
                ->withErrors([
                    'cart' => 'Please select products before placing the order.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CART CALCULATIONS
        |--------------------------------------------------------------------------
        */

        $subtotal = $cartItems->sum(function ($item) {

            return $item->price * $item->quantity;

        });

        $discount = 0;

        $shippingCharge = 0;

        $tax = 0;

        $totalAmount =
            $subtotal
            - $discount
            + $shippingCharge
            + $tax;


        /*
        |--------------------------------------------------------------------------
        | CREATE ORDER TRANSACTION
        |--------------------------------------------------------------------------
        */

        $orderNumber = DB::transaction(function () use (
            $customer,
            $cartItems,
            $validated,
            $subtotal,
            $discount,
            $shippingCharge,
            $tax,
            $totalAmount
        ) {

            /*
            |--------------------------------------------------------------------------
            | FULL CUSTOMER NAME
            |--------------------------------------------------------------------------
            */

            $fullName = trim(
                $validated['first_name']
                . ' '
                . $validated['last_name']
            );


            /*
            |--------------------------------------------------------------------------
            | MAKE PREVIOUS ADDRESSES NON DEFAULT
            |--------------------------------------------------------------------------
            */

            $customer->addresses()
                ->update([
                    'is_default' => false,
                ]);


            /*
            |--------------------------------------------------------------------------
            | SAVE NEW ADDRESS
            |--------------------------------------------------------------------------
            */

            $address = Address::create([

                'customer_id' => $customer->id,

                'address_type' => 'home',

                'full_name' => $fullName,

                'phone' => $validated['phone'],

                'address' => $validated['address'],

                'area' => $validated['area'] ?? null,

                'city' => $validated['city'],

                'state' => $validated['state'],

                'pincode' => $validated['pincode'],

                'is_default' => true,

            ]);


            /*
            |--------------------------------------------------------------------------
            | GENERATE UNIQUE ORDER NUMBER
            |--------------------------------------------------------------------------
            */

            do {

                $orderNumber =
                    'NEXA-'
                    . strtoupper(
                        Str::random(10)
                    );

            } while (
                DB::table('orders')
                    ->where(
                        'order_number',
                        $orderNumber
                    )
                    ->exists()
            );


            /*
            |--------------------------------------------------------------------------
            | PAYMENT STATUS
            |--------------------------------------------------------------------------
            */

            $paymentStatus = 'pending';


            /*
            |--------------------------------------------------------------------------
            | CREATE ORDER
            |--------------------------------------------------------------------------
            */

            $orderId = DB::table('orders')
                ->insertGetId([

                    'customer_id' =>
                        $customer->id,

                    'address_id' =>
                        $address->id,

                    'order_number' =>
                        $orderNumber,

                    'subtotal' =>
                        $subtotal,

                    'discount' =>
                        $discount,

                    'shipping_charge' =>
                        $shippingCharge,

                    'tax' =>
                        $tax,

                    'total_amount' =>
                        $totalAmount,

                    'coupon_code' =>
                        null,

                    'payment_method' =>
                        $validated['payment_method'],

                    'payment_status' =>
                        $paymentStatus,

                    'order_status' =>
                        'pending',

                    'customer_note' =>
                        $validated['customer_note'] ?? null,

                    'placed_at' =>
                        now(),

                    'created_at' =>
                        now(),

                    'updated_at' =>
                        now(),

                ]);


            /*
            |--------------------------------------------------------------------------
            | CREATE ORDER ITEMS
            |--------------------------------------------------------------------------
            */

            foreach ($cartItems as $cartItem) {

                $product =
                    $cartItem->product;


                /*
                | Product deleted / unavailable
                */

                if (!$product) {
                    continue;
                }


                $itemTotal =
                    $cartItem->price
                    * $cartItem->quantity;


                DB::table('order_items')
                    ->insert([

                        'order_id' =>
                            $orderId,

                        'product_id' =>
                            $cartItem->product_id,

                        'product_name' =>
                            $product->name,

                        'product_sku' =>
                            $product->sku ?? null,

                        'quantity' =>
                            $cartItem->quantity,

                        'price' =>
                            $cartItem->price,

                        'total' =>
                            $itemTotal,

                        'created_at' =>
                            now(),

                        'updated_at' =>
                            now(),

                    ]);
            }


            /*
            |--------------------------------------------------------------------------
            | DELETE ONLY ORDERED PRODUCTS FROM CART
            |--------------------------------------------------------------------------
            */

            $orderedCartIds =
                $cartItems
                    ->pluck('id')
                    ->toArray();


            $customer->carts()
                ->whereIn(
                    'id',
                    $orderedCartIds
                )
                ->delete();


            /*
            |--------------------------------------------------------------------------
            | RETURN ORDER NUMBER
            |--------------------------------------------------------------------------
            */

            return $orderNumber;
        });


        /*
        |--------------------------------------------------------------------------
        | CLEAR CHECKOUT SESSION
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'checkout_mode',
            'checkout_product_id',
            'checkout_cart_ids',
        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT AFTER ORDER
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('home')
            ->with(
                'success',
                'Order placed successfully! Your Order Number is '
                . $orderNumber
            );
    }
}