@extends('layouts.frontend')

@section('title', 'My Orders - NexaMart')

@section('content')

<section class="account-orders-page">

    <div class="account-orders-container">


        {{-- BREADCRUMB --}}

        <div class="account-orders-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <a href="{{ route('customer.account') }}">
                My Account
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <span>
                My Orders
            </span>

        </div>



        {{-- PAGE HEADING --}}

        <div class="account-orders-heading">

            <div>

                <span>
                    ORDER HISTORY
                </span>

                <h1>
                    My <strong>Orders</strong>
                </h1>

                <p>
                    View and track all your orders from one place.
                </p>

            </div>


            <a
                href="{{ route('products') }}"
                class="account-orders-shop-btn"
            >

                Continue Shopping

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>



        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div class="home-alert home-alert-success">

                <i class="fa-solid fa-circle-check"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif



        {{-- ERROR MESSAGE --}}

        @if(session('error'))

            <div class="home-alert home-alert-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>

        @endif



        {{-- ORDERS --}}

        @if($orders->count())


            <div class="account-orders-list">

                @foreach($orders as $order)

                    @php

                        $statusClass = match($order->order_status) {

                            'pending' => 'pending',

                            'confirmed' => 'confirmed',

                            'processing' => 'processing',

                            'shipped' => 'shipped',

                            'delivered' => 'delivered',

                            'cancelled' => 'cancelled',

                            default => 'pending'

                        };

                    @endphp


                    <div class="account-order-card">


                        {{-- ORDER HEADER --}}

                        <div class="account-order-header">

                            <div>

                                <span class="account-order-label">
                                    ORDER NUMBER
                                </span>

                                <h2>
                                    #{{ $order->order_number }}
                                </h2>

                            </div>


                            <div class="account-order-date">

                                <span>
                                    ORDERED ON
                                </span>

                                <strong>
                                    {{ $order->placed_at
                                        ? $order->placed_at->format('d M Y')
                                        : $order->created_at->format('d M Y')
                                    }}
                                </strong>

                            </div>


                            <span
                                class="account-order-status {{ $statusClass }}"
                            >

                                {{ ucfirst($order->order_status) }}

                            </span>

                        </div>



                        {{-- ORDER BODY --}}

                        <div class="account-order-body">


                            {{-- PRODUCTS --}}

                            <div class="account-order-products">

                                @foreach($order->orderItems as $item)

                                    <div class="account-order-product">


                                        <div class="account-order-product-image">

                                            @if(
                                                $item->product &&
                                                $item->product->thumbnail
                                            )

                                                <img
                                                    src="{{ asset('storage/' . $item->product->thumbnail) }}"
                                                    alt="{{ $item->product->name }}"
                                                >

                                            @else

                                                <img
                                                    src="{{ asset('assets/images/logo/banner.png') }}"
                                                    alt="Product"
                                                >

                                            @endif

                                        </div>


                                        <div class="account-order-product-info">

                                            <h3>

                                                {{ $item->product->name ?? 'Product' }}

                                            </h3>

                                            <span>

                                                Qty:
                                                {{ $item->quantity }}

                                            </span>

                                            <strong>

                                                ₹{{ number_format(
                                                    $item->total ?? (
                                                        $item->price * $item->quantity
                                                    ),
                                                    2
                                                ) }}

                                            </strong>

                                        </div>

                                    </div>

                                @endforeach

                            </div>



                            {{-- ORDER SUMMARY --}}

                            <div class="account-order-summary">

                                <div>

                                    <span>
                                        Subtotal
                                    </span>

                                    <strong>
                                        ₹{{ number_format($order->subtotal, 2) }}
                                    </strong>

                                </div>


                                @if($order->discount > 0)

                                    <div>

                                        <span>
                                            Discount
                                        </span>

                                        <strong class="discount-text">
                                            -₹{{ number_format($order->discount, 2) }}
                                        </strong>

                                    </div>

                                @endif


                                @if($order->shipping_charge > 0)

                                    <div>

                                        <span>
                                            Shipping
                                        </span>

                                        <strong>
                                            ₹{{ number_format($order->shipping_charge, 2) }}
                                        </strong>

                                    </div>

                                @endif


                                @if($order->tax > 0)

                                    <div>

                                        <span>
                                            Tax
                                        </span>

                                        <strong>
                                            ₹{{ number_format($order->tax, 2) }}
                                        </strong>

                                    </div>

                                @endif


                                <div class="account-order-total">

                                    <span>
                                        Total
                                    </span>

                                    <strong>
                                        ₹{{ number_format($order->total_amount, 2) }}
                                    </strong>

                                </div>

                            </div>

                        </div>



                        {{-- ORDER FOOTER --}}

                        <div class="account-order-footer">


                            <div class="account-order-payment">

                                <span>
                                    PAYMENT
                                </span>

                                <strong>

                                    @if($order->payment_method === 'cod')

                                        Cash on Delivery

                                    @else

                                        Online Payment

                                    @endif

                                </strong>

                            </div>


                            <div class="account-order-payment-status">

                                <span>
                                    PAYMENT STATUS
                                </span>

                                <strong
                                    class="{{ $order->payment_status }}"
                                >

                                    {{ ucfirst($order->payment_status) }}

                                </strong>

                            </div>


                            <div class="account-order-actions">

                                <a
                                    href="{{ route('products') }}"
                                    class="account-order-btn"
                                >

                                    Continue Shopping

                                    <i class="fa-solid fa-arrow-right"></i>

                                </a>

                            </div>

                        </div>


                    </div>

                @endforeach

            </div>


        @else


            {{-- EMPTY ORDERS --}}

            <div class="account-orders-empty">

                <div class="account-orders-empty-icon">

                    <i class="fa-solid fa-box-open"></i>

                </div>

                <h2>
                    No Orders Yet
                </h2>

                <p>
                    You haven't placed any orders yet.
                    Start shopping and your orders will appear here.
                </p>

                <a
                    href="{{ route('products') }}"
                    class="account-orders-empty-btn"
                >

                    Start Shopping

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>

        @endif


    </div>

</section>
<style>
    /* =========================================================
   MY ORDERS PAGE
   ========================================================= */

.account-orders-page {
    width: 100%;
    padding: 35px 0 70px;
    background: #f8f9fb;
}

.account-orders-container {
    width: 92%;
    max-width: 1250px;
    margin: 0 auto;
}


/* =========================================================
   BREADCRUMB
   ========================================================= */

.account-orders-breadcrumb {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 9px;
    margin-bottom: 28px;
    font-size: 13px;
    color: #777;
}

.account-orders-breadcrumb a {
    color: #555;
    text-decoration: none;
    transition: 0.3s ease;
}

.account-orders-breadcrumb a:hover {
    color: #ff7a00;
}

.account-orders-breadcrumb i {
    font-size: 10px;
    color: #aaa;
}

.account-orders-breadcrumb span {
    color: #ff7a00;
    font-weight: 600;
}


/* =========================================================
   PAGE HEADING
   ========================================================= */

.account-orders-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 25px;
    margin-bottom: 30px;
}

.account-orders-heading span {
    display: block;
    margin-bottom: 7px;
    color: #ff7a00;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1.5px;
}

.account-orders-heading h1 {
    margin: 0;
    color: #222;
    font-size: 32px;
    line-height: 1.2;
    font-weight: 400;
}

.account-orders-heading h1 strong {
    font-weight: 700;
}

.account-orders-heading p {
    margin: 8px 0 0;
    color: #777;
    font-size: 14px;
    line-height: 1.6;
}

.account-orders-shop-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 12px 20px;
    border: 1px solid #ff7a00;
    border-radius: 7px;
    background: #ff7a00;
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.account-orders-shop-btn i {
    font-size: 12px;
    transition: transform 0.3s ease;
}

.account-orders-shop-btn:hover {
    background: #e96e00;
    border-color: #e96e00;
    color: #fff;
}

.account-orders-shop-btn:hover i {
    transform: translateX(4px);
}


/* =========================================================
   ALERTS
   ========================================================= */

.home-alert {
    display: flex;
    align-items: center;
    gap: 11px;
    width: 100%;
    padding: 13px 16px;
    margin-bottom: 22px;
    border-radius: 7px;
    font-size: 13px;
    font-weight: 500;
}

.home-alert i {
    font-size: 16px;
}

.home-alert-success {
    border: 1px solid #ccebd9;
    background: #f0fff6;
    color: #18864b;
}

.home-alert-error {
    border: 1px solid #f3cccc;
    background: #fff4f4;
    color: #d33b3b;
}


/* =========================================================
   ORDERS LIST
   ========================================================= */

.account-orders-list {
    display: flex;
    flex-direction: column;
    gap: 22px;
}


/* =========================================================
   ORDER CARD
   ========================================================= */

.account-order-card {
    overflow: hidden;
    background: #fff;
    border: 1px solid #e9e9e9;
    border-radius: 10px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
}


/* =========================================================
   ORDER HEADER
   ========================================================= */

.account-order-header {
    display: grid;
    grid-template-columns: 1fr auto auto;
    align-items: center;
    gap: 25px;
    padding: 20px 23px;
    border-bottom: 1px solid #eeeeee;
    background: #fff;
}

.account-order-label {
    display: block;
    margin-bottom: 5px;
    color: #999;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.2px;
}

.account-order-header h2 {
    margin: 0;
    color: #222;
    font-size: 18px;
    font-weight: 700;
}

.account-order-date {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 5px;
}

.account-order-date span {
    color: #999;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
}

.account-order-date strong {
    color: #444;
    font-size: 13px;
    font-weight: 600;
}


/* =========================================================
   ORDER STATUS
   ========================================================= */

.account-order-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 90px;
    padding: 7px 12px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
    text-transform: capitalize;
}


/* Pending */

.account-order-status.pending {
    background: #fff4df;
    color: #d98200;
}


/* Confirmed */

.account-order-status.confirmed {
    background: #eaf3ff;
    color: #2878d4;
}


/* Processing */

.account-order-status.processing {
    background: #f0eaff;
    color: #7354c7;
}


/* Shipped */

.account-order-status.shipped {
    background: #e7f8f7;
    color: #15958e;
}


/* Delivered */

.account-order-status.delivered {
    background: #e9f8ee;
    color: #219653;
}


/* Cancelled */

.account-order-status.cancelled {
    background: #fff0f0;
    color: #d64545;
}


/* =========================================================
   ORDER BODY
   ========================================================= */

.account-order-body {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 280px;
    gap: 30px;
    padding: 22px 23px;
}


/* =========================================================
   PRODUCTS
   ========================================================= */

.account-order-products {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.account-order-product {
    display: flex;
    align-items: center;
    gap: 15px;
    min-width: 0;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.account-order-product:last-child {
    padding-bottom: 0;
    border-bottom: none;
}

.account-order-product-image {
    flex: 0 0 72px;
    width: 72px;
    height: 72px;
    overflow: hidden;
    border: 1px solid #eeeeee;
    border-radius: 8px;
    background: #fafafa;
}

.account-order-product-image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.account-order-product-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 5px;
    min-width: 0;
}

.account-order-product-info h3 {
    max-width: 100%;
    margin: 0;
    overflow: hidden;
    color: #292929;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.account-order-product-info span {
    color: #888;
    font-size: 12px;
}

.account-order-product-info strong {
    color: #222;
    font-size: 13px;
    font-weight: 700;
}


/* =========================================================
   ORDER SUMMARY
   ========================================================= */

.account-order-summary {
    padding: 17px;
    border: 1px solid #eeeeee;
    border-radius: 8px;
    background: #fafafa;
}

.account-order-summary > div {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 8px 0;
}

.account-order-summary span {
    color: #777;
    font-size: 12px;
}

.account-order-summary strong {
    color: #333;
    font-size: 12px;
    font-weight: 600;
}

.account-order-summary .discount-text {
    color: #1b9a57;
}

.account-order-summary .account-order-total {
    margin-top: 8px;
    padding-top: 14px;
    border-top: 1px solid #dddddd;
}

.account-order-summary .account-order-total span {
    color: #222;
    font-size: 14px;
    font-weight: 700;
}

.account-order-summary .account-order-total strong {
    color: #ff7a00;
    font-size: 17px;
    font-weight: 700;
}


/* =========================================================
   ORDER FOOTER
   ========================================================= */

.account-order-footer {
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    align-items: center;
    gap: 25px;
    padding: 17px 23px;
    border-top: 1px solid #eeeeee;
    background: #fcfcfc;
}

.account-order-payment,
.account-order-payment-status {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.account-order-payment span,
.account-order-payment-status span {
    color: #999;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
}

.account-order-payment strong {
    color: #444;
    font-size: 12px;
    font-weight: 600;
}

.account-order-payment-status strong {
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
}


/* Payment Status */

.account-order-payment-status strong.paid {
    color: #1d9655;
}

.account-order-payment-status strong.pending {
    color: #d98200;
}

.account-order-payment-status strong.failed {
    color: #d64545;
}

.account-order-payment-status strong.refunded {
    color: #7354c7;
}


/* =========================================================
   ORDER ACTION
   ========================================================= */

.account-order-actions {
    display: flex;
    justify-content: flex-end;
}

.account-order-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 15px;
    border: 1px solid #dddddd;
    border-radius: 6px;
    background: #fff;
    color: #444;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.account-order-btn i {
    font-size: 11px;
    transition: transform 0.3s ease;
}

.account-order-btn:hover {
    border-color: #ff7a00;
    background: #ff7a00;
    color: #fff;
}

.account-order-btn:hover i {
    transform: translateX(4px);
}


/* =========================================================
   EMPTY ORDERS
   ========================================================= */

.account-orders-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 380px;
    padding: 45px 25px;
    text-align: center;
    background: #fff;
    border: 1px solid #eeeeee;
    border-radius: 10px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
}

.account-orders-empty-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 75px;
    height: 75px;
    margin-bottom: 18px;
    border-radius: 50%;
    background: #fff3e8;
    color: #ff7a00;
}

.account-orders-empty-icon i {
    font-size: 30px;
}

.account-orders-empty h2 {
    margin: 0 0 8px;
    color: #222;
    font-size: 22px;
    font-weight: 700;
}

.account-orders-empty p {
    max-width: 500px;
    margin: 0 0 22px;
    color: #777;
    font-size: 13px;
    line-height: 1.7;
}

.account-orders-empty-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 11px 20px;
    border-radius: 6px;
    background: #ff7a00;
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.account-orders-empty-btn i {
    font-size: 11px;
    transition: transform 0.3s ease;
}

.account-orders-empty-btn:hover {
    background: #e96e00;
    color: #fff;
}

.account-orders-empty-btn:hover i {
    transform: translateX(4px);
}


/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 900px) {

    .account-orders-container {
        width: 94%;
    }

    .account-orders-heading h1 {
        font-size: 28px;
    }

    .account-order-body {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .account-order-summary {
        width: 100%;
    }

    .account-order-footer {
        grid-template-columns: 1fr 1fr;
    }

    .account-order-actions {
        grid-column: 1 / -1;
        justify-content: flex-start;
    }

}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 600px) {

    .account-orders-page {
        padding: 22px 0 45px;
    }

    .account-orders-container {
        width: 94%;
    }

    .account-orders-breadcrumb {
        margin-bottom: 20px;
        gap: 7px;
        font-size: 12px;
    }

    .account-orders-heading {
        align-items: flex-start;
        flex-direction: column;
        gap: 17px;
        margin-bottom: 22px;
    }

    .account-orders-heading h1 {
        font-size: 25px;
    }

    .account-orders-heading p {
        font-size: 12px;
    }

    .account-orders-shop-btn {
        width: 100%;
    }


    /* Order Header */

    .account-order-header {
        grid-template-columns: 1fr auto;
        gap: 14px;
        padding: 16px;
    }

    .account-order-date {
        align-items: flex-start;
    }

    .account-order-status {
        grid-column: 1 / -1;
        justify-self: flex-start;
    }


    /* Order Body */

    .account-order-body {
        padding: 17px 16px;
    }


    /* Products */

    .account-order-product {
        gap: 12px;
    }

    .account-order-product-image {
        flex: 0 0 62px;
        width: 62px;
        height: 62px;
    }

    .account-order-product-info h3 {
        font-size: 13px;
    }


    /* Footer */

    .account-order-footer {
        grid-template-columns: 1fr;
        gap: 15px;
        padding: 16px;
    }

    .account-order-actions {
        grid-column: auto;
        width: 100%;
    }

    .account-order-btn {
        width: 100%;
    }


    /* Empty */

    .account-orders-empty {
        min-height: 330px;
        padding: 35px 20px;
    }

    .account-orders-empty-icon {
        width: 65px;
        height: 65px;
    }

    .account-orders-empty-icon i {
        font-size: 25px;
    }

    .account-orders-empty h2 {
        font-size: 20px;
    }

    .account-orders-empty p {
        font-size: 12px;
    }

    .account-orders-empty-btn {
        width: 100%;
    }

}


/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 400px) {

    .account-orders-heading h1 {
        font-size: 23px;
    }

    .account-order-header h2 {
        font-size: 16px;
    }

    .account-order-product-info h3 {
        font-size: 12px;
    }

    .account-order-summary .account-order-total strong {
        font-size: 15px;
    }

}
</style>
@endsection