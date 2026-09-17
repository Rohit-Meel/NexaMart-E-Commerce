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

        return view(
            'frontend.cart.index',
            compact('cartItems')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    |--------------------------------------------------------------------------
    */

    public function add(Request $request, $productId)
    {
        $customer = Auth::guard('customer')->user();

        $product = Product::where('status', true)
            ->findOrFail($productId);

        $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:' . $product->stock,
            ],
        ]);

        $quantity = (int) $request->quantity;

        $price = $product->sale_price !== null &&
                 $product->sale_price > 0
            ? $product->sale_price
            : $product->price;

        $cart = Cart::where('customer_id', $customer->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {

            $newQuantity = $cart->quantity + $quantity;

            if ($newQuantity > $product->stock) {

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only ' . $product->stock . ' items are available in stock.',
                    ], 422);
                }

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Only ' . $product->stock . ' items are available in stock.'
                    );
            }

            $cart->quantity = $newQuantity;
            $cart->price = $price;
            $cart->save();

        } else {

            $cart = Cart::create([
                'customer_id' => $customer->id,
                'product_id'  => $product->id,
                'quantity'    => $quantity,
                'price'       => $price,
            ]);
        }

        $cartCount = Cart::where(
            'customer_id',
            $customer->id
        )->sum('quantity');

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'message' => 'Product successfully added to cart!',
                'cart_count' => $cartCount,
                'quantity' => $cart->quantity,
            ]);
        }

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
    |
    | IMPORTANT:
    | Buy Now product CART TABLE me save nahi hota.
    | Product ID + selected quantity session me store hoti hai.
    |
    */

    public function buyNow(Request $request, $productId)
    {
        $product = Product::where('status', true)
            ->findOrFail($productId);

        $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:' . $product->stock,
            ],
        ]);

        $quantity = (int) $request->quantity;

        $price = $product->sale_price !== null &&
                 $product->sale_price > 0
            ? $product->sale_price
            : $product->price;

        /*
        |--------------------------------------------------------------------------
        | CLEAR OLD CHECKOUT STATE
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'checkout_mode',
            'checkout_product_id',
            'checkout_quantity',
            'checkout_price',
            'checkout_cart_ids',
        ]);

        /*
        |--------------------------------------------------------------------------
        | STORE BUY NOW PRODUCT IN SESSION ONLY
        |--------------------------------------------------------------------------
        */

        session([
            'checkout_mode' => 'buy_now',
            'checkout_product_id' => $product->id,
            'checkout_quantity' => $quantity,
            'checkout_price' => $price,
        ]);

        /*
        |--------------------------------------------------------------------------
        | AJAX RESPONSE
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'message' => 'Product ready for checkout.',
                'redirect' => route('checkout'),
            ]);
        }

        return redirect()
            ->route('checkout');
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

        $cart = Cart::with('product')
            ->where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        if (
            $cart->product &&
            $request->quantity > $cart->product->stock
        ) {
            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Only ' . $cart->product->stock . ' items are available in stock.'
                );
        }

        $cart->quantity = (int) $request->quantity;
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
