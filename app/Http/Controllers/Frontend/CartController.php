<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CART PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $cartItems = Cart::with([
            'product.category'
        ])
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('frontend.cart.index', compact('cartItems'));
    }


    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    |--------------------------------------------------------------------------
    */

    public function add(Request $request, $productId)
    {
        $customer = Auth::guard('customer')->user();

        $product = Product::findOrFail($productId);

        $price = $product->sale_price &&
                 $product->sale_price > 0
            ? $product->sale_price
            : $product->price;


        $cart = Cart::where('customer_id', $customer->id)
            ->where('product_id', $product->id)
            ->first();


        if ($cart) {

            $cart->quantity += 1;
            $cart->price = $price;
            $cart->save();

        } else {

            $cart = Cart::create([
                'customer_id' => $customer->id,
                'product_id'  => $product->id,
                'quantity'    => 1,
                'price'       => $price,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | AJAX RESPONSE
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'message' => 'Product successfully added to cart!',
                'cart_count' => Cart::where(
                    'customer_id',
                    $customer->id
                )->sum('quantity'),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL REQUEST
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->back()
            ->with(
                'success',
                'Product successfully added to cart!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | BUY NOW
    |--------------------------------------------------------------------------
    */

    public function buyNow(Request $request, $productId)
    {
        $customer = Auth::guard('customer')->user();

        $product = Product::findOrFail($productId);

        $price = $product->sale_price &&
                 $product->sale_price > 0
            ? $product->sale_price
            : $product->price;


        /*
        |--------------------------------------------------------------------------
        | If Product Already Exists In Cart
        |--------------------------------------------------------------------------
        */

        $cart = Cart::where('customer_id', $customer->id)
            ->where('product_id', $product->id)
            ->first();


        if ($cart) {

            $cart->quantity = 1;
            $cart->price = $price;
            $cart->save();

        } else {

            $cart = Cart::create([
                'customer_id' => $customer->id,
                'product_id'  => $product->id,
                'quantity'    => 1,
                'price'       => $price,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Clear Previous Checkout State
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'checkout_mode',
            'checkout_product_id',
            'checkout_cart_ids',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Store Buy Now Product
        |--------------------------------------------------------------------------
        */

        session([
            'checkout_mode' => 'buy_now',
            'checkout_product_id' => $cart->id,
        ]);


        return redirect()
            ->route('checkout')
            ->with(
                'success',
                'Product ready for checkout.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE CART QUANTITY
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);


        $cart = Cart::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();


        $cart->quantity = $request->quantity;

        $cart->save();


        return redirect()
            ->route('cart')
            ->with(
                'success',
                'Cart quantity updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE CART ITEM
    |--------------------------------------------------------------------------
    */

    public function remove($id)
    {
        $customer = Auth::guard('customer')->user();


        $cart = Cart::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();


        $cart->delete();


        return redirect()
            ->route('cart')
            ->with(
                'success',
                'Product removed from cart.'
            );
    }
}