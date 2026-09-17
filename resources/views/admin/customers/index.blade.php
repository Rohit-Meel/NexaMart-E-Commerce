@extends('layouts.admin')

@section('title', 'Customers | NexaMart Admin')

@section('page-title', 'Customers')

@section('page-subtitle', 'Manage all registered customers')

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
   CUSTOMER CARD
========================================================= */

.customer-card {
    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 12px;

    overflow: hidden;
}


/* =========================================================
   CARD TOP
========================================================= */

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
   CUSTOMER TABLE
========================================================= */

.customer-table {
    width: 100% !important;

    min-width: 950px;

    border-collapse: collapse;
}

.customer-table th {
    background: #fafafa !important;

    color: #6b7280;

    font-size: 12px;
    font-weight: 700;

    text-transform: uppercase;

    padding: 14px 18px;

    text-align: left;

    border-bottom: 1px solid #e5e7eb;
}

.customer-table td {
    padding: 14px 18px;

    border-bottom: 1px solid #f0f0f0;

    font-size: 13px;

    vertical-align: middle;
}

.customer-table tbody tr:hover {
    background: #fffaf5;
}


/* =========================================================
   CUSTOMER PROFILE
========================================================= */

.customer-profile {
    display: flex;
    align-items: center;
    gap: 10px;
}

.customer-avatar {
    width: 40px;
    height: 40px;

    border-radius: 50%;

    object-fit: cover;

    border: 1px solid #e5e7eb;

    flex-shrink: 0;
}

.customer-avatar-placeholder {
    width: 40px;
    height: 40px;

    border-radius: 50%;

    background: #fff3e8;
    color: #ff7a00;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 14px;
    font-weight: 700;

    flex-shrink: 0;
}

.customer-name {
    color: #1f2937;
    font-weight: 600;
}

.customer-email {
    color: #6b7280;
    font-size: 12px;

    margin-top: 3px;
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


/* VIEW */

.view-btn {
    background: #eef2ff;
    color: #4f46e5;
}

.view-btn:hover {
    background: #4f46e5;
    color: #ffffff;
}


/* EDIT */

.edit-btn {
    background: #fff3e8;
    color: #ff7a00;
}

.edit-btn:hover {
    background: #ff7a00;
    color: #ffffff;
}


/* TOGGLE */

.toggle-btn {
    background: #eef2ff;
    color: #4f46e5;
}

.toggle-btn:hover {
    background: #4f46e5;
    color: #ffffff;
}


/* DELETE */

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


/* SHOW ENTRIES */

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


/* SEARCH */

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


/* =========================================================
   PAGINATION
========================================================= */

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
            Customers
        </h2>

        <p>
            Manage all registered customers
        </p>

    </div>


    <a
        href="{{ route('admin.customers.create') }}"
        class="add-btn"
    >

        <i class="fa-solid fa-plus"></i>

        Add Customer

    </a>

</div>


{{-- SUCCESS MESSAGE --}}

@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


{{-- =========================================================
     CUSTOMER CARD
========================================================= --}}

<div class="customer-card">

    <div class="card-top">

        <h3>
            All Customers
        </h3>

        <span class="total-count">
            Total: {{ $customers->count() }}
        </span>

    </div>


    @if($customers->count())

        <div class="table-wrapper">

            <table
                id="customersTable"
                class="customer-table display"
                style="width:100%"
            >

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Phone
                        </th>

                        <th>
                            Orders
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Created
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($customers as $customer)

                        <tr>

                            {{-- ID --}}

                            <td>
                                {{ $customer->id }}
                            </td>


                            {{-- CUSTOMER --}}

                            <td>

                                <div class="customer-profile">

                                    @if($customer->profile_image)

                                        <img
                                            src="{{ asset('storage/' . $customer->profile_image) }}"
                                            class="customer-avatar"
                                            alt="{{ $customer->name }}"
                                        >

                                    @else

                                        <div class="customer-avatar-placeholder">

                                            {{ strtoupper(substr($customer->name, 0, 1)) }}

                                        </div>

                                    @endif


                                    <div>

                                        <div class="customer-name">
                                            {{ $customer->name }}
                                        </div>

                                        <div class="customer-email">
                                            {{ $customer->email }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- PHONE --}}

                            <td>
                                {{ $customer->phone ?? '-' }}
                            </td>


                            {{-- ORDERS --}}

                            <td>
                                {{ $customer->orders_count }}
                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if($customer->status)

                                    <span class="status-badge status-active">
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge status-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- CREATED --}}

                            <td data-order="{{ $customer->created_at->timestamp }}">

                                {{ $customer->created_at->format('d M Y') }}

                            </td>


                            {{-- ACTIONS --}}

                            <td>

                                <div class="action-wrapper">


                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route('admin.customers.show', $customer) }}"
                                        class="action-btn view-btn"
                                    >
                                        View
                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('admin.customers.edit', $customer) }}"
                                        class="action-btn edit-btn"
                                    >
                                        Edit
                                    </a>


                                    {{-- TOGGLE --}}

                                    <form
                                        action="{{ route('admin.customers.toggle-status', $customer) }}"
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
                                        action="{{ route('admin.customers.destroy', $customer) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this customer?')"
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
                No Customers Found
            </h3>

            <p>
                Start by creating your first customer.
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

    $('#customersTable').DataTable({

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
                targets: 1
            },

            {
                orderable: false,
                searchable: false,
                targets: 6
            }

        ],

        language: {

            search: "Search:",

            lengthMenu: "Show _MENU_ entries",

            info: "Showing _START_ to _END_ of _TOTAL_ customers",

            infoEmpty: "Showing 0 to 0 of 0 customers",

            infoFiltered: "(filtered from _MAX_ total customers)",

            zeroRecords: "No matching customers found",

            emptyTable: "No customers available",

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