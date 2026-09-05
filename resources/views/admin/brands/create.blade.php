@extends('layouts.admin')

@section('title', 'Add Brand | NexaMart Admin')

@section('page-title', 'Add Brand')

@section('page-subtitle', 'Create a new product brand')

@section('content')

<style>

    .brand-form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        max-width: 900px;
    }

    .brand-form-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .brand-form-header h2 {
        font-size: 18px;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .brand-form-header p {
        font-size: 13px;
        color: #6b7280;
    }

    .brand-form {
        padding: 24px;
    }

    .brand-form-group {
        margin-bottom: 20px;
    }

    .brand-form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .brand-required {
        color: #dc3545;
    }

    .brand-form-control {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        outline: none;
        font-size: 13px;
        color: #374151;
        background: #ffffff;
    }

    .brand-form-control:focus {
        border-color: #ff7a00;
        box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.10);
    }

    textarea.brand-form-control {
        min-height: 120px;
        resize: vertical;
    }

    .brand-file-input {
        padding: 8px 10px;
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

    .brand-error {
        margin-top: 6px;
        color: #dc3545;
        font-size: 12px;
    }

    .brand-form-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .brand-btn {
        border: none;
        border-radius: 7px;
        padding: 11px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }

    .brand-btn-primary {
        background: #ff7a00;
        color: #ffffff;
    }

    .brand-btn-primary:hover {
        background: #e86f00;
    }

    .brand-btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .brand-btn-secondary:hover {
        background: #e5e7eb;
    }

</style>


<div class="brand-form-card">

    <div class="brand-form-header">

        <h2>
            Create Brand
        </h2>

        <p>
            Add a new brand to your store.
        </p>

    </div>


    <form
        action="{{ route('admin.brands.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="brand-form"
    >

        @csrf


        <div class="brand-form-group">

            <label for="name">
                Brand Name <span class="brand-required">*</span>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="brand-form-control"
                value="{{ old('name') }}"
                placeholder="Enter brand name"
                required
            >

            @error('name')

                <div class="brand-error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="brand-form-group">

            <label for="description">
                Description
            </label>

            <textarea
                id="description"
                name="description"
                class="brand-form-control"
                placeholder="Enter brand description"
            >{{ old('description') }}</textarea>

            @error('description')

                <div class="brand-error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="brand-form-group">

            <label for="logo">
                Brand Logo
            </label>

            <input
                type="file"
                id="logo"
                name="logo"
                class="brand-form-control brand-file-input"
                accept=".jpg,.jpeg,.png,.webp"
            >

            <div class="brand-image-help">
                Allowed: JPG, JPEG, PNG, WEBP. Maximum size: 2MB.
            </div>

            @error('logo')

                <div class="brand-error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="brand-form-group">

            <div class="brand-status-box">

                <input
                    type="checkbox"
                    id="status"
                    name="status"
                    value="1"
                    {{ old('status', 1) ? 'checked' : '' }}
                >

                <label for="status">
                    Active Brand
                </label>

            </div>

        </div>


        <div class="brand-form-actions">

            <a
                href="{{ route('admin.brands.index') }}"
                class="brand-btn brand-btn-secondary"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="brand-btn brand-btn-primary"
            >
                Save Brand
            </button>

        </div>

    </form>

</div>

@endsection