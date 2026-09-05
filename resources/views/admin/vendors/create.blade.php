@extends('layouts.admin')

@section('title', 'Add Vendor | NexaMart Admin')

@section('page-title', 'Add Vendor')

@section('page-subtitle', 'Create a new vendor and shop')

@section('content')

<style>

    .vendor-form-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        max-width: 1000px;
    }

    .vendor-form-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .vendor-form-header h2 {
        font-size: 18px;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .vendor-form-header p {
        font-size: 13px;
        color: #6b7280;
    }

    .vendor-form {
        padding: 24px;
    }

    .vendor-section-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
        margin: 5px 0 18px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }

    .vendor-form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .vendor-form-group {
        margin-bottom: 20px;
    }

    .vendor-form-group.full {
        grid-column: 1 / -1;
    }

    .vendor-form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .vendor-required {
        color: #dc3545;
    }

    .vendor-control {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        outline: none;
        font-size: 13px;
        color: #374151;
        background: #fff;
    }

    .vendor-control:focus {
        border-color: #ff7a00;
        box-shadow: 0 0 0 3px rgba(255, 122, 0, .10);
    }

    textarea.vendor-control {
        min-height: 110px;
        resize: vertical;
    }

    .vendor-file {
        padding: 8px 10px;
    }

    .vendor-help {
        margin-top: 6px;
        font-size: 11px;
        color: #6b7280;
    }

    .vendor-status-box {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .vendor-status-box input {
        width: 17px;
        height: 17px;
        accent-color: #ff7a00;
        cursor: pointer;
    }

    .vendor-status-box label {
        margin: 0;
        cursor: pointer;
    }

    .vendor-error {
        margin-top: 6px;
        color: #dc3545;
        font-size: 12px;
    }

    .vendor-actions {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .vendor-btn {
        border: none;
        border-radius: 7px;
        padding: 11px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }

    .vendor-save-btn {
        background: #ff7a00;
        color: #fff;
    }

    .vendor-save-btn:hover {
        background: #e86f00;
    }

    .vendor-cancel-btn {
        background: #f3f4f6;
        color: #374151;
    }

    .vendor-cancel-btn:hover {
        background: #e5e7eb;
    }

    @media(max-width: 700px) {

        .vendor-form-grid {
            grid-template-columns: 1fr;
        }

        .vendor-form-group.full {
            grid-column: auto;
        }

    }

</style>


<div class="vendor-form-card">

    <div class="vendor-form-header">

        <h2>
            Create Vendor
        </h2>

        <p>
            Add vendor account, shop and address information.
        </p>

    </div>


    <form
        action="{{ route('admin.vendors.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="vendor-form"
    >

        @csrf


        {{-- VENDOR INFORMATION --}}

        <div class="vendor-section-title">
            Vendor Information
        </div>


        <div class="vendor-form-grid">

            <div class="vendor-form-group">

                <label for="name">
                    Vendor Name <span class="vendor-required">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    class="vendor-control"
                    value="{{ old('name') }}"
                    placeholder="Enter vendor name"
                    required
                >

                @error('name')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-form-group">

                <label for="email">
                    Email <span class="vendor-required">*</span>
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="vendor-control"
                    value="{{ old('email') }}"
                    placeholder="vendor@example.com"
                    required
                >

                @error('email')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-form-group">

                <label for="phone">
                    Phone
                </label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="vendor-control"
                    value="{{ old('phone') }}"
                    placeholder="Enter phone number"
                >

                @error('phone')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-form-group">

                <label for="password">
                    Password <span class="vendor-required">*</span>
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="vendor-control"
                    placeholder="Enter password"
                    required
                >

                @error('password')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-form-group">

                <label for="password_confirmation">
                    Confirm Password <span class="vendor-required">*</span>
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="vendor-control"
                    placeholder="Confirm password"
                    required
                >

            </div>

        </div>


        {{-- SHOP INFORMATION --}}

        <div class="vendor-section-title">
            Shop Information
        </div>


        <div class="vendor-form-grid">

            <div class="vendor-form-group">

                <label for="shop_name">
                    Shop Name <span class="vendor-required">*</span>
                </label>

                <input
                    type="text"
                    id="shop_name"
                    name="shop_name"
                    class="vendor-control"
                    value="{{ old('shop_name') }}"
                    placeholder="Enter shop name"
                    required
                >

                @error('shop_name')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-form-group">

                <label for="shop_logo">
                    Shop Logo
                </label>

                <input
                    type="file"
                    id="shop_logo"
                    name="shop_logo"
                    class="vendor-control vendor-file"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <div class="vendor-help">
                    JPG, JPEG, PNG, WEBP — Maximum 2MB
                </div>

                @error('shop_logo')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-form-group full">

                <label for="shop_description">
                    Shop Description
                </label>

                <textarea
                    id="shop_description"
                    name="shop_description"
                    class="vendor-control"
                    placeholder="Enter shop description"
                >{{ old('shop_description') }}</textarea>

                @error('shop_description')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>

        </div>


        {{-- ADDRESS INFORMATION --}}

        <div class="vendor-section-title">
            Address Information
        </div>


        <div class="vendor-form-grid">

            <div class="vendor-form-group full">

                <label for="address">
                    Address
                </label>

                <input
                    type="text"
                    id="address"
                    name="address"
                    class="vendor-control"
                    value="{{ old('address') }}"
                    placeholder="Enter address"
                >

                @error('address')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-form-group">

                <label for="city">
                    City
                </label>

                <input
                    type="text"
                    id="city"
                    name="city"
                    class="vendor-control"
                    value="{{ old('city') }}"
                    placeholder="Enter city"
                >

            </div>


            <div class="vendor-form-group">

                <label for="state">
                    State
                </label>

                <input
                    type="text"
                    id="state"
                    name="state"
                    class="vendor-control"
                    value="{{ old('state') }}"
                    placeholder="Enter state"
                >

            </div>


            <div class="vendor-form-group">

                <label for="pincode">
                    Pincode
                </label>

                <input
                    type="text"
                    id="pincode"
                    name="pincode"
                    class="vendor-control"
                    value="{{ old('pincode') }}"
                    placeholder="Enter pincode"
                    maxlength="10"
                >

            </div>

        </div>


        {{-- STATUS --}}

        <div class="vendor-section-title">
            Status
        </div>


        <div class="vendor-status-box">

            <input
                type="checkbox"
                id="status"
                name="status"
                value="1"
                {{ old('status', 1) ? 'checked' : '' }}
            >

            <label for="status">
                Active Vendor
            </label>

        </div>


        {{-- ACTIONS --}}

        <div class="vendor-actions">

            <a
                href="{{ route('admin.vendors.index') }}"
                class="vendor-btn vendor-cancel-btn"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="vendor-btn vendor-save-btn"
            >
                Save Vendor
            </button>

        </div>

    </form>

</div>

@endsection