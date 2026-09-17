@extends('layouts.admin')

@section('title', 'Orders | NexaMart Admin')

@section('page-title', 'Orders')

@section('page-subtitle', 'Manage all customer orders')

{{-- DataTables CSS --}}
<link
    rel="stylesheet"
    href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css"
>

@section('content')

<style>

    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .page-title h2 {
        font-size: 25px;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .page-title p {
        color: #6b7280;
        font-size: 13px;
    }


    /* =========================================================
       ORDER CARD
    ========================================================= */

    .order-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }


    .card-top {
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;

        display: flex;
        align-items: center;
        justify-content: space-between;
    }


    .card-top h3 {
        font-size: 17px;
        color: #1f2937;
        margin: 0;
    }


    .total-count {
        color: #6b7280;
        font-size: 13px;
    }


    /* =========================================================
       TABLE WRAPPER
    ========================================================= */

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }


    /* =========================================================
       ORDER TABLE
    ========================================================= */

    .order-table {
        width: 100% !important;
        min-width: 1200px;
        border-collapse: collapse;
    }


    .order-table th {
        background: #fafafa !important;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;

        padding: 14px 18px;

        text-align: left;

        border-bottom: 1px solid #e5e7eb;
    }


    .order-table td {
        padding: 14px 18px;

        border-bottom: 1px solid #f0f0f0;

        font-size: 13px;

        vertical-align: middle;
    }


    .order-table tbody tr:hover {
        background: #fffaf5;
    }


    /* =========================================================
       ORDER NUMBER
    ========================================================= */

    .order-number {
        color: #1f2937;
        font-weight: 600;
        white-space: nowrap;
    }


    /* =========================================================
       CUSTOMER
    ========================================================= */

    .customer-name {
        color: #1f2937;
        font-weight: 600;
    }


    /* =========================================================
       TOTAL
    ========================================================= */

    .order-total {
        color: #1f2937;
        font-weight: 700;
        white-space: nowrap;
    }


    /* =========================================================
       PAYMENT METHOD
    ========================================================= */

    .payment-method {
        color: #374151;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
    }


    /* =========================================================
       STATUS
    ========================================================= */

    .status-badge {
        display: inline-block;

        padding: 5px 10px;

        border-radius: 20px;

        font-size: 11px;
        font-weight: 700;

        white-space: nowrap;
    }


    .status-active {
        background: #e9f8ef;
        color: #198754;
    }


    .status-inactive {
        background: #fdecec;
        color: #dc3545;
    }


    .status-warning {
        background: #fff3e8;
        color: #ff7a00;
    }


    .status-pending {
        background: #fff8e6;
        color: #b7791f;
    }


    /* =========================================================
       ACTION BUTTONS
    ========================================================= */

    .action-wrapper {
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }


    .action-wrapper form {
        margin: 0;
    }


    .action-btn {
        border: none;

        border-radius: 6px;

        padding: 7px 10px;

        font-size: 12px;

        cursor: pointer;

        text-decoration: none;

        display: inline-block;

        transition: 0.2s;
    }


    .view-btn {
        background: #eef2ff;
        color: #4f46e5;
    }


    .view-btn:hover {
        background: #4f46e5;
        color: #ffffff;
    }


    .delete-btn {
        background: #fdecec;
        color: #dc3545;
    }


    .delete-btn:hover {
        background: #dc3545;
        color: #ffffff;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #6b7280;
    }


    .empty-state h3 {
        margin-bottom: 6px;
        color: #374151;
    }


    /* =========================================================
       DATATABLE WRAPPER
    ========================================================= */

    .dataTables_wrapper {
        padding: 18px 20px 20px;
    }


    /* =========================================================
       DATATABLE TOP
    ========================================================= */

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 18px;
    }


    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }


    .dataTables_wrapper .dataTables_length select {
        margin: 0 6px;

        padding: 7px 30px 7px 10px;

        border: 1px solid #d1d5db;

        border-radius: 6px;

        background: #ffffff;

        color: #374151;

        outline: none;

        cursor: pointer;
    }


    .dataTables_wrapper .dataTables_filter input {
        margin-left: 7px;

        padding: 8px 12px;

        width: 220px;

        border: 1px solid #d1d5db;

        border-radius: 6px;

        outline: none;

        font-size: 13px;
    }


    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #ff7a00;

        box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.10);
    }


    /* =========================================================
       DATATABLE BOTTOM
    ========================================================= */

    .dataTables_wrapper .dataTables_info {
        padding-top: 16px;

        font-size: 12px;

        color: #6b7280;
    }


    .dataTables_wrapper .dataTables_paginate {
        padding-top: 12px;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button {
        min-width: 34px;

        height: 34px;

        line-height: 32px;

        padding: 0 9px !important;

        margin-left: 4px;

        border: 1px solid #e5e7eb !important;

        border-radius: 6px !important;

        background: #ffffff !important;

        color: #374151 !important;

        font-size: 12px;

        cursor: pointer;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #fff3e8 !important;

        border-color: #ff7a00 !important;

        color: #ff7a00 !important;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #ff7a00 !important;

        border-color: #ff7a00 !important;

        color: #ffffff !important;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #e86f00 !important;

        border-color: #e86f00 !important;

        color: #ffffff !important;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        background: #f9fafb !important;

        border-color: #e5e7eb !important;

        color: #c1c5ca !important;

        cursor: not-allowed;
    }


    /* =========================================================
       DATATABLE SORTING
    ========================================================= */

    table.dataTable thead th {
        border-bottom: 1px solid #e5e7eb !important;
    }


    table.dataTable.no-footer {
        border-bottom: 0 !important;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media(max-width: 768px) {

        .dataTables_wrapper {
            padding: 15px;
        }


        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            width: 100%;

            text-align: left;

            margin-bottom: 12px;
        }


        .dataTables_wrapper .dataTables_filter input {
            width: 100%;

            margin-left: 0;

            margin-top: 7px;
        }


        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            width: 100%;

            text-align: left;

            margin-top: 8px;
        }

    }


    @media(max-width: 576px) {

        .page-header {
            flex-direction: column;

            align-items: stretch;

            gap: 15px;
        }


        .card-top {
            padding: 15px;
        }

    }

</style>


{{-- =========================================================
     PAGE HEADER
========================================================= --}}

<div class="page-header">

    <div class="page-title">

        <h2>
            Orders
        </h2>

        <p>
            Manage all customer orders
        </p>

    </div>

</div>



{{-- =========================================================
     ORDER CARD
========================================================= --}}

<div class="order-card">


    <div class="card-top">

        <h3>
            All Orders
        </h3>

        <span class="total-count">
            Total: {{ $orders->count() }}
        </span>

    </div>



    @if($orders->count())


        <div class="table-wrapper">


            <table
                id="ordersTable"
                class="order-table display"
                style="width:100%"
            >

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Order Number
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Items
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Payment
                        </th>

                        <th>
                            Payment Status
                        </th>

                        <th>
                            Order Status
                        </th>

                        <th>
                            Placed At
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @foreach($orders as $order)

                        <tr>


                            {{-- ID --}}

                            <td>
                                {{ $order->id }}
                            </td>


                            {{-- ORDER NUMBER --}}

                            <td>

                                <div class="order-number">
                                    {{ $order->order_number }}
                                </div>

                            </td>


                            {{-- CUSTOMER --}}

                            <td>

                                <div class="customer-name">
                                    {{ $order->customer?->name ?? 'Guest' }}
                                </div>

                            </td>


                            {{-- ITEMS --}}

                            <td>
                                {{ $order->order_items_count }}
                            </td>


                            {{-- TOTAL --}}

                            <td>

                                <div class="order-total">
                                    ₹{{ number_format($order->total_amount, 2) }}
                                </div>

                            </td>


                            {{-- PAYMENT METHOD --}}

                            <td>

                                <div class="payment-method">
                                    {{ $order->payment_method }}
                                </div>

                            </td>


                            {{-- PAYMENT STATUS --}}

                            <td>

                                @if($order->payment_status === 'paid')

                                    <span class="status-badge status-active">
                                        Paid
                                    </span>

                                @elseif($order->payment_status === 'failed')

                                    <span class="status-badge status-inactive">
                                        Failed
                                    </span>

                                @elseif($order->payment_status === 'refunded')

                                    <span class="status-badge status-warning">
                                        Refunded
                                    </span>

                                @else

                                    <span class="status-badge status-pending">
                                        Pending
                                    </span>

                                @endif

                            </td>


                            {{-- ORDER STATUS --}}

                            <td>

                                @if($order->order_status === 'delivered')

                                    <span class="status-badge status-active">
                                        Delivered
                                    </span>

                                @elseif($order->order_status === 'cancelled')

                                    <span class="status-badge status-inactive">
                                        Cancelled
                                    </span>

                                @elseif($order->order_status === 'shipped')

                                    <span class="status-badge status-warning">
                                        Shipped
                                    </span>

                                @elseif($order->order_status === 'processing')

                                    <span class="status-badge status-warning">
                                        Processing
                                    </span>

                                @elseif($order->order_status === 'confirmed')

                                    <span class="status-badge status-active">
                                        Confirmed
                                    </span>

                                @else

                                    <span class="status-badge status-pending">
                                        Pending
                                    </span>

                                @endif

                            </td>


                            {{-- PLACED AT --}}

                            <td
                                data-order="{{ $order->placed_at?->timestamp ?? 0 }}"
                            >

                                {{ $order->placed_at?->format('d M Y, h:i A') ?? '-' }}

                            </td>


                            {{-- ACTIONS --}}

                            <td>

                                <div class="action-wrapper">


                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="action-btn view-btn"
                                    >
                                        View
                                    </a>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route('admin.orders.destroy', $order) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this order?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-btn delete-btn"
                                        >
                                            Delete
                                        </button>

                                    </form>


                                </div>

                            </td>


                        </tr>

                    @endforeach


                </tbody>

            </table>


        </div>


    @else


        <div class="empty-state">

            <h3>
                No Orders Found
            </h3>

            <p>
                No customer orders are available.
            </p>

        </div>


    @endif


</div>



{{-- =========================================================
     DATATABLE JS
========================================================= --}}

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- DataTables JS --}}
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>


<script>

$(document).ready(function () {

    $('#ordersTable').DataTable({

        responsive: false,

        autoWidth: false,

        scrollX: true,

        scrollCollapse: true,

        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],

        order: [
            [0, 'desc']
        ],

        columnDefs: [

            {
                orderable: false,
                searchable: false,
                targets: [9]
            }

        ],

        language: {

            search: "Search:",

            lengthMenu: "Show _MENU_ entries",

            info: "Showing _START_ to _END_ of _TOTAL_ orders",

            infoEmpty: "Showing 0 to 0 of 0 orders",

            infoFiltered: "(filtered from _MAX_ total orders)",

            zeroRecords: "No matching orders found",

            emptyTable: "No orders available",

            paginate: {

                first: "First",

                last: "Last",

                previous: "Previous",

                next: "Next"

            }

        }

    });

});

</script>


@endsection