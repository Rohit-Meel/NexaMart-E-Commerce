<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admins | NexaMart</title>

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

        .add-admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 7px;
            background: var(--primary);
            color: var(--white);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s ease;
            white-space: nowrap;
        }

        .add-admin-btn:hover {
            background: var(--primary-dark);
            color: var(--white);
        }

        /* =========================
           TABLE CARD
        ========================= */

        .admin-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h3 {
            font-size: 16px;
            color: var(--dark);
        }

        .card-header span {
            color: var(--muted);
            font-size: 12px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            min-width: 950px;
            border-collapse: collapse;
        }

        .admin-table th {
            padding: 14px 18px;
            text-align: left;
            background: #fafafa;
            border-bottom: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .admin-table td {
            padding: 15px 18px;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            font-size: 13px;
            vertical-align: middle;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .admin-table tbody tr:hover {
            background: #fffaf5;
        }

        /* =========================
           ADMIN NAME
        ========================= */

        .admin-name {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 170px;
        }

        .admin-small-avatar {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            border-radius: 50%;
            background: #fff3e8;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .admin-name strong {
            color: var(--dark);
            font-size: 13px;
        }

        /* =========================
           ROLE
        ========================= */

        .role-badge {
            display: inline-flex;
            padding: 5px 9px;
            border-radius: 5px;
            background: #fff3e8;
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* =========================
           STATUS
        ========================= */

        .status-badge {
            display: inline-flex;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-badge.active {
            background: #eaf8ef;
            color: #16803c;
        }

        .status-badge.inactive {
            background: #fdecec;
            color: var(--danger);
        }

        /* =========================
           ACTIONS
        ========================= */

        .admin-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .admin-actions form {
            margin: 0;
        }

        .admin-edit-btn,
        .admin-status-btn,
        .admin-delete-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 9px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        .admin-edit-btn {
            background: #fff7e8;
            color: #d97706;
            border-color: #fcd58b;
        }

        .admin-status-btn {
            background: #eef7ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .admin-delete-btn {
            background: #fff0f0;
            color: var(--danger);
            border-color: #fecaca;
        }

        .admin-edit-btn:hover,
        .admin-status-btn:hover,
        .admin-delete-btn:hover {
            opacity: 0.8;
        }

        .current-admin-label {
            display: inline-flex;
            padding: 6px 9px;
            border-radius: 5px;
            background: #f3f4f6;
            color: var(--muted);
            font-size: 11px;
            font-weight: 600;
        }

        .empty-admin {
            text-align: center !important;
            padding: 40px !important;
            color: var(--muted) !important;
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

        .toast.error {
            background: var(--danger);
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

            .add-admin-btn {
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
         ERROR TOAST
    ========================== --}}

    @if(session('error'))

        <div class="toast-container">

            <div class="toast error">
                ✕ {{ session('error') }}
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


        {{-- =========================
             TOPBAR
        ========================== --}}

        <header class="admin-topbar">

            <div class="topbar-left">

                <h1>
                    Admins
                </h1>

                <p>
                    Manage administrator accounts
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


                <form
                    action="{{ route('admin.logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="logout-btn"
                    >
                        Logout
                    </button>

                </form>

            </div>

        </header>


        {{-- =========================
             CONTENT
        ========================== --}}

        <main class="admin-content">


            {{-- PAGE HEADER --}}

            <div class="page-header">

                <div>

                    <h2>
                        Admin Management
                    </h2>

                    <p>
                        Manage all administrator accounts of NexaMart.
                    </p>

                </div>


                <a
                    href="{{ route('admin.admins.create') }}"
                    class="add-admin-btn"
                >
                    + Add Admin
                </a>

            </div>


            {{-- ADMIN TABLE --}}

            <div class="admin-card">

                <div class="card-header">

                    <h3>
                        All Admins
                    </h3>

                    <span>
                        {{ $admins->count() }} Admin(s)
                    </span>

                </div>


                <div class="table-responsive">

                    <table class="admin-table">

                        <thead>

                            <tr>

                                <th>
                                    ID
                                </th>

                                <th>
                                    Admin
                                </th>

                                <th>
                                    Email
                                </th>

                                <th>
                                    Phone
                                </th>

                                <th>
                                    Role
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($admins as $admin)

                                <tr>

                                    <td>
                                        #{{ $admin->id }}
                                    </td>


                                    <td>

                                        <div class="admin-name">

                                            <div class="admin-small-avatar">

                                                {{ strtoupper(substr($admin->name, 0, 1)) }}

                                            </div>

                                            <strong>
                                                {{ $admin->name }}
                                            </strong>

                                        </div>

                                    </td>


                                    <td>
                                        {{ $admin->email }}
                                    </td>


                                    <td>
                                        {{ $admin->phone ?? '-' }}
                                    </td>


                                    <td>

                                        <span class="role-badge">

                                            {{ ucfirst(str_replace('_', ' ', $admin->role)) }}

                                        </span>

                                    </td>


                                    <td>

                                        @if($admin->status)

                                            <span class="status-badge active">
                                                Active
                                            </span>

                                        @else

                                            <span class="status-badge inactive">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        <div class="admin-actions">


                                            {{-- EDIT --}}

                                            <a
                                                href="{{ route('admin.admins.edit', $admin) }}"
                                                class="admin-edit-btn"
                                            >
                                                Edit
                                            </a>


                                            {{-- ENABLE / DISABLE --}}

                                            @if(auth('admin')->id() !== $admin->id)

                                                <form
                                                    action="{{ route('admin.admins.toggle-status', $admin) }}"
                                                    method="POST"
                                                >

                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="admin-status-btn"
                                                    >
                                                        {{ $admin->status ? 'Disable' : 'Enable' }}
                                                    </button>

                                                </form>


                                                {{-- DELETE --}}

                                                <form
                                                    action="{{ route('admin.admins.destroy', $admin) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this admin?');"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="admin-delete-btn"
                                                    >
                                                        Delete
                                                    </button>

                                                </form>

                                            @else

                                                <span class="current-admin-label">
                                                    Current
                                                </span>

                                            @endif


                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="empty-admin"
                                    >
                                        No admin accounts found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


        </main>

    </div>


    {{-- =========================
         JAVASCRIPT
    ========================== --}}

    <script>

        setTimeout(function() {

            const toast = document.querySelector('.toast');

            if (toast) {
                toast.remove();
            }

        }, 4000);

    </script>

</body>

</html>