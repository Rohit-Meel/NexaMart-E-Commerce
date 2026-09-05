@extends('layouts.admin')

@section('title', 'Order Details | NexaMart Admin')

@section('page-title', 'Order Details')

@section('page-subtitle', 'View and manage order details')

@section('content')

<style>

    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .order-detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .order-detail-title h2 {
        font-size: 25px;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .order-detail-title p {
        color: #6b7280;
        font-size: 13px;
    }


    /* =========================================================
       BACK BUTTON
    ========================================================= */

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        padding: 9px 15px;

        border-radius: 7px;

        background: #fff3e8;

        color: #ff7a00;

        text-decoration: none;

        font-size: 13px;
        font-weight: 600;

        border: 1px solid #ffe0c2;

        transition: 0.2s;
    }

    .back-btn:hover {
        background: #ff7a00;
        color: #ffffff;
        border-color: #ff7a00;
    }


    /* =========================================================
       CARDS
    ========================================================= */

    .order-detail-card {
        background: #ffffff;

        border: 1px solid #e5e7eb;

        border-radius: 12px;

        margin-bottom: 20px;

        overflow: hidden;
    }


    .order-detail-card-header {
        padding: 17px 20px;

        border-bottom: 1px solid #e5e7eb;

        display: flex;

        align-items: center;

        justify-content: space-between;
    }


    .order-detail-card-header h3 {
        margin: 0;

        font-size: 16px;

        color: #1f2937;
    }


    .order-detail-card-body {
        padding: 20px;
    }


    /* =========================================================
       ORDER INFORMATION
    ========================================================= */

    .order-info-grid {
        display: grid;

        grid-template-columns: repeat(4, 1fr);

        gap: 18px;
    }


    .info-box {
        padding: 15px;

        background: #fafafa;

        border: 1px solid #eeeeee;

        border-radius: 8px;
    }


    .info-box label {
        display: block;

        margin-bottom: 7px;

        color: #6b7280;

        font-size: 11px;

        font-weight: 700;

        text-transform: uppercase;
    }


    .info-box span {
        display: block;

        color: #1f2937;

        font-size: 13px;

        font-weight: 600;
    }


    /* =========================================================
       STATUS FORMS
    ========================================================= */

    .status-form {
        display: flex;

        align-items: center;

        gap: 10px;

        flex-wrap: wrap;
    }


    .status-form select {
        min-width: 190px;

        padding: 10px 12px;

        border: 1px solid #d1d5db;

        border-radius: 7px;

        background: #ffffff;

        color: #374151;

        font-size: 13px;

        outline: none;
    }


    .status-form select:focus {
        border-color: #ff7a00;

        box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.10);
    }


    .update-btn {
        padding: 10px 16px;

        border: none;

        border-radius: 7px;

        background: #ff7a00;

        color: #ffffff;

        font-size: 13px;

        font-weight: 600;

        cursor: pointer;

        transition: 0.2s;
    }


    .update-btn:hover {
        background: #e86f00;
    }


    /* =========================================================
       ADDRESS
    ========================================================= */

    .address-box {
        background: #fafafa;

        border: 1px solid #eeeeee;

        border-radius: 8px;

        padding: 16px;

        color: #374151;

        font-size: 13px;

        line-height: 1.8;
    }


    .address-box p {
        margin: 0;
    }


    /* =========================================================
       ORDER ITEMS TABLE
    ========================================================= */

    .order-items-wrapper {
        width: 100%;

        overflow-x: auto;
    }


    .order-items-table {
        width: 100%;

        min-width: 700px;

        border-collapse: collapse;
    }


    .order-items-table th {
        background: #fafafa;

        color: #6b7280;

        font-size: 11px;

        font-weight: 700;

        text-transform: uppercase;

        padding: 13px 15px;

        text-align: left;

        border-bottom: 1px solid #e5e7eb;
    }


    .order-items-table td {
        padding: 14px 15px;

        color: #374151;

        font-size: 13px;

        border-bottom: 1px solid #f0f0f0;
    }


    .order-items-table tbody tr:hover {
        background: #fffaf5;
    }


    .product-name {
        font-weight: 600;

        color: #1f2937;
    }


    .sku {
        color: #6b7280;
    }


    .item-total {
        font-weight: 700;

        color: #1f2937;
    }


    /* =========================================================
       PRICE SUMMARY
    ========================================================= */

    .price-summary {
        max-width: 500px;

        margin-left: auto;
    }


    .price-row {
        display: flex;

        align-items: center;

        justify-content: space-between;

        padding: 11px 0;

        border-bottom: 1px solid #f0f0f0;

        color: #6b7280;

        font-size: 13px;
    }


    .price-row strong {
        color: #374151;
    }


    .grand-total {
        display: flex;

        align-items: center;

        justify-content: space-between;

        padding-top: 16px;

        margin-top: 5px;

        font-size: 16px;

        color: #1f2937;

        font-weight: 700;
    }


    .grand-total strong {
        color: #ff7a00;

        font-size: 18px;
    }


    /* =========================================================
       CUSTOMER NOTE
    ========================================================= */

    .customer-note {
        background: #fffaf5;

        border: 1px solid #ffe0c2;

        border-radius: 8px;

        padding: 15px;

        color: #374151;

        font-size: 13px;

        line-height: 1.7;
    }


    /* =========================================================
       ALERT
    ========================================================= */

    .order-alert {
        padding: 12px 15px;

        margin-bottom: 20px;

        border-radius: 7px;

        background: #e9f8ef;

        border: 1px solid #c8ecd6;

        color: #198754;

        font-size: 13px;

        font-weight: 600;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media(max-width: 992px) {

        .order-info-grid {
            grid-template-columns: repeat(2, 1fr);
        }

    }


    @media(max-width: 576px) {

        .order-detail-header {
            flex-direction: column;

            align-items: stretch;

            gap: 15px;
        }


        .back-btn {
            justify-content: center;
        }


        .order-info-grid {
            grid-template-columns: 1fr;
        }


        .order-detail-card-body {
            padding: 15px;
        }


        .status-form {
            align-items: stretch;

            flex-direction: column;
        }


        .status-form select,
        .update-btn {
            width: 100%;
        }


        .price-summary {
            max-width: 100%;
        }

    }

</style>


{{-- =========================================================
     PAGE HEADER
========================================================= --}}

<div class="order-detail-header">

    <div class="order-detail-title">

        <h2>
            Order Details
        </h2>

        <p>
            Order {{ $order->order_number }}
        </p>

    </div>


    <div>

        <a
            href="{{ route('admin.orders.index') }}"
            class="back-btn"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Back to Orders

        </a>

    </div>

</div>



{{-- =========================================================
     SUCCESS MESSAGE
========================================================= --}}

@if(session('success'))

    <div class="order-alert">

        {{ session('success') }}

    </div>

@endif



{{-- =========================================================
     ORDER INFORMATION
========================================================= --}}

<div class="order-detail-card">

    <div class="order-detail-card-header">

        <h3>
            Order Information
        </h3>

    </div>


    <div class="order-detail-card-body">

        <div class="order-info-grid">


            <div class="info-box">

                <label>
                    Order Number
                </label>

                <span>
                    {{ $order->order_number }}
                </span>

            </div>


            <div class="info-box">

                <label>
                    Customer
                </label>

                <span>
                    {{ $order->customer?->name ?? 'Guest' }}
                </span>

            </div>


            <div class="info-box">

                <label>
                    Payment Method
                </label>

                <span>
                    {{ strtoupper($order->payment_method) }}
                </span>

            </div>


            <div class="info-box">

                <label>
                    Placed At
                </label>

                <span>
                    {{ $order->placed_at?->format('d M Y, h:i A') ?? '-' }}
                </span>

            </div>


        </div>

    </div>

</div>



{{-- =========================================================
     ORDER STATUS
========================================================= --}}

<div class="order-detail-card">

    <div class="order-detail-card-header">

        <h3>
            Order Status
        </h3>

    </div>


    <div class="order-detail-card-body">

        <form
            action="{{ route('admin.orders.update-status', $order) }}"
            method="POST"
            class="status-form"
        >

            @csrf

            @method('PATCH')


            <select name="order_status">

                @foreach([
                    'pending',
                    'confirmed',
                    'processing',
                    'shipped',
                    'delivered',
                    'cancelled'
                ] as $status)

                    <option
                        value="{{ $status }}"
                        @selected($order->order_status === $status)
                    >
                        {{ ucfirst($status) }}
                    </option>

                @endforeach

            </select>


            <button
                type="submit"
                class="update-btn"
            >
                Update Order Status
            </button>

        </form>

    </div>

</div>



{{-- =========================================================
     PAYMENT STATUS
========================================================= --}}

<div class="order-detail-card">

    <div class="order-detail-card-header">

        <h3>
            Payment Status
        </h3>

    </div>


    <div class="order-detail-card-body">

        <form
            action="{{ route('admin.orders.update-payment-status', $order) }}"
            method="POST"
            class="status-form"
        >

            @csrf

            @method('PATCH')


            <select name="payment_status">

                @foreach([
                    'pending',
                    'paid',
                    'failed',
                    'refunded'
                ] as $status)

                    <option
                        value="{{ $status }}"
                        @selected($order->payment_status === $status)
                    >
                        {{ ucfirst($status) }}
                    </option>

                @endforeach

            </select>


            <button
                type="submit"
                class="update-btn"
            >
                Update Payment Status
            </button>

        </form>

    </div>

</div>



{{-- =========================================================
     DELIVERY ADDRESS
========================================================= --}}

@if($order->address)

    <div class="order-detail-card">

        <div class="order-detail-card-header">

            <h3>
                Delivery Address
            </h3>

        </div>


        <div class="order-detail-card-body">

            <div class="address-box">

                <p>
                    {{ $order->address->address ?? '' }}
                </p>

                <p>
                    {{ $order->address->city ?? '' }},
                    {{ $order->address->state ?? '' }}
                    - {{ $order->address->pincode ?? '' }}
                </p>

            </div>

        </div>

    </div>

@endif



{{-- =========================================================
     ORDER ITEMS
========================================================= --}}

<div class="order-detail-card">

    <div class="order-detail-card-header">

        <h3>
            Order Items
        </h3>

        <span class="total-count">
            {{ $order->orderItems->count() }} Items
        </span>

    </div>


    <div class="order-items-wrapper">

        <table class="order-items-table">

            <thead>

                <tr>

                    <th>
                        Product
                    </th>

                    <th>
                        SKU
                    </th>

                    <th>
                        Quantity
                    </th>

                    <th>
                        Price
                    </th>

                    <th>
                        Total
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($order->orderItems as $item)

                    <tr>

                        <td>

                            <span class="product-name">
                                {{ $item->product_name }}
                            </span>

                        </td>


                        <td>

                            <span class="sku">
                                {{ $item->product_sku ?? '-' }}
                            </span>

                        </td>


                        <td>
                            {{ $item->quantity }}
                        </td>


                        <td>
                            ₹{{ number_format($item->price, 2) }}
                        </td>


                        <td>

                            <span class="item-total">
                                ₹{{ number_format($item->total, 2) }}
                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" style="text-align:center; padding:30px;">
                            No items found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



{{-- =========================================================
     PRICE SUMMARY
========================================================= --}}

<div class="order-detail-card">

    <div class="order-detail-card-header">

        <h3>
            Price Summary
        </h3>

    </div>


    <div class="order-detail-card-body">

        <div class="price-summary">


            <div class="price-row">

                <span>
                    Subtotal
                </span>

                <strong>
                    ₹{{ number_format($order->subtotal, 2) }}
                </strong>

            </div>


            <div class="price-row">

                <span>
                    Discount
                </span>

                <strong>
                    - ₹{{ number_format($order->discount, 2) }}
                </strong>

            </div>


            <div class="price-row">

                <span>
                    Shipping
                </span>

                <strong>
                    ₹{{ number_format($order->shipping_charge, 2) }}
                </strong>

            </div>


            <div class="price-row">

                <span>
                    Tax
                </span>

                <strong>
                    ₹{{ number_format($order->tax, 2) }}
                </strong>

            </div>


            <div class="grand-total">

                <span>
                    Total Amount
                </span>

                <strong>
                    ₹{{ number_format($order->total_amount, 2) }}
                </strong>

            </div>


        </div>

    </div>

</div>



{{-- =========================================================
     CUSTOMER NOTE
========================================================= --}}

@if($order->customer_note)

    <div class="order-detail-card">

        <div class="order-detail-card-header">

            <h3>
                Customer Note
            </h3>

        </div>


        <div class="order-detail-card-body">

            <div class="customer-note">

                {{ $order->customer_note }}

            </div>

        </div>

    </div>

@endif

@endsection