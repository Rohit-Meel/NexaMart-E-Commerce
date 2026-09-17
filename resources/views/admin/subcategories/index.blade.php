@extends('layouts.admin')

@section('title', 'Sub Categories | NexaMart Admin')

@section('page-title', 'Sub Categories')

@section('page-subtitle', 'Manage all product sub-categories')
{{-- DataTables CSS --}}
<link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css"
>
@section('content')

<style>

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
    }

    .add-btn:hover {
        background: #e86f00;
        color: #ffffff;
    }

    .subcategory-card {
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

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .subcategory-table {
        width: 100% !important;
        min-width: 1000px;
        border-collapse: collapse;
    }

    .subcategory-table th {
        background: #fafafa !important;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 14px 18px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .subcategory-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
        vertical-align: middle;
    }

    .subcategory-table tbody tr:hover {
        background: #fffaf5;
    }

    .subcategory-image {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
    }

    .no-image {
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

    .subcategory-name {
        color: #1f2937;
        font-weight: 600;
    }

    .subcategory-description {
        color: #6b7280;
        font-size: 12px;
        margin-top: 4px;
    }

    .category-name {
        color: #ff7a00;
        font-weight: 600;
    }

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

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #6b7280;
    }

    .empty-state h3 {
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

        .page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .add-btn {
            justify-content: center;
        }

    }

</style>


<div class="page-header">

    <div class="page-title">

        <h2>
            Sub Categories
        </h2>

        <p>
            Manage all product sub-categories
        </p>

    </div>

    <a
        href="{{ route('admin.subcategories.create') }}"
        class="add-btn"
    >
        + Add Sub Category
    </a>

</div>


<div class="subcategory-card">

    <div class="card-top">

        <h3>
            All Sub Categories
        </h3>

        <span class="total-count">
            Total: {{ $subCategories->count() }}
        </span>

    </div>


    @if($subCategories->count())

        <div class="table-wrapper">

            <table
                id="subcategoriesTable"
                class="subcategory-table display"
                style="width:100%"
            >

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Image</th>

                        <th>Sub Category</th>

                        <th>Category</th>

                        <th>Slug</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($subCategories as $subCategory)

                        <tr>

                            <td>
                                {{ $subCategory->id }}
                            </td>


                            <td>

                                @if($subCategory->image)

                                    <img
                                        src="{{ asset('assets/images/subcategories/' . $subCategory->image) }}"
                                        class="subcategory-image"
                                        alt="{{ $subCategory->name }}"
                                    >

                                @else

                                    <div class="no-image">
                                        No Image
                                    </div>

                                @endif

                            </td>


                            <td>

                                <div class="subcategory-name">
                                    {{ $subCategory->name }}
                                </div>

                                @if($subCategory->description)

                                    <div class="subcategory-description">
                                        {{ Str::limit($subCategory->description, 40) }}
                                    </div>

                                @endif

                            </td>


                            <td>

                                <div class="category-name">
                                    {{ $subCategory->category->name ?? 'N/A' }}
                                </div>

                            </td>


                            <td>
                                {{ $subCategory->slug }}
                            </td>


                            <td>

                                @if($subCategory->status)

                                    <span class="status-badge status-active">
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge status-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <td data-order="{{ $subCategory->created_at->timestamp }}">

                                {{ $subCategory->created_at->format('d M Y') }}

                            </td>


                            <td>

                                <div class="action-wrapper">

                                    <a
                                        href="{{ route('admin.subcategories.edit', $subCategory) }}"
                                        class="action-btn edit-btn"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.subcategories.toggle-status', $subCategory) }}"
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
                                        action="{{ route('admin.subcategories.destroy', $subCategory) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this sub-category?')"
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
                No Sub Categories Found
            </h3>

            <p>
                Start by creating your first sub-category.
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

        $('#subcategoriesTable').DataTable({

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
                    targets: [1]
                },

                {
                    orderable: false,
                    searchable: false,
                    targets: [7]
                }

            ],

            language: {

                search: "Search:",

                lengthMenu: "Show _MENU_ entries",

                info: "Showing _START_ to _END_ of _TOTAL_ sub-categories",

                infoEmpty: "Showing 0 to 0 of 0 sub-categories",

                infoFiltered: "(filtered from _MAX_ total sub-categories)",

                zeroRecords: "No matching sub-categories found",

                emptyTable: "No sub-categories available",

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