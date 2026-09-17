@extends('layouts.admin')

@section('title', 'Products | NexaMart Admin')

@section('page-title', 'Products')

@section('page-subtitle', 'Manage all products')

@section('content')

<style>

.product-header {
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:25px;
}

.product-header h2 {
    font-size:25px;
    color:#1f2937;
    margin-bottom:5px;
}

.product-header p {
    color:#6b7280;
    font-size:13px;
}

.product-add-btn {
    display:inline-flex;
    align-items:center;
    gap:7px;
    padding:11px 17px;
    border-radius:7px;
    background:#ff7a00;
    color:#fff;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
}

.product-add-btn:hover {
    background:#e86f00;
    color:#fff;
}

.product-card {
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:12px;
    overflow:hidden;
}

.product-card-top {
    padding:18px 20px;
    border-bottom:1px solid #e5e7eb;

    display:flex;
    align-items:center;
    justify-content:space-between;
}

.product-card-top h3 {
    font-size:17px;
    color:#1f2937;
    margin:0;
}

.product-total {
    color:#6b7280;
    font-size:13px;
}

.product-table-wrapper {
    width:100%;
    overflow-x:auto;
}

.product-table {
    width:100% !important;
    min-width:1450px;
}

.product-table th {
    background:#fafafa !important;
    color:#6b7280;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    padding:14px 18px;
    border-bottom:1px solid #e5e7eb;
}

.product-table td {
    padding:14px 18px;
    border-bottom:1px solid #f0f0f0;
    font-size:13px;
    vertical-align:middle;
}

.product-table tbody tr:hover {
    background:#fffaf5;
}

.product-image {
    width:48px;
    height:48px;
    object-fit:contain;
    border:1px solid #e5e7eb;
    border-radius:8px;
    padding:4px;
}

.product-no-image {
    width:48px;
    height:48px;
    border-radius:8px;
    background:#f3f4f6;
    color:#9ca3af;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:10px;
}

.product-name {
    font-weight:600;
    color:#1f2937;
    margin-bottom:3px;
}

.product-sku {
    font-size:11px;
    color:#9ca3af;
}

.product-price {
    font-weight:600;
    color:#1f2937;
}

.product-sale-price {
    color:#198754;
    font-weight:600;
}

.product-old-price {
    color:#9ca3af;
    text-decoration:line-through;
    font-size:11px;
}

.product-status,
.product-featured {
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:700;
}

.product-active,
.product-featured-yes {
    background:#e9f8ef;
    color:#198754;
}

.product-inactive,
.product-featured-no {
    background:#fdecec;
    color:#dc3545;
}

.product-actions {
    display:flex;
    align-items:center;
    gap:7px;
    white-space:nowrap;
}

.product-actions form {
    margin:0;
}

.product-action-btn {
    border:none;
    border-radius:6px;
    padding:7px 10px;
    font-size:12px;
    cursor:pointer;
    text-decoration:none;
    display:inline-block;
}

.product-edit-btn {
    background:#fff3e8;
    color:#ff7a00;
}

.product-edit-btn:hover {
    background:#ff7a00;
    color:#fff;
}

.product-toggle-btn {
    background:#eef2ff;
    color:#4f46e5;
}

.product-toggle-btn:hover {
    background:#4f46e5;
    color:#fff;
}

.product-delete-btn {
    background:#fdecec;
    color:#dc3545;
}

.product-delete-btn:hover {
    background:#dc3545;
    color:#fff;
}

.dataTables_wrapper {
    padding:18px 20px 20px;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom:18px;
}

.dataTables_wrapper .dataTables_length label,
.dataTables_wrapper .dataTables_filter label {
    font-size:13px;
    color:#6b7280;
}

.dataTables_wrapper .dataTables_length select {
    margin:0 6px;
    padding:7px 30px 7px 10px;
    border:1px solid #d1d5db;
    border-radius:6px;
}

.dataTables_wrapper .dataTables_filter input {
    margin-left:7px;
    padding:8px 12px;
    width:220px;
    border:1px solid #d1d5db;
    border-radius:6px;
    outline:none;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-color:#ff7a00;
}

.dataTables_wrapper .dataTables_info {
    padding-top:16px;
    font-size:12px;
    color:#6b7280;
}

.dataTables_wrapper .dataTables_paginate {
    padding-top:12px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    min-width:34px;
    height:34px;
    line-height:32px;
    padding:0 9px !important;
    margin-left:4px;
    border:1px solid #e5e7eb !important;
    border-radius:6px !important;
    background:#fff !important;
    color:#374151 !important;
    font-size:12px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background:#fff3e8 !important;
    border-color:#ff7a00 !important;
    color:#ff7a00 !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background:#ff7a00 !important;
    border-color:#ff7a00 !important;
    color:#fff !important;
}

table.dataTable.no-footer {
    border-bottom:0 !important;
}

</style>


<div class="product-header">

    <div>

        <h2>
            Products
        </h2>

        <p>
            Manage all products in your store
        </p>

    </div>

    <a
        href="{{ route('admin.products.create') }}"
        class="product-add-btn"
    >
        + Add Product
    </a>

</div>


<div class="product-card">

    <div class="product-card-top">

        <h3>
            All Products
        </h3>

        <span class="product-total">
            Total: {{ $products->count() }}
        </span>

    </div>


    <div class="product-table-wrapper">

        <table
            id="productsTable"
            class="product-table display"
            style="width:100%"
        >

            <thead>

                <tr>

                    <th>#</th>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Brand</th>
                    <th>Vendor</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Actions</th>

                </tr>

            </thead>


            <tbody>

                @foreach($products as $product)

                    <tr>

                        <td>
                            {{ $product->id }}
                        </td>


                        <td>

                            @if($product->thumbnail)

                                <img
                                     src="{{ asset('assets/images/products/' . $product->thumbnail) }}"
                                    class="product-image"
                                    alt="{{ $product->name }}"
                                >

                            @else

                                <div class="product-no-image">
                                    No Image
                                </div>

                            @endif

                        </td>


                        <td>

                            <div class="product-name">
                                {{ $product->name }}
                            </div>

                            <div class="product-sku">
                                SKU: {{ $product->sku }}
                            </div>

                        </td>


                        <td>
                            {{ $product->category->name ?? '—' }}
                        </td>


                        <td>
                            {{ $product->subCategory->name ?? '—' }}
                        </td>


                        <td>
                            {{ $product->brand->name ?? '—' }}
                        </td>


                        <td>
                            {{ $product->vendor->name ?? '—' }}
                        </td>


                        <td>

                            @if($product->sale_price)

                                <div class="product-sale-price">
                                    ₹{{ number_format($product->sale_price, 2) }}
                                </div>

                                <div class="product-old-price">
                                    ₹{{ number_format($product->price, 2) }}
                                </div>

                            @else

                                <div class="product-price">
                                    ₹{{ number_format($product->price, 2) }}
                                </div>

                            @endif

                        </td>


                        <td>
                            {{ $product->stock }}
                        </td>


                        <td>

                            @if($product->status)

                                <span class="product-status product-active">
                                    Active
                                </span>

                            @else

                                <span class="product-status product-inactive">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        <td>

                            @if($product->featured)

                                <span class="product-featured product-featured-yes">
                                    Yes
                                </span>

                            @else

                                <span class="product-featured product-featured-no">
                                    No
                                </span>

                            @endif

                        </td>


                        <td>

                            <div class="product-actions">

                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
                                    class="product-action-btn product-edit-btn"
                                >
                                    Edit
                                </a>


                                <form
                                    action="{{ route('admin.products.toggle-status', $product) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="product-action-btn product-toggle-btn"
                                    >
                                        Status
                                    </button>

                                </form>


                                <form
                                    action="{{ route('admin.products.toggle-featured', $product) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="product-action-btn product-toggle-btn"
                                    >
                                        Featured
                                    </button>

                                </form>


                                <form
                                    action="{{ route('admin.products.destroy', $product) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="product-action-btn product-delete-btn"
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

</div>


<link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css"
>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>


<script>

$(document).ready(function () {

    $('#productsTable').DataTable({

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
                targets: [11]
            }

        ],

        language: {

            search: "Search:",

            lengthMenu: "Show _MENU_ entries",

            info: "Showing _START_ to _END_ of _TOTAL_ products",

            infoEmpty: "Showing 0 to 0 of 0 products",

            infoFiltered: "(filtered from _MAX_ total products)",

            zeroRecords: "No matching products found",

            emptyTable: "No products available",

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