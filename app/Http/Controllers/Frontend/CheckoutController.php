<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CHECKOUT SESSION KEYS
    |--------------------------------------------------------------------------
    */

    private function clearCheckoutSession(): void
    {
        session()->forget([
            'checkout_mode',
            'checkout_product_id',
            'checkout_quantity',
            'checkout_price',
            'checkout_cart_ids',
            'checkout_coupon_code',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATE & CALCULATE COUPON
    |--------------------------------------------------------------------------
    */

    private function calculateCouponDiscount(
        string $couponCode,
        float $subtotal
    ): array {

        $now = now();

        $coupon = Coupon::query()
            ->whereRaw(
                'UPPER(code) = ?',
                [strtoupper(trim($couponCode))]
            )
            ->where('status', true)

            ->where(function ($query) use ($now) {
                $query
                    ->whereNull('start_at')
                    ->orWhere('start_at', '<=', $now);
            })

            ->where(function ($query) use ($now) {
                $query
                    ->whereNull('end_at')
                    ->orWhere('end_at', '>=', $now);
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

            ->first();

        if (!$coupon) {
            return [
                'success' => false,
                'message' =>
                    'Invalid, expired, or unavailable coupon code.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | MINIMUM ORDER AMOUNT
        |--------------------------------------------------------------------------
        */

        if (
            $subtotal <
            (float) $coupon->minimum_order_amount
        ) {

            return [
                'success' => false,
                'message' =>
                    'Minimum order amount for this coupon is ₹'
                    . number_format(
                        (float) $coupon->minimum_order_amount,
                        2
                    )
                    . '.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | CALCULATE DISCOUNT
        |--------------------------------------------------------------------------
        */

        if ($coupon->discount_type === 'percentage') {

            $discount =
                (
                    $subtotal *
                    (float) $coupon->discount_value
                ) / 100;

        } else {

            $discount =
                (float) $coupon->discount_value;
        }


        /*
        |--------------------------------------------------------------------------
        | MAXIMUM DISCOUNT
        |--------------------------------------------------------------------------
        */

        if (
            $coupon->maximum_discount !== null &&
            $discount >
            (float) $coupon->maximum_discount
        ) {

            $discount =
                (float) $coupon->maximum_discount;
        }


        /*
        |--------------------------------------------------------------------------
        | DISCOUNT CANNOT EXCEED SUBTOTAL
        |--------------------------------------------------------------------------
        */

        $discount = min(
            $discount,
            $subtotal
        );

        $discount = round(
            $discount,
            2
        );


        return [
            'success' => true,
            'coupon' => $coupon,
            'discount' => $discount,
            'code' => $coupon->code,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | GET CHECKOUT SUBTOTAL
    |--------------------------------------------------------------------------
    */

    private function getCheckoutSubtotal(
        Customer $customer
    ): array {

        $checkoutMode =
            session('checkout_mode');


        /*
        |--------------------------------------------------------------------------
        | BUY NOW
        |--------------------------------------------------------------------------
        */

        if ($checkoutMode === 'buy_now') {

            $productId =
                (int) session(
                    'checkout_product_id'
                );

            $quantity =
                (int) session(
                    'checkout_quantity',
                    1
                );


            if (!$productId) {

                return [
                    'success' => false,
                    'message' =>
                        'Please select a product before checkout.',
                ];
            }


            $product = Product::where(
                'status',
                true
            )->find($productId);


            if (!$product) {

                return [
                    'success' => false,
                    'message' =>
                        'The selected product is no longer available.',
                ];
            }


            if (
                $quantity < 1 ||
                $quantity > $product->stock
            ) {

                return [
                    'success' => false,
                    'message' =>
                        'Selected quantity is no longer available.',
                ];
            }


            $price =
                $product->sale_price !== null &&
                $product->sale_price > 0
                    ? $product->sale_price
                    : $product->price;


            $subtotal =
                (float) $price *
                $quantity;


            return [
                'success' => true,
                'subtotal' => $subtotal,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | CART CHECKOUT
        |--------------------------------------------------------------------------
        */

        if ($checkoutMode === 'cart') {

            $cartIds = session(
                'checkout_cart_ids',
                []
            );


            if (empty($cartIds)) {

                return [
                    'success' => false,
                    'message' =>
                        'Please select products before checkout.',
                ];
            }


            $cartItems = $customer->carts()
                ->with('product')
                ->whereIn(
                    'id',
                    $cartIds
                )
                ->get();


            if ($cartItems->isEmpty()) {

                return [
                    'success' => false,
                    'message' =>
                        'Selected cart products are no longer available.',
                ];
            }


            foreach ($cartItems as $item) {

                if (!$item->product) {

                    return [
                        'success' => false,
                        'message' =>
                            'One of the selected products is no longer available.',
                    ];
                }


                if (
                    $item->quantity >
                    $item->product->stock
                ) {

                    return [
                        'success' => false,
                        'message' =>
                            'Only '
                            . $item->product->stock
                            . ' items are available for '
                            . $item->product->name
                            . '.',
                    ];
                }
            }


            $subtotal =
                $cartItems->sum(
                    function ($item) {

                        return
                            (float) $item->price *
                            (int) $item->quantity;
                    }
                );


            return [
                'success' => true,
                'subtotal' => $subtotal,
            ];
        }


        return [
            'success' => false,
            'message' =>
                'Checkout session is not available.',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | PREPARE CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function prepare(Request $request)
    {
        $customer = Customer::findOrFail(
            Auth::guard('customer')->id()
        );


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


        $cartIds = collect(
            $request->cart_items
        )
            ->map(function ($id) {
                return (int) $id;
            })
            ->unique()
            ->values()
            ->toArray();


        $validCartIds = $customer->carts()
            ->whereIn(
                'id',
                $cartIds
            )
            ->pluck('id')
            ->map(function ($id) {
                return (int) $id;
            })
            ->toArray();


        if (empty($validCartIds)) {

            return redirect()
                ->route('cart')
                ->withErrors([
                    'cart' =>
                        'Please select at least one valid product.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | RESET PREVIOUS CHECKOUT
        |--------------------------------------------------------------------------
        */

        $this->clearCheckoutSession();


        session([
            'checkout_mode' =>
                'cart',

            'checkout_cart_ids' =>
                $validCartIds,
        ]);


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


        $checkoutMode =
            session('checkout_mode');


        /*
        |--------------------------------------------------------------------------
        | BUY NOW CHECKOUT
        |--------------------------------------------------------------------------
        */

        if ($checkoutMode === 'buy_now') {

            $productId =
                (int) session(
                    'checkout_product_id'
                );

            $quantity =
                (int) session(
                    'checkout_quantity',
                    1
                );


            if (!$productId) {

                $this->clearCheckoutSession();

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' =>
                            'Please select a product before checkout.',
                    ]);
            }


            $product = Product::where(
                'status',
                true
            )->find($productId);


            if (!$product) {

                $this->clearCheckoutSession();

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' =>
                            'The selected product is no longer available.',
                    ]);
            }


            if (
                $quantity < 1 ||
                $quantity > $product->stock
            ) {

                $this->clearCheckoutSession();

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' =>
                            'Selected quantity is no longer available.',
                    ]);
            }


            $price =
                $product->sale_price !== null &&
                $product->sale_price > 0
                    ? $product->sale_price
                    : $product->price;


            /*
            |--------------------------------------------------------------------------
            | TEMPORARY CART-LIKE ITEM
            |--------------------------------------------------------------------------
            */

            $buyNowItem = new Cart([
                'product_id' =>
                    $product->id,

                'quantity' =>
                    $quantity,

                'price' =>
                    $price,
            ]);


            $buyNowItem->id = null;


            $buyNowItem->setRelation(
                'product',
                $product
            );


            $cartItems = collect([
                $buyNowItem,
            ]);
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


            if (empty($cartIds)) {

                $this->clearCheckoutSession();

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' =>
                            'Please select products before checkout.',
                    ]);
            }


            $cartItems = $customer->carts()
                ->with('product')
                ->whereIn(
                    'id',
                    $cartIds
                )
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

            $this->clearCheckoutSession();

            return redirect()
                ->route('cart')
                ->withErrors([
                    'cart' =>
                        'Please select products before checkout.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | STOCK CHECK
        |--------------------------------------------------------------------------
        */

        foreach ($cartItems as $item) {

            if (
                $item->product &&
                $item->quantity >
                $item->product->stock
            ) {

                $this->clearCheckoutSession();

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' =>
                            'Only '
                            . $item->product->stock
                            . ' items are available for '
                            . $item->product->name
                            . '.',
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SUBTOTAL
        |--------------------------------------------------------------------------
        */

        $subtotal =
            $cartItems->sum(
                function ($item) {

                    return
                        (float) $item->price *
                        (int) $item->quantity;
                }
            );


        /*
        |--------------------------------------------------------------------------
        | COUPON
        |--------------------------------------------------------------------------
        */

        $couponCode =
            session('checkout_coupon_code');


        $discount = 0;

        $coupon = null;


        if ($couponCode) {

            $couponResult =
                $this->calculateCouponDiscount(
                    $couponCode,
                    (float) $subtotal
                );


            if ($couponResult['success']) {

                $discount =
                    $couponResult['discount'];

                $coupon =
                    $couponResult['coupon'];
            }

            else {

                session()->forget(
                    'checkout_coupon_code'
                );

                $couponCode = null;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SHIPPING / TAX
        |--------------------------------------------------------------------------
        */

        $shippingCharge = 0;

        $tax = 0;


        /*
        |--------------------------------------------------------------------------
        | FINAL TOTAL
        |--------------------------------------------------------------------------
        */

        $totalAmount =
            $subtotal
            - $discount
            + $shippingCharge
            + $tax;


        /*
        |--------------------------------------------------------------------------
        | AVAILABLE COUPONS
        |--------------------------------------------------------------------------
        */

        $now = now();


        $availableCoupons = Coupon::query()

            ->where(
                'status',
                true
            )

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
        | CUSTOMER ADDRESSES
        |--------------------------------------------------------------------------
        */

        $addresses =
            $customer->addresses()
                ->orderByDesc('is_default')
                ->latest()
                ->get();


        $defaultAddress =
            $addresses
                ->where(
                    'is_default',
                    true
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | CHECKOUT VIEW
        |--------------------------------------------------------------------------
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
                'checkoutMode',
                'coupon',
                'couponCode',
                'availableCoupons'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | APPLY COUPON
    |--------------------------------------------------------------------------
    */

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => [
                'required',
                'string',
                'max:50',
            ],
        ]);


        $customer = Customer::findOrFail(
            Auth::guard('customer')->id()
        );


        /*
        |--------------------------------------------------------------------------
        | GET CURRENT CHECKOUT SUBTOTAL
        |--------------------------------------------------------------------------
        */

        $checkoutData =
            $this->getCheckoutSubtotal(
                $customer
            );


        if (!$checkoutData['success']) {

            return response()->json([
                'success' => false,
                'message' =>
                    $checkoutData['message'],
            ], 422);
        }


        $subtotal =
            (float) $checkoutData['subtotal'];


        /*
        |--------------------------------------------------------------------------
        | VALIDATE COUPON
        |--------------------------------------------------------------------------
        */

        $couponResult =
            $this->calculateCouponDiscount(
                $request->coupon_code,
                $subtotal
            );


        if (!$couponResult['success']) {

            return response()->json([
                'success' => false,
                'message' =>
                    $couponResult['message'],
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE COUPON IN SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'checkout_coupon_code' =>
                $couponResult['code'],
        ]);


        $discount =
            (float) $couponResult['discount'];


        $shippingCharge = 0;

        $tax = 0;


        $totalAmount =
            $subtotal
            - $discount
            + $shippingCharge
            + $tax;


        return response()->json([
            'success' => true,

            'message' =>
                'Coupon applied successfully!',

            'coupon_code' =>
                $couponResult['code'],

            'discount' =>
                number_format(
                    $discount,
                    2,
                    '.',
                    ''
                ),

            'subtotal' =>
                number_format(
                    $subtotal,
                    2,
                    '.',
                    ''
                ),

            'total_amount' =>
                number_format(
                    $totalAmount,
                    2,
                    '.',
                    ''
                ),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE COUPON
    |--------------------------------------------------------------------------
    */

    public function removeCoupon()
    {
        session()->forget(
            'checkout_coupon_code'
        );


        $customer = Customer::findOrFail(
            Auth::guard('customer')->id()
        );


        /*
        |--------------------------------------------------------------------------
        | GET CURRENT CHECKOUT SUBTOTAL
        |--------------------------------------------------------------------------
        */

        $checkoutData =
            $this->getCheckoutSubtotal(
                $customer
            );


        if (!$checkoutData['success']) {

            return response()->json([
                'success' => false,
                'message' =>
                    $checkoutData['message'],
            ], 422);
        }


        $subtotal =
            (float) $checkoutData['subtotal'];


        $discount = 0;

        $shippingCharge = 0;

        $tax = 0;


        $totalAmount =
            $subtotal
            - $discount
            + $shippingCharge
            + $tax;


        return response()->json([
            'success' => true,

            'message' =>
                'Coupon removed successfully.',

            'coupon_code' =>
                null,

            'discount' =>
                number_format(
                    $discount,
                    2,
                    '.',
                    ''
                ),

            'subtotal' =>
                number_format(
                    $subtotal,
                    2,
                    '.',
                    ''
                ),

            'total_amount' =>
                number_format(
                    $totalAmount,
                    2,
                    '.',
                    ''
                ),
        ]);
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

        $checkoutMode =
            session('checkout_mode');


        /*
        |--------------------------------------------------------------------------
        | BUY NOW
        |--------------------------------------------------------------------------
        */

        if ($checkoutMode === 'buy_now') {

            $productId =
                (int) session(
                    'checkout_product_id'
                );

            $quantity =
                (int) session(
                    'checkout_quantity',
                    1
                );


            if (
                !$productId ||
                $quantity < 1
            ) {

                $this->clearCheckoutSession();

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' =>
                            'Please select a product before placing the order.',
                    ]);
            }


            $product = Product::where(
                'status',
                true
            )->find($productId);


            if (!$product) {

                $this->clearCheckoutSession();

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' =>
                            'The selected product is no longer available.',
                    ]);
            }


            if (
                $quantity >
                $product->stock
            ) {

                return redirect()
                    ->route('checkout')
                    ->withErrors([
                        'cart' =>
                            'Only '
                            . $product->stock
                            . ' items are available for '
                            . $product->name
                            . '.',
                    ]);
            }


            $price =
                $product->sale_price !== null &&
                $product->sale_price > 0
                    ? $product->sale_price
                    : $product->price;


            $buyNowItem = new Cart([
                'product_id' =>
                    $product->id,

                'quantity' =>
                    $quantity,

                'price' =>
                    $price,
            ]);


            $buyNowItem->id = null;


            $buyNowItem->setRelation(
                'product',
                $product
            );


            $cartItems = collect([
                $buyNowItem,
            ]);
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


            if (empty($cartIds)) {

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' =>
                            'Please select products before placing the order.',
                    ]);
            }


            $cartItems = $customer->carts()
                ->with('product')
                ->whereIn(
                    'id',
                    $cartIds
                )
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

            $this->clearCheckoutSession();

            return redirect()
                ->route('cart')
                ->withErrors([
                    'cart' =>
                        'Please select products before placing the order.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | FINAL STOCK CHECK
        |--------------------------------------------------------------------------
        */

        foreach ($cartItems as $item) {

            if (!$item->product) {

                return redirect()
                    ->route('cart')
                    ->withErrors([
                        'cart' =>
                            'One of the selected products is no longer available.',
                    ]);
            }


            if (
                $item->quantity >
                $item->product->stock
            ) {

                return redirect()
                    ->route('checkout')
                    ->withErrors([
                        'cart' =>
                            'Only '
                            . $item->product->stock
                            . ' items are available for '
                            . $item->product->name
                            . '.',
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SUBTOTAL
        |--------------------------------------------------------------------------
        */

        $subtotal =
            $cartItems->sum(
                function ($item) {

                    return
                        (float) $item->price *
                        (int) $item->quantity;
                }
            );


        /*
        |--------------------------------------------------------------------------
        | COUPON REVALIDATION
        |--------------------------------------------------------------------------
        */

        $couponCode =
            session('checkout_coupon_code');


        $discount = 0;


        if ($couponCode) {

            $couponResult =
                $this->calculateCouponDiscount(
                    $couponCode,
                    (float) $subtotal
                );


            if (!$couponResult['success']) {

                session()->forget(
                    'checkout_coupon_code'
                );


                return redirect()
                    ->route('checkout')
                    ->withErrors([
                        'coupon' =>
                            $couponResult['message'],
                    ]);
            }


            $discount =
                (float) $couponResult['discount'];
        }


        /*
        |--------------------------------------------------------------------------
        | SHIPPING / TAX
        |--------------------------------------------------------------------------
        */

        $shippingCharge = 0;

        $tax = 0;


        /*
        |--------------------------------------------------------------------------
        | FINAL TOTAL
        |--------------------------------------------------------------------------
        */

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

        try {

            $orderNumber = DB::transaction(
                function () use (
                    $customer,
                    $cartItems,
                    $validated,
                    $subtotal,
                    $shippingCharge,
                    $tax,
                    $checkoutMode,
                    $couponCode
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | LOCK & REVALIDATE COUPON
                    |--------------------------------------------------------------------------
                    */

                    $coupon = null;

                    $discount = 0;


                    if ($couponCode) {

                        $coupon = Coupon::query()
                            ->whereRaw(
                                'UPPER(code) = ?',
                                [
                                    strtoupper(
                                        trim($couponCode)
                                    ),
                                ]
                            )
                            ->where(
                                'status',
                                true
                            )
                            ->lockForUpdate()
                            ->first();


                        if (!$coupon) {

                            throw new \RuntimeException(
                                'The selected coupon is no longer available.'
                            );
                        }


                        $now = now();


                        if (
                            $coupon->start_at !== null &&
                            $coupon->start_at > $now
                        ) {

                            throw new \RuntimeException(
                                'This coupon is not active yet.'
                            );
                        }


                        if (
                            $coupon->end_at !== null &&
                            $coupon->end_at < $now
                        ) {

                            throw new \RuntimeException(
                                'This coupon has expired.'
                            );
                        }


                        if (
                            $coupon->usage_limit !== null &&
                            $coupon->used_count >=
                            $coupon->usage_limit
                        ) {

                            throw new \RuntimeException(
                                'This coupon is no longer available.'
                            );
                        }


                        if (
                            $subtotal <
                            (float)
                            $coupon->minimum_order_amount
                        ) {

                            throw new \RuntimeException(
                                'Minimum order amount for this coupon is ₹'
                                . number_format(
                                    (float)
                                    $coupon->minimum_order_amount,
                                    2
                                )
                                . '.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | RECALCULATE DISCOUNT FROM LOCKED COUPON
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $coupon->discount_type ===
                            'percentage'
                        ) {

                            $discount =
                                (
                                    $subtotal *
                                    (float)
                                    $coupon->discount_value
                                ) / 100;

                        } else {

                            $discount =
                                (float)
                                $coupon->discount_value;
                        }


                        if (
                            $coupon->maximum_discount !== null &&
                            $discount >
                            (float)
                            $coupon->maximum_discount
                        ) {

                            $discount =
                                (float)
                                $coupon->maximum_discount;
                        }


                        $discount = min(
                            $discount,
                            $subtotal
                        );


                        $discount = round(
                            $discount,
                            2
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | FINAL TOTAL
                    |--------------------------------------------------------------------------
                    */

                    $totalAmount =
                        $subtotal
                        - $discount
                        + $shippingCharge
                        + $tax;


                    /*
                    |--------------------------------------------------------------------------
                    | FULL NAME
                    |--------------------------------------------------------------------------
                    */

                    $fullName = trim(
                        $validated['first_name']
                        . ' '
                        . $validated['last_name']
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | PREVIOUS ADDRESSES NON DEFAULT
                    |--------------------------------------------------------------------------
                    */

                    $customer->addresses()
                        ->update([
                            'is_default' =>
                                false,
                        ]);


                    /*
                    |--------------------------------------------------------------------------
                    | SAVE ADDRESS
                    |--------------------------------------------------------------------------
                    */

                    $address = Address::create([

                        'customer_id' =>
                            $customer->id,

                        'address_type' =>
                            'home',

                        'full_name' =>
                            $fullName,

                        'phone' =>
                            $validated['phone'],

                        'address' =>
                            $validated['address'],

                        'area' =>
                            $validated['area'] ?? null,

                        'city' =>
                            $validated['city'],

                        'state' =>
                            $validated['state'],

                        'pincode' =>
                            $validated['pincode'],

                        'is_default' =>
                            true,
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | GENERATE ORDER NUMBER
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

                    $paymentStatus =
                        'pending';


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE ORDER
                    |--------------------------------------------------------------------------
                    */

                    $orderId =
                        DB::table('orders')
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
                                    $coupon
                                        ? $coupon->code
                                        : null,

                                'payment_method' =>
                                    $validated[
                                        'payment_method'
                                    ],

                                'payment_status' =>
                                    $paymentStatus,

                                'order_status' =>
                                    'pending',

                                'customer_note' =>
                                    $validated[
                                        'customer_note'
                                    ] ?? null,

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


                        if (!$product) {
                            continue;
                        }


                        $itemTotal =
                            (float)
                            $cartItem->price *
                            (int)
                            $cartItem->quantity;


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


                        /*
                        |--------------------------------------------------------------------------
                        | REDUCE STOCK
                        |--------------------------------------------------------------------------
                        */

                        $product->decrement(
                            'stock',
                            $cartItem->quantity
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | INCREASE COUPON USED COUNT
                    |--------------------------------------------------------------------------
                    */

                    if ($coupon) {

                        $coupon->increment(
                            'used_count'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | DELETE CART ITEMS
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $checkoutMode ===
                        'cart'
                    ) {

                        $orderedCartIds =
                            $cartItems
                                ->pluck('id')
                                ->filter()
                                ->toArray();


                        if (
                            !empty(
                                $orderedCartIds
                            )
                        ) {

                            $customer->carts()
                                ->whereIn(
                                    'id',
                                    $orderedCartIds
                                )
                                ->delete();
                        }
                    }


                    return $orderNumber;
                }
            );

        } catch (\RuntimeException $e) {

            return redirect()
                ->route('checkout')
                ->withErrors([
                    'coupon' =>
                        $e->getMessage(),
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CLEAR CHECKOUT SESSION
        |--------------------------------------------------------------------------
        */

        $this->clearCheckoutSession();


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