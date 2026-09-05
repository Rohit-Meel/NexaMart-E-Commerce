@extends('layouts.admin')

@section('title', 'Edit Vendor | NexaMart Admin')

@section('page-title', 'Edit Vendor')

@section('page-subtitle', 'Update vendor and shop information')

@section('content')

<style>

    .vendor-edit-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        max-width: 1000px;
    }

    .vendor-edit-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .vendor-edit-header h2 {
        font-size: 18px;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .vendor-edit-header p {
        font-size: 13px;
        color: #6b7280;
    }

    .vendor-edit-form {
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

    .vendor-edit-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .vendor-edit-group {
        margin-bottom: 20px;
    }

    .vendor-edit-group.full {
        grid-column: 1 / -1;
    }

    .vendor-edit-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .vendor-required {
        color: #dc3545;
    }

    .vendor-edit-control {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        outline: none;
        font-size: 13px;
        color: #374151;
        background: #fff;
    }

    .vendor-edit-control:focus {
        border-color: #ff7a00;
        box-shadow: 0 0 0 3px rgba(255, 122, 0, .10);
    }

    textarea.vendor-edit-control {
        min-height: 110px;
        resize: vertical;
    }

    .vendor-file {
        padding: 8px 10px;
    }

    .vendor-current-logo {
        margin-bottom: 12px;
    }

    .vendor-current-logo img {
        width: 100px;
        height: 100px;
        object-fit: contain;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 5px;
        background: #fff;
    }

    .vendor-no-current-logo {
        color: #9ca3af;
        font-size: 12px;
        margin-bottom: 10px;
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

    .vendor-edit-actions {
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

    .vendor-update-btn {
        background: #ff7a00;
        color: #fff;
    }

    .vendor-update-btn:hover {
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

        .vendor-edit-grid {
            grid-template-columns: 1fr;
        }

        .vendor-edit-group.full {
            grid-column: auto;
        }

    }

</style>


<div class="vendor-edit-card">

    <div class="vendor-edit-header">

        <h2>
            Edit Vendor
        </h2>

        <p>
            Update vendor account, shop and address information.
        </p>

    </div>


    <form
        action="{{ route('admin.vendors.update', $vendor) }}"
        method="POST"
        enctype="multipart/form-data"
        class="vendor-edit-form"
    >

        @csrf

        @method('PUT')


        {{-- VENDOR INFORMATION --}}

        <div class="vendor-section-title">
            Vendor Information
        </div>


        <div class="vendor-edit-grid">

            <div class="vendor-edit-group">

                <label for="name">
                    Vendor Name <span class="vendor-required">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    class="vendor-edit-control"
                    value="{{ old('name', $vendor->name) }}"
                    required
                >

                @error('name')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-edit-group">

                <label for="email">
                    Email <span class="vendor-required">*</span>
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="vendor-edit-control"
                    value="{{ old('email', $vendor->email) }}"
                    required
                >

                @error('email')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-edit-group">

                <label for="phone">
                    Phone
                </label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="vendor-edit-control"
                    value="{{ old('phone', $vendor->phone) }}"
                >

            </div>


            <div class="vendor-edit-group">

                <label for="password">
                    New Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="vendor-edit-control"
                    placeholder="Leave blank to keep current password"
                >

                <div class="vendor-help">
                    Leave blank if you don't want to change the password.
                </div>

                @error('password')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-edit-group">

                <label for="password_confirmation">
                    Confirm New Password
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="vendor-edit-control"
                    placeholder="Confirm new password"
                >

            </div>

        </div>


        {{-- SHOP INFORMATION --}}

        <div class="vendor-section-title">
            Shop Information
        </div>


        <div class="vendor-edit-grid">

            <div class="vendor-edit-group">

                <label for="shop_name">
                    Shop Name <span class="vendor-required">*</span>
                </label>

                <input
                    type="text"
                    id="shop_name"
                    name="shop_name"
                    class="vendor-edit-control"
                    value="{{ old('shop_name', $vendor->shop_name) }}"
                    required
                >

                @error('shop_name')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-edit-group">

                <label>
                    Current Shop Logo
                </label>

                @if($vendor->shop_logo)

                    <div class="vendor-current-logo">

                        <img
                            src="{{ asset('storage/' . $vendor->shop_logo) }}"
                            alt="{{ $vendor->shop_name }}"
                        >

                    </div>

                @else

                    <div class="vendor-no-current-logo">
                        No shop logo uploaded.
                    </div>

                @endif

            </div>


            <div class="vendor-edit-group">

                <label for="shop_logo">
                    Change Shop Logo
                </label>

                <input
                    type="file"
                    id="shop_logo"
                    name="shop_logo"
                    class="vendor-edit-control vendor-file"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <div class="vendor-help">
                    Leave empty to keep current logo.
                    Maximum 2MB.
                </div>

                @error('shop_logo')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>


            <div class="vendor-edit-group full">

                <label for="shop_description">
                    Shop Description
                </label>

                <textarea
                    id="shop_description"
                    name="shop_description"
                    class="vendor-edit-control"
                >{{ old('shop_description', $vendor->shop_description) }}</textarea>

                @error('shop_description')
                    <div class="vendor-error">{{ $message }}</div>
                @enderror

            </div>

        </div>


        {{-- ADDRESS --}}

        <div class="vendor-section-title">
            Address Information
        </div>


        <div class="vendor-edit-grid">

            <div class="vendor-edit-group full">

                <label for="address">
                    Address
                </label>

                <input
                    type="text"
                    id="address"
                    name="address"
                    class="vendor-edit-control"
                    value="{{ old('address', $vendor->address) }}"
                >

            </div>


            <div class="vendor-edit-group">

                <label for="city">
                    City
                </label>

                <input
                    type="text"
                    id="city"
                    name="city"
                    class="vendor-edit-control"
                    value="{{ old('city', $vendor->city) }}"
                >

            </div>


            <div class="vendor-edit-group">

                <label for="state">
                    State
                </label>

                <input
                    type="text"
                    id="state"
                    name="state"
                    class="vendor-edit-control"
                    value="{{ old('state', $vendor->state) }}"
                >

            </div>


            <div class="vendor-edit-group">

                <label for="pincode">
                    Pincode
                </label>

                <input
                    type="text"
                    id="pincode"
                    name="pincode"
                    class="vendor-edit-control"
                    value="{{ old('pincode', $vendor->pincode) }}"
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
                {{ old('status', $vendor->status) ? 'checked' : '' }}
            >

            <label for="status">
                Active Vendor
            </label>

        </div>


        {{-- ACTIONS --}}

        <div class="vendor-edit-actions">

            <a
                href="{{ route('admin.vendors.index') }}"
                class="vendor-btn vendor-cancel-btn"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="vendor-btn vendor-update-btn"
            >
                Update Vendor
            </button>

        </div>

    </form>

</div>

@endsection