@extends('layouts.admin')

@section('title', 'Edit Product | NexaMart Admin')

@section('page-title', 'Edit Product')

@section('page-subtitle', 'Update product information')

@section('content')

<style>

.product-edit-card {
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:12px;
    max-width:1050px;
    overflow:hidden;
}

.product-edit-header {
    padding:20px 24px;
    border-bottom:1px solid #e5e7eb;
}

.product-edit-header h2 {
    font-size:18px;
    color:#1f2937;
    margin-bottom:5px;
}

.product-edit-header p {
    font-size:13px;
    color:#6b7280;
}

.product-edit-form {
    padding:24px;
}

.product-section {
    font-size:15px;
    font-weight:700;
    color:#1f2937;
    padding-bottom:10px;
    margin:5px 0 18px;
    border-bottom:1px solid #f0f0f0;
}

.product-grid {
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.product-group {
    margin-bottom:20px;
}

.product-group.full {
    grid-column:1/-1;
}

.product-group label {
    display:block;
    margin-bottom:7px;
    font-size:13px;
    font-weight:600;
    color:#374151;
}

.product-required {
    color:#dc3545;
}

.product-control {
    width:100%;
    padding:11px 13px;
    border:1px solid #d1d5db;
    border-radius:7px;
    outline:none;
    font-size:13px;
    color:#374151;
    background:#fff;
}

.product-control:focus {
    border-color:#ff7a00;
    box-shadow:0 0 0 3px rgba(255,122,0,.10);
}

textarea.product-control {
    min-height:120px;
    resize:vertical;
}

.product-file {
    padding:8px 10px;
}

.product-current-image {
    margin-bottom:12px;
}

.product-current-image img {
    width:100px;
    height:100px;
    object-fit:contain;
    border:1px solid #e5e7eb;
    border-radius:10px;
    padding:5px;
}

.product-no-image {
    color:#9ca3af;
    font-size:12px;
    margin-bottom:10px;
}

.product-error {
    color:#dc3545;
    font-size:12px;
    margin-top:6px;
}

.product-checks {
    display:flex;
    gap:30px;
    margin-bottom:20px;
}

.product-check {
    display:flex;
    align-items:center;
    gap:8px;
}

.product-check input {
    width:17px;
    height:17px;
    accent-color:#ff7a00;
}

.product-check label {
    margin:0;
    font-size:13px;
    cursor:pointer;
}

.product-actions {
    display:flex;
    gap:10px;
    margin-top:10px;
}

.product-btn {
    border:0;
    border-radius:7px;
    padding:11px 18px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    text-decoration:none;
}

.product-update {
    background:#ff7a00;
    color:#fff;
}

.product-update:hover {
    background:#e86f00;
}

.product-cancel {
    background:#f3f4f6;
    color:#374151;
}

@media(max-width:700px) {

    .product-grid {
        grid-template-columns:1fr;
    }

    .product-group.full {
        grid-column:auto;
    }

    .product-checks {
        flex-direction:column;
        gap:12px;
    }

}

</style>


<div class="product-edit-card">

    <div class="product-edit-header">

        <h2>
            Edit Product
        </h2>

        <p>
            Update product information, pricing, stock and category details.
        </p>

    </div>


    <form
        action="{{ route('admin.products.update', $product) }}"
        method="POST"
        enctype="multipart/form-data"
        class="product-edit-form"
    >

        @csrf
        @method('PUT')


        <div class="product-section">
            Product Information
        </div>


        <div class="product-grid">

            <div class="product-group">

                <label>
                    Product Name <span class="product-required">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    class="product-control"
                    value="{{ old('name', $product->name) }}"
                    required
                >

                @error('name')
                    <div class="product-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="product-group">

                <label>
                    SKU <span class="product-required">*</span>
                </label>

                <input
                    type="text"
                    name="sku"
                    class="product-control"
                    value="{{ old('sku', $product->sku) }}"
                    required
                >

                @error('sku')
                    <div class="product-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="product-group full">

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                    class="product-control"
                >{{ old('description', $product->description) }}</textarea>

            </div>

        </div>


        <div class="product-section">
            Category & Ownership
        </div>


        <div class="product-grid">

            <div class="product-group">

                <label>
                    Category <span class="product-required">*</span>
                </label>

                <select
                    name="category_id"
                    class="product-control"
                    required
                >

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="product-group">

                <label>
                    Sub Category
                </label>

                <select
                    name="sub_category_id"
                    class="product-control"
                >

                    <option value="">
                        Select Sub Category
                    </option>

                    @foreach($subCategories as $subCategory)

                        <option
                            value="{{ $subCategory->id }}"
                            {{ old('sub_category_id', $product->sub_category_id) == $subCategory->id ? 'selected' : '' }}
                        >
                            {{ $subCategory->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="product-group">

                <label>
                    Brand
                </label>

                <select
                    name="brand_id"
                    class="product-control"
                >

                    <option value="">
                        Select Brand
                    </option>

                    @foreach($brands as $brand)

                        <option
                            value="{{ $brand->id }}"
                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}
                        >
                            {{ $brand->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="product-group">

                <label>
                    Vendor
                </label>

                <select
                    name="vendor_id"
                    class="product-control"
                >

                    <option value="">
                        Select Vendor
                    </option>

                    @foreach($vendors as $vendor)

                        <option
                            value="{{ $vendor->id }}"
                            {{ old('vendor_id', $product->vendor_id) == $vendor->id ? 'selected' : '' }}
                        >
                            {{ $vendor->name }} — {{ $vendor->shop_name }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        <div class="product-section">
            Pricing & Stock
        </div>


        <div class="product-grid">

            <div class="product-group">

                <label>
                    Price <span class="product-required">*</span>
                </label>

                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="price"
                    class="product-control"
                    value="{{ old('price', $product->price) }}"
                    required
                >

            </div>


            <div class="product-group">

                <label>
                    Sale Price
                </label>

                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="sale_price"
                    class="product-control"
                    value="{{ old('sale_price', $product->sale_price) }}"
                >

            </div>


            <div class="product-group">

                <label>
                    Stock <span class="product-required">*</span>
                </label>

                <input
                    type="number"
                    min="0"
                    name="stock"
                    class="product-control"
                    value="{{ old('stock', $product->stock) }}"
                    required
                >

            </div>

        </div>


        <div class="product-section">
            Product Image
        </div>


        <div class="product-group">

            <label>
                Current Thumbnail
            </label>

            @if($product->thumbnail)

                <div class="product-current-image">

                    <img
                        src="{{ asset('storage/' . $product->thumbnail) }}"
                        alt="{{ $product->name }}"
                    >

                </div>

            @else

                <div class="product-no-image">
                    No thumbnail uploaded.
                </div>

            @endif


            <label for="thumbnail">
                Change Thumbnail
            </label>

            <input
                type="file"
                id="thumbnail"
                name="thumbnail"
                class="product-control product-file"
                accept=".jpg,.jpeg,.png,.webp"
            >

            <div style="font-size:11px;color:#6b7280;margin-top:6px;">
                Leave empty to keep current image. Maximum 2MB.
            </div>

            @error('thumbnail')
                <div class="product-error">{{ $message }}</div>
            @enderror

        </div>


        <div class="product-section">
            Status
        </div>


        <div class="product-checks">

            <div class="product-check">

                <input
                    type="checkbox"
                    id="status"
                    name="status"
                    value="1"
                    {{ old('status', $product->status) ? 'checked' : '' }}
                >

                <label for="status">
                    Active Product
                </label>

            </div>


            <div class="product-check">

                <input
                    type="checkbox"
                    id="featured"
                    name="featured"
                    value="1"
                    {{ old('featured', $product->featured) ? 'checked' : '' }}
                >

                <label for="featured">
                    Featured Product
                </label>

            </div>

        </div>


        <div class="product-actions">

            <a
                href="{{ route('admin.products.index') }}"
                class="product-btn product-cancel"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="product-btn product-update"
            >
                Update Product
            </button>

        </div>

    </form>

</div>

@endsection