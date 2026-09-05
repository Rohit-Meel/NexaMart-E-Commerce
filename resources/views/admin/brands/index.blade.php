@extends('layouts.admin')

@section('title', 'Brands | NexaMart Admin')

@section('page-title', 'Brands')

@section('page-subtitle', 'Manage all product brands')
<link
    rel="stylesheet"
    href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css"
>
@section('content')

<style>

    .brand-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .brand-page-title h2 {
        font-size: 25px;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .brand-page-title p {
        color: #6b7280;
        font-size: 13px;
    }

    .brand-add-btn {
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
    }

    .brand-add-btn:hover {
        background: #e86f00;
        color: #ffffff;
    }

    .brand-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }

    .brand-card-top {
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;

        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .brand-card-top h3 {
        font-size: 17px;
        color: #1f2937;
        margin: 0;
    }

    .brand-total {
        color: #6b7280;
        font-size: 13px;
    }

    .brand-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .brand-table {
        width: 100% !important;
        min-width: 950px;
        border-collapse: collapse;
    }

    .brand-table th {
        background: #fafafa !important;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 14px 18px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .brand-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
        vertical-align: middle;
    }

    .brand-table tbody tr:hover {
        background: #fffaf5;
    }

    .brand-logo {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        object-fit: contain;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        padding: 4px;
    }

    .brand-no-logo {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        background: #f3f4f6;
        color: #9ca3af;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 11px;
    }

    .brand-name {
        color: #1f2937;
        font-weight: 600;
    }

    .brand-description {
        color: #6b7280;
        font-size: 12px;
        margin-top: 4px;
    }

    .brand-slug {
        color: #374151;
    }

    .brand-status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .brand-active {
        background: #e9f8ef;
        color: #198754;
    }

    .brand-inactive {
        background: #fdecec;
        color: #dc3545;
    }

    .brand-actions {
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .brand-actions form {
        margin: 0;
    }

    .brand-action-btn {
        border: none;
        border-radius: 6px;
        padding: 7px 10px;
        font-size: 12px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .brand-edit-btn {
        background: #fff3e8;
        color: #ff7a00;
    }

    .brand-edit-btn:hover {
        background: #ff7a00;
        color: #ffffff;
    }

    .brand-toggle-btn {
        background: #eef2ff;
        color: #4f46e5;
    }

    .brand-toggle-btn:hover {
        background: #4f46e5;
        color: #ffffff;
    }

    .brand-delete-btn {
        background: #fdecec;
        color: #dc3545;
    }

    .brand-delete-btn:hover {
        background: #dc3545;
        color: #ffffff;
    }

    .brand-empty {
        text-align: center;
        padding: 50px 20px;
        color: #6b7280;
    }

    .brand-empty h3 {
        margin-bottom: 6px;
        color: #374151;
    }

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

        .brand-page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .brand-add-btn {
            justify-content: center;
        }

    }

</style>


<div class="brand-page-header">

    <div class="brand-page-title">

        <h2>
            Brands
        </h2>

        <p>
            Manage all product brands
        </p>

    </div>

    <a
        href="{{ route('admin.brands.create') }}"
        class="brand-add-btn"
    >
        + Add Brand
    </a>

</div>


<div class="brand-card">

    <div class="brand-card-top">

        <h3>
            All Brands
        </h3>

        <span class="brand-total">
            Total: {{ $brands->count() }}
        </span>

    </div>


    @if($brands->count())

        <div class="brand-table-wrapper">

            <table
                id="brandsTable"
                class="brand-table display"
                style="width:100%"
            >

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Logo</th>

                        <th>Brand</th>

                        <th>Slug</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($brands as $brand)

                        <tr>

                            <td>
                                {{ $brand->id }}
                            </td>


                            <td>

                                @if($brand->logo)

                                    <img
                                        src="{{ asset('storage/' . $brand->logo) }}"
                                        class="brand-logo"
                                        alt="{{ $brand->name }}"
                                    >

                                @else

                                    <div class="brand-no-logo">
                                        No Logo
                                    </div>

                                @endif

                            </td>


                            <td>

                                <div class="brand-name">
                                    {{ $brand->name }}
                                </div>

                                @if($brand->description)

                                    <div class="brand-description">
                                        {{ Str::limit($brand->description, 40) }}
                                    </div>

                                @endif

                            </td>


                            <td>

                                <span class="brand-slug">
                                    {{ $brand->slug }}
                                </span>

                            </td>


                            <td>

                                @if($brand->status)

                                    <span class="brand-status brand-active">
                                        Active
                                    </span>

                                @else

                                    <span class="brand-status brand-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <td data-order="{{ $brand->created_at->timestamp }}">

                                {{ $brand->created_at->format('d M Y') }}

                            </td>


                            <td>

                                <div class="brand-actions">

                                    <a
                                        href="{{ route('admin.brands.edit', $brand) }}"
                                        class="brand-action-btn brand-edit-btn"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.brands.toggle-status', $brand) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="brand-action-btn brand-toggle-btn"
                                        >
                                            Toggle
                                        </button>

                                    </form>


                                    <form
                                        action="{{ route('admin.brands.destroy', $brand) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this brand?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="brand-action-btn brand-delete-btn"
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

        <div class="brand-empty">

            <h3>
                No Brands Found
            </h3>

            <p>
                Start by creating your first brand.
            </p>

        </div>

    @endif

</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- DataTables JS --}}
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
<script>

    $(document).ready(function () {

        $('#brandsTable').DataTable({

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
                    targets: [6]
                }

            ],

            language: {

                search: "Search:",

                lengthMenu: "Show _MENU_ entries",

                info: "Showing _START_ to _END_ of _TOTAL_ brands",

                infoEmpty: "Showing 0 to 0 of 0 brands",

                infoFiltered: "(filtered from _MAX_ total brands)",

                zeroRecords: "No matching brands found",

                emptyTable: "No brands available",

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