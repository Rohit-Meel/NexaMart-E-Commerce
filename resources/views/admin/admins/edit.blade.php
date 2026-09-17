@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('content')

<style>
    .admin-page {
        padding: 30px;
    }

    .admin-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .admin-header-left h2 {
        margin: 0;
        font-size: 26px;
        color: #1f2937;
    }

    .admin-header-left p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 17px;
        background: #fff;
        color: #374151;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        text-decoration: none;
        font-size: 14px;
        transition: .2s;
    }

    .back-btn:hover {
        border-color: #ff7a00;
        color: #ff7a00;
    }

    .admin-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 30px;
        max-width: 950px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
    }

    .form-group label span {
        color: #dc3545;
    }

    .form-control {
        width: 100%;
        height: 44px;
        padding: 0 13px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: #fff;
        color: #374151;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
        transition: .2s;
    }

    .form-control:focus {
        border-color: #ff7a00;
        box-shadow: 0 0 0 3px rgba(255, 122, 0, .10);
    }

    select.form-control {
        cursor: pointer;
    }

    .password-wrapper {
        position: relative;
    }

    .password-wrapper .form-control {
        padding-right: 45px;
    }

    .password-toggle {
        position: absolute;
        right: 13px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
        font-size: 15px;
    }

    .password-toggle:hover {
        color: #ff7a00;
    }

    .hint {
        margin-top: 6px;
        color: #9ca3af;
        font-size: 12px;
    }

    .error-text {
        margin-top: 6px;
        color: #dc3545;
        font-size: 12px;
    }

    .alert {
        padding: 13px 16px;
        border-radius: 7px;
        margin-bottom: 22px;
        font-size: 14px;
    }

    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #e5e7eb;
    }

    .save-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-width: 125px;
        height: 43px;
        padding: 0 18px;
        background: #ff7a00;
        color: #fff;
        border: none;
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .save-btn:hover {
        background: #e86f00;
    }

    .cancel-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 95px;
        height: 43px;
        padding: 0 18px;
        background: #fff;
        color: #374151;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }

    .cancel-btn:hover {
        border-color: #9ca3af;
    }

    .current-admin-note {
        margin-bottom: 22px;
        padding: 12px 15px;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        color: #9a3412;
        border-radius: 7px;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .admin-page {
            padding: 20px;
        }

        .admin-header {
            align-items: flex-start;
            gap: 15px;
            flex-direction: column;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .admin-card {
            padding: 20px;
        }
    }
</style>

<div class="admin-page">

    <div class="admin-header">

        <div class="admin-header-left">
            <h2>Edit Admin</h2>
            <p>Update administrator account details.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Admins
        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

            <ul style="margin:8px 0 0 18px; padding:0;">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    @if(auth('admin')->id() === $admin->id)

        <div class="current-admin-note">
            <i class="fa-solid fa-circle-info"></i>
            You are editing your own admin account. Your account cannot be disabled or deleted.
        </div>

    @endif


    <div class="admin-card">

        <form action="{{ route('admin.admins.update', $admin) }}" method="POST">

            @csrf
            @method('PUT')


            <div class="form-grid">

                <!-- NAME -->

                <div class="form-group">

                    <label>
                        Admin Name <span>*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $admin->name) }}"
                        placeholder="Enter admin name"
                        required
                    >

                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror

                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label>
                        Email Address <span>*</span>
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $admin->email) }}"
                        placeholder="Enter email address"
                        required
                    >

                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror

                </div>


                <!-- PHONE -->

                <div class="form-group">

                    <label>
                        Phone Number
                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ old('phone', $admin->phone) }}"
                        placeholder="Enter phone number"
                    >

                    @error('phone')
                        <div class="error-text">{{ $message }}</div>
                    @enderror

                </div>


                <!-- ROLE -->

                <div class="form-group">

                    <label>
                        Role <span>*</span>
                    </label>

                    <select name="role" class="form-control" required>

                        <option value="admin"
                            {{ old('role', $admin->role) === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="manager"
                            {{ old('role', $admin->role) === 'manager' ? 'selected' : '' }}>
                            Manager
                        </option>

                        <option value="super_admin"
                            {{ old('role', $admin->role) === 'super_admin' ? 'selected' : '' }}>
                            Super Admin
                        </option>

                    </select>

                    @error('role')
                        <div class="error-text">{{ $message }}</div>
                    @enderror

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label>
                        New Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Leave blank to keep current password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('password', this)"
                        >
                            <i class="fa-solid fa-eye"></i>
                        </button>

                    </div>

                    <div class="hint">
                        Leave blank if you do not want to change the password.
                    </div>

                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror

                </div>


                <!-- CONFIRM PASSWORD -->

                <div class="form-group">

                    <label>
                        Confirm New Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            placeholder="Confirm new password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('password_confirmation', this)"
                        >
                            <i class="fa-solid fa-eye"></i>
                        </button>

                    </div>

                </div>


                <!-- STATUS -->

                <div class="form-group">

                    <label>
                        Account Status <span>*</span>
                    </label>

                    <select
                        name="status"
                        class="form-control"
                        {{ auth('admin')->id() === $admin->id ? 'disabled' : '' }}
                    >

                        <option value="1"
                            {{ old('status', $admin->status ? '1' : '0') == '1' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0"
                            {{ old('status', $admin->status ? '1' : '0') == '0' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                    @if(auth('admin')->id() === $admin->id)
                        <input type="hidden" name="status" value="1">
                    @endif

                    @error('status')
                        <div class="error-text">{{ $message }}</div>
                    @enderror

                </div>

            </div>


            <div class="form-actions">

                <button type="submit" class="save-btn">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Update Admin
                </button>

                <a href="{{ route('admin.admins.index') }}" class="cancel-btn">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>


<script>

function togglePassword(inputId, button) {

    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');

    if (input.type === 'password') {

        input.type = 'text';

        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');

    } else {

        input.type = 'password';

        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');

    }

}

</script>

@endsection