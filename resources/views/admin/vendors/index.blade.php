@extends('layouts.admin')

@section('title', 'Vendors | NexaMart Admin')

@section('page-title', 'Vendors')

@section('page-subtitle', 'Manage all vendors and their shops')
{{-- DataTables CSS --}}
<link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css"
>
@section('content')

<style>

    .vendor-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .vendor-page-title h2 {
        font-size: 25px;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .vendor-page-title p {
        color: #6b7280;
        font-size: 13px;
    }

    .vendor-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 17px;
        border-radius: 7px;
        background: #ff7a00;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
    }

    .vendor-add-btn:hover {
        background: #e86f00;
        color: #fff;
    }

    .vendor-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }

    .vendor-card-top {
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;

        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .vendor-card-top h3 {
        font-size: 17px;
        color: #1f2937;
        margin: 0;
    }

    .vendor-total {
        color: #6b7280;
        font-size: 13px;
    }

    .vendor-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .vendor-table {
        width: 100% !important;
        min-width: 1250px;
        border-collapse: collapse;
    }

    .vendor-table th {
        background: #fafafa !important;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 14px 18px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .vendor-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
        vertical-align: middle;
    }

    .vendor-table tbody tr:hover {
        background: #fffaf5;
    }

    .vendor-shop-logo {
        width: 46px;
        height: 46px;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        padding: 4px;
        background: #fff;
    }

    .vendor-no-logo {
        width: 46px;
        height: 46px;
        border-radius: 8px;
        background: #f3f4f6;
        color: #9ca3af;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 10px;
    }

    .vendor-name {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 3px;
    }

    .vendor-email {
        color: #6b7280;
        font-size: 12px;
    }

    .vendor-shop-name {
        font-weight: 600;
        color: #374151;
    }

    .vendor-shop-slug {
        color: #9ca3af;
        font-size: 11px;
        margin-top: 3px;
    }

    .vendor-location {
        color: #374151;
    }

    .vendor-status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .vendor-active {
        background: #e9f8ef;
        color: #198754;
    }

    .vendor-inactive {
        background: #fdecec;
        color: #dc3545;
    }

    .vendor-actions {
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .vendor-actions form {
        margin: 0;
    }

    .vendor-action-btn {
        border: none;
        border-radius: 6px;
        padding: 7px 10px;
        font-size: 12px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .vendor-edit-btn {
        background: #fff3e8;
        color: #ff7a00;
    }

    .vendor-edit-btn:hover {
        background: #ff7a00;
        color: #fff;
    }

    .vendor-toggle-btn {
        background: #eef2ff;
        color: #4f46e5;
    }

    .vendor-toggle-btn:hover {
        background: #4f46e5;
        color: #fff;
    }

    .vendor-delete-btn {
        background: #fdecec;
        color: #dc3545;
    }

    .vendor-delete-btn:hover {
        background: #dc3545;
        color: #fff;
    }

    .vendor-empty {
        text-align: center;
        padding: 50px 20px;
        color: #6b7280;
    }

    .vendor-empty h3 {
        margin-bottom: 6px;
        color: #374151;
    }

    /*
    |--------------------------------------------------------------------------
    | DataTables
    |--------------------------------------------------------------------------
    */

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
        background: #fff;
        color: #374151;
        outline: none;
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
        background: #fff !important;
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
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        background: #f9fafb !important;
        border-color: #e5e7eb !important;
        color: #c1c5ca !important;
    }

    table.dataTable.no-footer {
        border-bottom: 0 !important;
    }

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

    }

    @media(max-width: 576px) {

        .vendor-page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .vendor-add-btn {
            justify-content: center;
        }

    }

</style>


<div class="vendor-page-header">

    <div class="vendor-page-title">

        <h2>
            Vendors
        </h2>

        <p>
            Manage all vendors and their shops
        </p>

    </div>


    <a
        href="{{ route('admin.vendors.create') }}"
        class="vendor-add-btn"
    >
        + Add Vendor
    </a>

</div>


<div class="vendor-card">

    <div class="vendor-card-top">

        <h3>
            All Vendors
        </h3>

        <span class="vendor-total">
            Total: {{ $vendors->count() }}
        </span>

    </div>


    @if($vendors->count())

        <div class="vendor-table-wrapper">

            <table
                id="vendorsTable"
                class="vendor-table display"
                style="width:100%"
            >

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Shop Logo</th>

                        <th>Vendor</th>

                        <th>Shop</th>

                        <th>Phone</th>

                        <th>Location</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($vendors as $vendor)

                        <tr>

                            <td>
                                {{ $vendor->id }}
                            </td>


                            <td>

                                @if($vendor->shop_logo)

                                    <img
                                        src="{{ asset('storage/' . $vendor->shop_logo) }}"
                                        alt="{{ $vendor->shop_name }}"
                                        class="vendor-shop-logo"
                                    >

                                @else

                                    <div class="vendor-no-logo">
                                        No Logo
                                    </div>

                                @endif

                            </td>


                            <td>

                                <div class="vendor-name">
                                    {{ $vendor->name }}
                                </div>

                                <div class="vendor-email">
                                    {{ $vendor->email }}
                                </div>

                            </td>


                            <td>

                                <div class="vendor-shop-name">
                                    {{ $vendor->shop_name }}
                                </div>

                                <div class="vendor-shop-slug">
                                    {{ $vendor->shop_slug }}
                                </div>

                            </td>


                            <td>
                                {{ $vendor->phone ?? '—' }}
                            </td>


                            <td>

                                <div class="vendor-location">

                                    {{ $vendor->city ?? '—' }}

                                    @if($vendor->state)
                                        , {{ $vendor->state }}
                                    @endif

                                </div>

                            </td>


                            <td>

                                @if($vendor->status)

                                    <span class="vendor-status vendor-active">
                                        Active
                                    </span>

                                @else

                                    <span class="vendor-status vendor-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <td data-order="{{ $vendor->created_at->timestamp }}">

                                {{ $vendor->created_at->format('d M Y') }}

                            </td>


                            <td>

                                <div class="vendor-actions">

                                    <a
                                        href="{{ route('admin.vendors.edit', $vendor) }}"
                                        class="vendor-action-btn vendor-edit-btn"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.vendors.toggle-status', $vendor) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="vendor-action-btn vendor-toggle-btn"
                                        >
                                            Toggle
                                        </button>

                                    </form>


                                    <form
                                        action="{{ route('admin.vendors.destroy', $vendor) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this vendor?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="vendor-action-btn vendor-delete-btn"
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

        <div class="vendor-empty">

            <h3>
                No Vendors Found
            </h3>

            <p>
                Start by creating your first vendor.
            </p>

        </div>

    @endif

</div>





{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


{{-- DataTables JS --}}
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>


<script>

    $(document).ready(function () {

        $('#vendorsTable').DataTable({

            responsive: false,

            autoWidth: false,

            scrollX: true,

            scrollCollapse: true,

            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],

            // ID ascending
            order: [
                [0, 'asc']
            ],

            columnDefs: [

                {
                    orderable: false,
                    searchable: false,
                    targets: [1]
                },

                {
                    orderable: false,
                    searchable: false,
                    targets: [8]
                }

            ],

            language: {

                search: "Search:",

                lengthMenu: "Show _MENU_ entries",

                info: "Showing _START_ to _END_ of _TOTAL_ vendors",

                infoEmpty: "Showing 0 to 0 of 0 vendors",

                infoFiltered: "(filtered from _MAX_ total vendors)",

                zeroRecords: "No matching vendors found",

                emptyTable: "No vendors available",

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