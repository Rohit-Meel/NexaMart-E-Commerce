@extends('layouts.admin')

@section('title', 'Edit Customer | NexaMart Admin')

@section('page-title', 'Edit Customer')

@section('page-subtitle', 'Update customer information')

@section('content')

<style>

.customer-form-card {
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:12px;
    padding:25px;
}

.form-grid {
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.form-group {
    display:flex;
    flex-direction:column;
    gap:7px;
}

.form-group.full {
    grid-column:1/-1;
}

.form-group label {
    font-size:13px;
    font-weight:600;
    color:#374151;
}

.form-group input {
    padding:10px 12px;
    border:1px solid #d1d5db;
    border-radius:7px;
    outline:none;
    font-size:13px;
}

.form-group input:focus {
    border-color:#ff7a00;
}

.current-image {
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:50%;
    margin-bottom:5px;
}

.error-text {
    color:#dc3545;
    font-size:12px;
}

.form-check {
    display:flex;
    align-items:center;
    gap:8px;
}

.form-actions {
    margin-top:25px;
    display:flex;
    gap:10px;
}

.update-btn {
    padding:10px 18px;
    border:0;
    border-radius:7px;
    background:#ff7a00;
    color:#fff;
    font-weight:600;
    cursor:pointer;
}

.cancel-btn {
    padding:10px 18px;
    border-radius:7px;
    background:#f3f4f6;
    color:#374151;
    text-decoration:none;
    font-size:13px;
}

@media(max-width:768px) {

    .form-grid {
        grid-template-columns:1fr;
    }

    .form-group.full {
        grid-column:auto;
    }

}

</style>


<div class="customer-form-card">

    <form
        action="{{ route('admin.customers.update', $customer) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')


        <div class="form-grid">


            <div class="form-group">

                <label>
                    Name *
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $customer->name) }}"
                    required
                >

                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror

            </div>


            <div class="form-group">

                <label>
                    Email *
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $customer->email) }}"
                    required
                >

                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror

            </div>


            <div class="form-group">

                <label>
                    Phone
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $customer->phone) }}"
                >

            </div>


            <div class="form-group">

                <label>
                    Profile Image
                </label>

                @if($customer->profile_image)

                    <img
                        src="{{ asset('storage/' . $customer->profile_image) }}"
                        class="current-image"
                    >

                @endif

                <input
                    type="file"
                    name="profile_image"
                    accept="image/*"
                >

            </div>


            <div class="form-group">

                <label>
                    New Password
                </label>

                <input
                    type="password"
                    name="password"
                >

                <small>
                    Leave blank to keep current password.
                </small>

            </div>


            <div class="form-group">

                <label>
                    Confirm New Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                >

            </div>


            <div class="form-group full">

                <label>
                    Status
                </label>

                <div class="form-check">

                    <input
                        type="checkbox"
                        name="status"
                        value="1"
                        @checked($customer->status)
                    >

                    <span>
                        Active
                    </span>

                </div>

            </div>


        </div>


        <div class="form-actions">

            <button
                type="submit"
                class="update-btn"
            >
                Update Customer
            </button>


            <a
                href="{{ route('admin.customers.index') }}"
                class="cancel-btn"
            >
                Cancel
            </a>

        </div>


    </form>

</div>

@endsection