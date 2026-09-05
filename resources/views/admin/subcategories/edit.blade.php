@extends('layouts.admin')

@section('title', 'Edit Sub Category | NexaMart Admin')

@section('page-title', 'Edit Sub Category')

@section('page-subtitle', 'Update sub-category information')

@section('content')

<style>

    .form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        max-width: 900px;
    }

    .form-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-card-header h2 {
        font-size: 18px;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .form-card-header p {
        font-size: 13px;
        color: #6b7280;
    }

    .subcategory-form {
        padding: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .required {
        color: #dc3545;
    }

    .form-control {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        outline: none;
        font-size: 13px;
        color: #374151;
        background: #ffffff;
    }

    .form-control:focus {
        border-color: #ff7a00;
        box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.10);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .image-input {
        padding: 8px 10px;
    }

    .current-image img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
    }

    .image-help {
        margin-top: 6px;
        font-size: 11px;
        color: #6b7280;
    }

    .status-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-box input {
        width: 17px;
        height: 17px;
        accent-color: #ff7a00;
        cursor: pointer;
    }

    .status-box label {
        margin: 0;
        cursor: pointer;
    }

    .error-message {
        margin-top: 6px;
        color: #dc3545;
        font-size: 12px;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn {
        border: none;
        border-radius: 7px;
        padding: 11px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background: #ff7a00;
        color: #ffffff;
    }

    .btn-primary:hover {
        background: #e86f00;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

</style>


<div class="form-card">

    <div class="form-card-header">

        <h2>
            Edit Sub Category
        </h2>

        <p>
            Update the details of this sub-category.
        </p>

    </div>


    <form
        action="{{ route('admin.subcategories.update', $subCategory) }}"
        method="POST"
        enctype="multipart/form-data"
        class="subcategory-form"
    >

        @csrf

        @method('PUT')


        <div class="form-group">

            <label for="category_id">
                Parent Category <span class="required">*</span>
            </label>

            <select
                id="category_id"
                name="category_id"
                class="form-control"
                required
            >

                <option value="">
                    Select Category
                </option>

                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id', $subCategory->category_id) == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

            @error('category_id')

                <div class="error-message">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="form-group">

            <label for="name">
                Sub Category Name <span class="required">*</span>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name', $subCategory->name) }}"
                required
            >

            @error('name')

                <div class="error-message">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="form-group">

            <label for="description">
                Description
            </label>

            <textarea
                id="description"
                name="description"
                class="form-control"
            >{{ old('description', $subCategory->description) }}</textarea>

            @error('description')

                <div class="error-message">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="form-group">

            <label>
                Current Image
            </label>

            @if($subCategory->image)

                <div class="current-image">

                    <img
                        src="{{ asset('storage/' . $subCategory->image) }}"
                        alt="{{ $subCategory->name }}"
                    >

                </div>

            @else

                <div class="image-help">
                    No image uploaded.
                </div>

            @endif

        </div>


        <div class="form-group">

            <label for="image">
                Change Image
            </label>

            <input
                type="file"
                id="image"
                name="image"
                class="form-control image-input"
                accept=".jpg,.jpeg,.png,.webp"
            >

            <div class="image-help">
                Leave empty to keep the current image.
                Maximum size: 2MB.
            </div>

            @error('image')

                <div class="error-message">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="form-group">

            <div class="status-box">

                <input
                    type="checkbox"
                    id="status"
                    name="status"
                    value="1"
                    {{ old('status', $subCategory->status) ? 'checked' : '' }}
                >

                <label for="status">
                    Active Sub Category
                </label>

            </div>

        </div>


        <div class="form-actions">

            <a
                href="{{ route('admin.subcategories.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Sub Category
            </button>

        </div>


    </form>

</div>

@endsection