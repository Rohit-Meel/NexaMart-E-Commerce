@extends('layouts.admin')

@section('title', 'Coupons | NexaMart Admin')

@section('page-title', 'Coupons')

@section('page-subtitle', 'Manage all discount coupons')


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
   ADD BUTTON
========================================================= */

.add-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 11px 17px;

    border-radius: 7px;

    background: #ff7a00;
    color: #ffffff;

    text-decoration: none;

    font-size: 14px;
    font-weight: 600;

    transition: 0.2s;
}


.add-btn:hover {
    background: #e86f00;
    color: #ffffff;
}


/* =========================================================
   COUPON CARD
========================================================= */

.coupon-card {
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
   COUPON TABLE
========================================================= */

.coupon-table {
    width: 100% !important;

    min-width: 1000px;

    border-collapse: collapse;
}


.coupon-table th {
    background: #fafafa !important;

    color: #6b7280;

    font-size: 12px;

    font-weight: 700;

    text-transform: uppercase;

    padding: 14px 18px;

    text-align: left;

    border-bottom: 1px solid #e5e7eb;
}


.coupon-table td {
    padding: 14px 18px;

    border-bottom: 1px solid #f0f0f0;

    font-size: 13px;

    vertical-align: middle;
}


.coupon-table tbody tr:hover {
    background: #fffaf5;
}


/* =========================================================
   COUPON CODE
========================================================= */

.coupon-code {
    color: #1f2937;

    font-weight: 600;
}


.coupon-description {
    color: #6b7280;

    font-size: 12px;

    margin-top: 4px;
}


/* =========================================================
   DISCOUNT
========================================================= */

.discount-value {
    color: #1f2937;

    font-weight: 600;
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
}


.status-active {
    background: #e9f8ef;

    color: #198754;
}


.status-inactive {
    background: #fdecec;

    color: #dc3545;
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


.edit-btn {
    background: #fff3e8;

    color: #ff7a00;
}


.edit-btn:hover {
    background: #ff7a00;

    color: #ffffff;
}


.toggle-btn {
    background: #eef2ff;

    color: #4f46e5;
}


.toggle-btn:hover {
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


    .add-btn {
        justify-content: center;
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
            Coupons
        </h2>

        <p>
            Manage all discount coupons
        </p>

    </div>


    <a
        href="{{ route('admin.coupons.create') }}"
        class="add-btn"
    >

        + Add Coupon

    </a>

</div>



{{-- =========================================================
     COUPON CARD
========================================================= --}}

<div class="coupon-card">


    <div class="card-top">

        <h3>
            All Coupons
        </h3>

        <span class="total-count">
            Total: {{ $coupons->count() }}
        </span>

    </div>



    @if($coupons->count())


        <div class="table-wrapper">


            <table
                id="couponsTable"
                class="coupon-table display"
                style="width:100%"
            >

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Code
                        </th>

                        <th>
                            Discount
                        </th>

                        <th>
                            Min Order
                        </th>

                        <th>
                            Usage
                        </th>

                        <th>
                            Start
                        </th>

                        <th>
                            End
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @foreach($coupons as $coupon)

                        <tr>


                            {{-- ID --}}

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- CODE --}}

                            <td>

                                <div class="coupon-code">
                                    {{ $coupon->code }}
                                </div>


                                @if($coupon->description)

                                    <div class="coupon-description">

                                        {{ Str::limit(
                                            $coupon->description,
                                            40
                                        ) }}

                                    </div>

                                @endif

                            </td>


                            {{-- DISCOUNT --}}

                            <td>

                                <strong class="discount-value">

                                    @if($coupon->discount_type === 'percentage')

                                        {{ number_format(
                                            $coupon->discount_value,
                                            0
                                        ) }}%

                                    @else

                                        ₹{{ number_format(
                                            $coupon->discount_value,
                                            2
                                        ) }}

                                    @endif

                                </strong>

                            </td>


                            {{-- MINIMUM ORDER --}}

                            <td>

                                ₹{{ number_format(
                                    $coupon->minimum_order_amount,
                                    2
                                ) }}

                            </td>


                            {{-- USAGE --}}

                            <td>

                                {{ $coupon->used_count }}

                                /

                                {{ $coupon->usage_limit ?? '∞' }}

                            </td>


                            {{-- START --}}

                            <td
                                data-order="{{ $coupon->start_at?->timestamp ?? 0 }}"
                            >

                                {{ $coupon->start_at
                                    ? $coupon->start_at->format('d M Y')
                                    : '-'
                                }}

                            </td>


                            {{-- END --}}

                            <td
                                data-order="{{ $coupon->end_at?->timestamp ?? 0 }}"
                            >

                                {{ $coupon->end_at
                                    ? $coupon->end_at->format('d M Y')
                                    : '-'
                                }}

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if($coupon->status)

                                    <span class="status-badge status-active">
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge status-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- ACTIONS --}}

                            <td>

                                <div class="action-wrapper">


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route(
                                            'admin.coupons.edit',
                                            $coupon
                                        ) }}"
                                        class="action-btn edit-btn"
                                    >

                                        Edit

                                    </a>


                                    {{-- TOGGLE --}}

                                    <form
                                        action="{{ route(
                                            'admin.coupons.toggle-status',
                                            $coupon
                                        ) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="action-btn toggle-btn"
                                        >

                                            Toggle

                                        </button>

                                    </form>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route(
                                            'admin.coupons.destroy',
                                            $coupon
                                        ) }}"
                                        method="POST"

                                        onsubmit="return confirm(
                                            'Are you sure you want to delete this coupon?'
                                        )"
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
                No Coupons Found
            </h3>

            <p>
                Start by creating your first coupon.
            </p>

        </div>


    @endif


</div>



{{-- =========================================================
     DATATABLE JS
========================================================= --}}

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>


<script>

$(document).ready(function () {

    $('#couponsTable').DataTable({

        responsive: false,

        autoWidth: false,

        scrollX: true,

        scrollCollapse: true,


        pageLength: 10,


        lengthMenu: [

            [10, 25, 50, 100, -1],

            [10, 25, 50, 100, "All"]

        ],


        /*
        |--------------------------------------------------------------------------
        | FIRST COLUMN ASCENDING
        |--------------------------------------------------------------------------
        */

        order: [

            [0, 'asc']

        ],


        columnDefs: [

            {
                orderable: false,
                searchable: false,
                targets: [8]
            }

        ],


        language: {

            search: "Search:",

            lengthMenu: "Show _MENU_ entries",

            info: "Showing _START_ to _END_ of _TOTAL_ coupons",

            infoEmpty: "Showing 0 to 0 of 0 coupons",

            infoFiltered: "(filtered from _MAX_ total coupons)",

            zeroRecords: "No matching coupons found",

            emptyTable: "No coupons available",


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