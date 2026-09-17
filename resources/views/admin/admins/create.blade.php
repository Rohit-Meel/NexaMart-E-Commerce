<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Admin | NexaMart</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #ff7a00;
            --primary-dark: #e86f00;
            --dark: #1f2937;
            --text: #374151;
            --muted: #6b7280;
            --border: #e5e7eb;
            --bg: #f6f7fb;
            --white: #ffffff;
            --danger: #dc3545;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* =========================
           SIDEBAR
        ========================= */

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: var(--white);
            border-right: 1px solid var(--border);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-logo {
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 25px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
        }

        .sidebar-menu {
            padding: 20px 12px;
        }

        .menu-title {
            padding: 0 13px;
            margin-bottom: 10px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 4px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 13px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text);
            font-size: 14px;
            transition: 0.2s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #fff3e8;
            color: var(--primary);
        }

        .menu-icon {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        /* =========================
           MAIN
        ========================= */

        .admin-main {
            margin-left: 250px;
            min-height: 100vh;
        }

        /* =========================
           TOPBAR
        ========================= */

        .admin-topbar {
            height: 75px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .topbar-left h1 {
            font-size: 22px;
            color: var(--dark);
        }

        .topbar-left p {
            margin-top: 4px;
            font-size: 12px;
            color: var(--muted);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .profile-info strong {
            display: block;
            font-size: 14px;
            color: var(--dark);
        }

        .profile-info span {
            display: block;
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .logout-btn {
            border: 0;
            background: transparent;
            color: var(--danger);
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            margin-left: 15px;
            padding: 8px;
        }

        .logout-btn:hover {
            text-decoration: underline;
        }

        /* =========================
           CONTENT
        ========================= */

        .admin-content {
            padding: 30px;
        }

        .page-header {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 22px 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .page-header h2 {
            font-size: 21px;
            color: var(--dark);
            margin-bottom: 6px;
        }

        .page-header p {
            font-size: 13px;
            color: var(--muted);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 15px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: var(--white);
            color: var(--text);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .back-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* =========================
           FORM CARD
        ========================= */

        .form-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 30px;
        }

        .form-card-header {
            padding-bottom: 18px;
            margin-bottom: 25px;
            border-bottom: 1px solid var(--border);
        }

        .form-card-header h3 {
            font-size: 17px;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .form-card-header p {
            font-size: 12px;
            color: var(--muted);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            margin-bottom: 8px;
            color: var(--dark);
            font-size: 13px;
            font-weight: 600;
        }

        .form-group label span {
            color: var(--danger);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            height: 44px;
            padding: 0 13px;
            border: 1px solid #d9dde5;
            border-radius: 7px;
            outline: none;
            background: var(--white);
            color: var(--text);
            font-size: 13px;
            transition: 0.2s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.08);
        }

        .form-help {
            margin-top: 6px;
            color: var(--muted);
            font-size: 11px;
        }

        .error-message {
            margin-top: 6px;
            color: var(--danger);
            font-size: 11px;
        }

        /* =========================
           PASSWORD
        ========================= */

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            font-size: 13px;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* =========================
           FORM ACTIONS
        ========================= */

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .cancel-btn,
        .save-btn {
            height: 42px;
            padding: 0 18px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .cancel-btn {
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text);
        }

        .cancel-btn:hover {
            border-color: #cbd0d8;
        }

        .save-btn {
            border: 1px solid var(--primary);
            background: var(--primary);
            color: var(--white);
        }

        .save-btn:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* =========================
           VALIDATION ALERT
        ========================= */

        .validation-alert {
            background: #fff0f0;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 20px;
            color: var(--danger);
        }

        .validation-alert strong {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .validation-alert ul {
            margin-left: 18px;
        }

        .validation-alert li {
            font-size: 12px;
            margin-bottom: 3px;
        }

        /* =========================
           TOAST
        ========================= */

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            min-width: 300px;
            max-width: 380px;
            padding: 15px 18px;
            border-radius: 8px;
            color: var(--white);
            background: #28a745;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.35s ease;
        }

        @keyframes slideIn {

            from {
                transform: translateX(120%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 900px) {

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: auto;
            }
        }

        @media (max-width: 768px) {

            .admin-sidebar {
                width: 220px;
            }

            .admin-main {
                margin-left: 220px;
            }

            .admin-topbar {
                padding: 0 20px;
            }

            .admin-content {
                padding: 20px;
            }

            .profile-info {
                display: none;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {

            .admin-sidebar {
                width: 0;
                overflow: hidden;
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-topbar {
                padding: 0 15px;
            }

            .topbar-left h1 {
                font-size: 18px;
            }

            .admin-content {
                padding: 15px;
            }

            .form-card {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .cancel-btn,
            .save-btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    {{-- =========================
         SUCCESS TOAST
    ========================== --}}

    @if(session('success'))

        <div class="toast-container">

            <div class="toast">
                ✓ {{ session('success') }}
            </div>

        </div>

    @endif


    {{-- =========================
         SIDEBAR
    ========================== --}}

    <aside class="admin-sidebar">

        <div class="sidebar-logo">

            <img
                src="{{ asset('assets/images/logo/logo.png') }}"
                alt="NexaMart">

        </div>


        <div class="sidebar-menu">

            <div class="menu-title">
                Main Menu
            </div>

            <ul>

                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <span class="menu-icon">⌂</span>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.categories.index') }}">
                        <span class="menu-icon">▦</span>
                        Categories
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.subcategories.index') }}">
                        <span class="menu-icon">≡</span>
                        Sub Categories
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.brands.index') }}">
                        <span class="menu-icon">◆</span>
                        Brands
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.vendors.index') }}">
                        <span class="menu-icon">▣</span>
                        Vendors
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.products.index') }}">
                        <span class="menu-icon">□</span>
                        Products
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.orders.index') }}">
                        <span class="menu-icon">🛒</span>
                        Orders
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.customers.index') }}">
                        <span class="menu-icon">♙</span>
                        Customers
                    </a>
                </li>

            </ul>


            <div class="menu-title" style="margin-top: 25px;">
                Management
            </div>

            <ul>

                <li>
                    <a href="{{ route('admin.coupons.index') }}">
                        <span class="menu-icon">%</span>
                        Coupons
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.banners.index') }}">
                        <span class="menu-icon">▰</span>
                        Banners
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.reviews.index') }}">
                        <span class="menu-icon">★</span>
                        Reviews
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.admins.index') }}" class="active">
                        <span class="menu-icon">♙</span>
                        Admins
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.contacts.index') }}">
                        <span class="menu-icon">✉</span>
                        Contacts
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.settings.index') }}">
                        <span class="menu-icon">⚙</span>
                        Settings
                    </a>
                </li>

            </ul>

        </div>

    </aside>


    {{-- =========================
         MAIN
    ========================== --}}

    <div class="admin-main">


        {{-- TOPBAR --}}

        <header class="admin-topbar">

            <div class="topbar-left">

                <h1>
                    Add Admin
                </h1>

                <p>
                    Create a new administrator account
                </p>

            </div>


            <div class="admin-profile">

                <div class="profile-avatar">

                    {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}

                </div>

                <div class="profile-info">

                    <strong>
                        {{ auth('admin')->user()->name }}
                    </strong>

                    <span>
                        {{ auth('admin')->user()->role ?? 'Administrator' }}
                    </span>

                </div>


                <form action="{{ route('admin.logout') }}" method="POST">

                    @csrf

                    <button type="submit" class="logout-btn">
                        Logout
                    </button>

                </form>

            </div>

        </header>


        {{-- CONTENT --}}

        <main class="admin-content">


            {{-- PAGE HEADER --}}

            <div class="page-header">

                <div>

                    <h2>
                        Add New Admin
                    </h2>

                    <p>
                        Enter the details below to create a new admin account.
                    </p>

                </div>


                <a
                    href="{{ route('admin.dashboard') }}"
                    class="back-btn"
                >
                    ← Back to Admins
                </a>

            </div>


            {{-- VALIDATION ERRORS --}}

            @if($errors->any())

                <div class="validation-alert">

                    <strong>
                        Please fix the following errors:
                    </strong>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORM CARD --}}

            <div class="form-card">

                <div class="form-card-header">

                    <h3>
                        Administrator Information
                    </h3>

                    <p>
                        All required fields are marked with *
                    </p>

                </div>


                <form
                    action="{{ route('admin.admins.store') }}"
                    method="POST"
                >

                    @csrf


                    <div class="form-grid">


                        {{-- NAME --}}

                        <div class="form-group">

                            <label for="name">
                                Admin Name <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter admin name"
                                required
                            >

                            @error('name')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- EMAIL --}}

                        <div class="form-group">

                            <label for="email">
                                Email Address <span>*</span>
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter email address"
                                required
                            >

                            @error('email')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- PHONE --}}

                        <div class="form-group">

                            <label for="phone">
                                Phone Number
                            </label>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Enter phone number"
                            >

                            @error('phone')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- ROLE --}}

                        <div class="form-group">

                            <label for="role">
                                Role <span>*</span>
                            </label>

                            <select
                                id="role"
                                name="role"
                                required
                            >

                                <option value="">
                                    Select Role
                                </option>

                                <option
                                    value="admin"
                                    {{ old('role') == 'admin' ? 'selected' : '' }}
                                >
                                    Admin
                                </option>

                                <option
                                    value="manager"
                                    {{ old('role') == 'manager' ? 'selected' : '' }}
                                >
                                    Manager
                                </option>

                                <option
                                    value="super_admin"
                                    {{ old('role') == 'super_admin' ? 'selected' : '' }}
                                >
                                    Super Admin
                                </option>

                            </select>

                            @error('role')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- PASSWORD --}}

                        <div class="form-group">

                            <label for="password">
                                Password <span>*</span>
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Enter password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword('password', this)"
                                >
                                    Show
                                </button>

                            </div>

                            <div class="form-help">
                                Password must contain at least 8 characters.
                            </div>

                            @error('password')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- CONFIRM PASSWORD --}}

                        <div class="form-group">

                            <label for="password_confirmation">
                                Confirm Password <span>*</span>
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Confirm password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword('password_confirmation', this)"
                                >
                                    Show
                                </button>

                            </div>

                        </div>


                        {{-- STATUS --}}

                        <div class="form-group full-width">

                            <label for="status">
                                Account Status <span>*</span>
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                            >

                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>

                            @error('status')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                    </div>


                    {{-- ACTIONS --}}

                    <div class="form-actions">

                        <a
                            href="{{ route('admin.admins.index') }}"
                            class="cancel-btn"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="save-btn"
                        >
                            Create Admin
                        </button>

                    </div>


                </form>

            </div>


        </main>

    </div>


    <script>

        function togglePassword(fieldId, button) {

            const field = document.getElementById(fieldId);

            if (field.type === 'password') {

                field.type = 'text';
                button.textContent = 'Hide';

            } else {

                field.type = 'password';
                button.textContent = 'Show';

            }

        }


        setTimeout(function() {

            const toast = document.querySelector('.toast');

            if (toast) {
                toast.remove();
            }

        }, 4000);

    </script>

</body>

</html>