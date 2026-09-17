@extends('layouts.admin')

@section('title', 'Reviews | NexaMart Admin')

@section('page-title', 'Reviews')

@section('page-subtitle', 'Manage customer product reviews')
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
   REVIEW CARD
========================================================= */

.review-card {
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
   TABLE
========================================================= */

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.review-table {
    width: 100% !important;
    min-width: 1100px;
    border-collapse: collapse;
}

.review-table th {
    background: #fafafa !important;
    color: #6b7280;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;

    padding: 14px 18px;

    text-align: left;

    border-bottom: 1px solid #e5e7eb;
}

.review-table td {
    padding: 14px 18px;

    border-bottom: 1px solid #f0f0f0;

    font-size: 13px;

    vertical-align: middle;
}

.review-table tbody tr:hover {
    background: #fffaf5;
}


/* =========================================================
   CUSTOMER / PRODUCT
========================================================= */

.customer-name {
    color: #1f2937;
    font-weight: 600;
}

.product-name {
    color: #ff7a00;
    font-weight: 600;
}

.order-id {
    color: #6b7280;
}


/* =========================================================
   RATING
========================================================= */

.rating-wrapper {
    display: flex;
    align-items: center;
    gap: 3px;
    white-space: nowrap;
}

.rating-star {
    color: #ffb400;
    font-size: 14px;
}

.rating-value {
    margin-left: 5px;
    color: #374151;
    font-size: 12px;
    font-weight: 600;
}


/* =========================================================
   COMMENT
========================================================= */

.review-comment {
    color: #6b7280;
    max-width: 260px;
    line-height: 1.5;
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
   DATATABLE
========================================================= */

.dataTables_wrapper {
    padding: 18px 20px 20px;
}

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
            Reviews
        </h2>

        <p>
            Manage customer product reviews
        </p>

    </div>


    <a
        href="{{ route('admin.reviews.create') }}"
        class="add-btn"
    >
        + Add Review
    </a>

</div>


{{-- =========================================================
     REVIEW CARD
========================================================= --}}

<div class="review-card">

    <div class="card-top">

        <h3>
            All Reviews
        </h3>

        <span class="total-count">
            Total: {{ $reviews->count() }}
        </span>

    </div>


    @if($reviews->count())


        <div class="table-wrapper">

            <table
                id="reviewsTable"
                class="review-table display"
                style="width:100%"
            >

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Customer</th>

                        <th>Product</th>

                        <th>Order</th>

                        <th>Rating</th>

                        <th>Comment</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($reviews as $review)

                        <tr>

                            <td>
                                {{ $review->id }}
                            </td>


                            <td>

                                <div class="customer-name">
                                    {{ $review->customer->name ?? 'Customer #' . $review->customer_id }}
                                </div>

                            </td>


                            <td>

                                <div class="product-name">
                                    {{ $review->product->name ?? 'Product #' . $review->product_id }}
                                </div>

                            </td>


                            <td>

                                @if($review->order)

                                    <span class="order-id">
                                        #{{ $review->order->id }}
                                    </span>

                                @else

                                    <span class="order-id">
                                        N/A
                                    </span>

                                @endif

                            </td>


                            <td>

                                <div class="rating-wrapper">

                                    @for($i = 1; $i <= 5; $i++)

                                        @if($i <= $review->rating)

                                            <span class="rating-star">
                                                ★
                                            </span>

                                        @else

                                            <span style="color:#d1d5db;">
                                                ★
                                            </span>

                                        @endif

                                    @endfor

                                    <span class="rating-value">
                                        {{ $review->rating }}/5
                                    </span>

                                </div>

                            </td>


                            <td>

                                @if($review->comment)

                                    <div class="review-comment">
                                        {{ Str::limit($review->comment, 60) }}
                                    </div>

                                @else

                                    <span class="order-id">
                                        No comment
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($review->status)

                                    <span class="status-badge status-active">
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge status-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <td data-order="{{ $review->created_at->timestamp }}">

                                {{ $review->created_at->format('d M Y') }}

                            </td>


                            <td>

                                <div class="action-wrapper">


                                    <a
                                        href="{{ route('admin.reviews.edit', $review) }}"
                                        class="action-btn edit-btn"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.reviews.toggle-status', $review) }}"
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


                                    <form
                                        action="{{ route('admin.reviews.destroy', $review) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this review?')"
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
                No Reviews Found
            </h3>

            <p>
                Start by creating your first review.
            </p>

        </div>


    @endif

</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>


{{-- =========================================================
     DATATABLE
========================================================= --}}

<script>

$(document).ready(function () {

    $('#reviewsTable').DataTable({

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
                targets: [8]
            }

        ],

        language: {

            search: "Search:",

            lengthMenu: "Show _MENU_ entries",

            info: "Showing _START_ to _END_ of _TOTAL_ reviews",

            infoEmpty: "Showing 0 to 0 of 0 reviews",

            infoFiltered: "(filtered from _MAX_ total reviews)",

            zeroRecords: "No matching reviews found",

            emptyTable: "No reviews available",

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