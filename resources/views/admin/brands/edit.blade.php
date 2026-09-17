@extends('layouts.admin')

@section('title', 'Edit Brand | NexaMart Admin')

@section('page-title', 'Edit Brand')

@section('page-subtitle', 'Update brand information')

@section('content')

<style>

    .brand-edit-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        max-width: 900px;
    }

    .brand-edit-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .brand-edit-header h2 {
        font-size: 18px;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .brand-edit-header p {
        font-size: 13px;
        color: #6b7280;
    }

    .brand-edit-form {
        padding: 24px;
    }

    .brand-edit-group {
        margin-bottom: 20px;
    }

    .brand-edit-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .brand-edit-required {
        color: #dc3545;
    }

    .brand-edit-control {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        outline: none;
        font-size: 13px;
        color: #374151;
        background: #ffffff;
    }

    .brand-edit-control:focus {
        border-color: #ff7a00;
        box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.10);
    }

    textarea.brand-edit-control {
        min-height: 120px;
        resize: vertical;
    }

    .brand-edit-file {
        padding: 8px 10px;
    }

    .brand-current-logo {
        margin-bottom: 10px;
    }

    .brand-current-logo img {
        width: 100px;
        height: 100px;
        object-fit: contain;
        padding: 5px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #ffffff;
    }

    .brand-image-help {
        margin-top: 6px;
        font-size: 11px;
        color: #6b7280;
    }

    .brand-status-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .brand-status-box input {
        width: 17px;
        height: 17px;
        accent-color: #ff7a00;
        cursor: pointer;
    }

    .brand-status-box label {
        margin: 0;
        cursor: pointer;
    }

    .brand-edit-error {
        margin-top: 6px;
        color: #dc3545;
        font-size: 12px;
    }

    .brand-edit-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .brand-edit-btn {
        border: none;
        border-radius: 7px;
        padding: 11px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }

    .brand-update-btn {
        background: #ff7a00;
        color: #ffffff;
    }

    .brand-update-btn:hover {
        background: #e86f00;
    }

    .brand-cancel-btn {
        background: #f3f4f6;
        color: #374151;
    }

    .brand-cancel-btn:hover {
        background: #e5e7eb;
    }

</style>


<div class="brand-edit-card">

    <div class="brand-edit-header">

        <h2>
            Edit Brand
        </h2>

        <p>
            Update the details of this brand.
        </p>

    </div>


    <form
        action="{{ route('admin.brands.update', $brand) }}"
        method="POST"
        enctype="multipart/form-data"
        class="brand-edit-form"
    >

        @csrf

        @method('PUT')


        <div class="brand-edit-group">

            <label for="name">
                Brand Name <span class="brand-edit-required">*</span>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="brand-edit-control"
                value="{{ old('name', $brand->name) }}"
                required
            >

            @error('name')

                <div class="brand-edit-error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="brand-edit-group">

            <label for="description">
                Description
            </label>

            <textarea
                id="description"
                name="description"
                class="brand-edit-control"
            >{{ old('description', $brand->description) }}</textarea>

            @error('description')

                <div class="brand-edit-error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="brand-edit-group">

            <label>
                Current Logo
            </label>

            @if($brand->logo)

                <div class="brand-current-logo">

                    <img
                       src="{{ asset('assets/images/brand/' . $brand->logo) }}"
                        alt="{{ $brand->name }}"
                    >

                </div>

            @else

                <div class="brand-image-help">
                    No logo uploaded.
                </div>

            @endif

        </div>


        <div class="brand-edit-group">

            <label for="logo">
                Change Logo
            </label>

            <input
                type="file"
                id="logo"
                name="logo"
                class="brand-edit-control brand-edit-file"
                accept=".jpg,.jpeg,.png,.webp"
            >

            <div class="brand-image-help">
                Leave empty to keep the current logo.
                Maximum size: 2MB.
            </div>

            @error('logo')

                <div class="brand-edit-error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="brand-edit-group">

            <div class="brand-status-box">

                <input
                    type="checkbox"
                    id="status"
                    name="status"
                    value="1"
                    {{ old('status', $brand->status) ? 'checked' : '' }}
                >

                <label for="status">
                    Active Brand
                </label>

            </div>

        </div>


        <div class="brand-edit-actions">

            <a
                href="{{ route('admin.brands.index') }}"
                class="brand-edit-btn brand-cancel-btn"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="brand-edit-btn brand-update-btn"
            >
                Update Brand
            </button>

        </div>

    </form>

</div>

@endsection