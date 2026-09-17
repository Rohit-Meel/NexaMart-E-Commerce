<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard | NexaMart</title>

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
            padding: 0 25px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
        }

        .sidebar-logo span {
            color: var(--dark);
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
           MAIN AREA
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

        .dashboard-content {
            padding: 30px;
        }

        .welcome-box {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 25px;
        }

        .welcome-box h2 {
            font-size: 21px;
            color: var(--dark);
            margin-bottom: 7px;
        }

        .welcome-box p {
            font-size: 14px;
            color: var(--muted);
        }

        /* =========================
           STAT CARDS
        ========================= */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-info span {
            display: block;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .stat-info h3 {
            font-size: 27px;
            color: var(--dark);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: #fff3e8;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
        }

        /* =========================
           CONTENT GRID
        ========================= */

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .dashboard-card {
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

        .view-link {
            color: var(--primary);
            font-size: 13px;
            text-decoration: none;
        }

        .view-link:hover {
            text-decoration: underline;
        }

        .card-body {
            padding: 20px;
        }

        /* =========================
           QUICK ACTIONS
        ========================= */

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .quick-action {
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            text-decoration: none;
            color: var(--text);
            font-size: 13px;
            transition: 0.2s ease;
        }

        .quick-action:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .quick-action strong {
            display: block;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .quick-action span {
            color: var(--muted);
            font-size: 12px;
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

        @media (max-width: 1100px) {

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
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

            .dashboard-content {
                padding: 20px;
            }

            .profile-info {
                display: none;
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

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .admin-topbar {
                padding: 0 15px;
            }

            .topbar-left h1 {
                font-size: 18px;
            }

            .dashboard-content {
                padding: 15px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
        }

        /* =========================
   ADMIN MANAGEMENT
========================= */

        .admin-management-card {
            margin-top: 20px;
        }

        .add-admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 15px;
            border-radius: 7px;
            background: var(--primary);
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .add-admin-btn:hover {
            background: var(--primary-dark);
            color: #ffffff;
        }

        .admin-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        .admin-table th {
            padding: 14px 20px;
            text-align: left;
            background: #fafafa;
            border-bottom: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
        }

        .admin-table td {
            padding: 15px 20px;
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

        .admin-name {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-small-avatar {
            width: 34px;
            height: 34px;
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

        .role-badge {
            display: inline-flex;
            padding: 5px 9px;
            border-radius: 5px;
            background: #fff3e8;
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
        }

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
            color: #dc3545;
        }

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
            color: #dc3545;
            border-color: #fecaca;
        }

        .admin-edit-btn:hover,
        .admin-status-btn:hover,
        .admin-delete-btn:hover {
            opacity: 0.8;
        }

        .current-admin-label {
            padding: 6px 9px;
            border-radius: 5px;
            background: #f3f4f6;
            color: var(--muted);
            font-size: 11px;
            font-weight: 600;
        }

        .empty-admin {
            text-align: center !important;
            padding: 35px !important;
            color: var(--muted) !important;
        }

        .recent-orders-wrapper {
            padding: 8px 20px 12px;
        }

        .recent-orders-list {
            width: 100%;
        }

        .recent-order-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 14px 0;
            border-bottom: 1px solid #eef0f3;
        }

        .recent-order-item:last-child {
            border-bottom: none;
        }

        .recent-order-info {
            min-width: 150px;
            flex: 1;
        }

        .recent-order-number {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .recent-order-customer {
            font-size: 12px;
            color: #6b7280;
        }

        .recent-order-middle {
            min-width: 110px;
            text-align: right;
        }

        .recent-order-total {
            font-size: 13px;
            font-weight: 600;
            color: #003680;
            margin-bottom: 4px;
        }

        .recent-order-date {
            font-size: 11px;
            color: #9ca3af;
        }

        .recent-order-status {
            min-width: 85px;
            text-align: right;
        }

        .order-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
        }

        .order-status.pending {
            background: #fff7ed;
            color: #c2410c;
        }

        .order-status.confirmed {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .order-status.processing {
            background: #fff7ed;
            color: #c2410c;
        }

        .order-status.shipped {
            background: #f0fdf4;
            color: #15803d;
        }

        .order-status.delivered {
            background: #ecfdf5;
            color: #047857;
        }

        .order-status.cancelled {
            background: #fef2f2;
            color: #dc2626;
        }

        @media (max-width: 700px) {

            .recent-order-item {
                flex-wrap: wrap;
            }

            .recent-order-middle {
                text-align: left;
            }

            .recent-order-status {
                text-align: left;
            }

        }
        .view-btn{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 11px;
            border-radius: 5px;
            background: #eef7ff;
            color: #2563eb;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
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
                    <a href="{{ route('admin.dashboard') }}" class="active">
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

                <!-- <li>
                    <a href="#">
                        <span class="menu-icon">◉</span>
                        Payments
                    </a>
                </li> -->

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
                    Dashboard
                </h1>

                <p>
                    Manage your NexaMart store
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

        <main class="dashboard-content">


            {{-- WELCOME --}}

            <div class="welcome-box">

                <h2>
                    Welcome back, {{ auth('admin')->user()->name }} 👋
                </h2>

                <p>
                    Here's what's happening with your store today.
                </p>

            </div>


            {{-- STAT CARDS --}}

            <div class="stats-grid">


                <div class="stat-card">

                    <div class="stat-info">

                        <span>
                            Total Products
                        </span>

                        <h3>
                            {{ $totalProducts }}
                        </h3>

                    </div>

                    <div class="stat-icon">
                        P
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-info">

                        <span>
                            Total Orders
                        </span>

                        <h3>
                            {{ $totalOrders }}
                        </h3>

                    </div>

                    <div class="stat-icon">
                        O
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-info">

                        <span>
                            Total Customers
                        </span>

                        <h3>
                            {{ $totalCustomers }}
                        </h3>

                    </div>

                    <div class="stat-icon">
                        C
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-info">

                        <span>
                            Total Vendors
                        </span>

                        <h3>
                            {{ $totalVendors }}
                        </h3>

                    </div>

                    <div class="stat-icon">
                        V
                    </div>

                </div>

            </div>


            {{-- LOWER CONTENT --}}

            <div class="dashboard-grid">


                {{-- RECENT ORDERS --}}
             <div class="dashboard-card">
                <div class="lower-card">

                    <div class="card-header">
                        <h3>Recent Orders</h3>

                        <a href="{{ route('admin.orders.index') }}" class="view-btn">
                            View All
                        </a>
                    </div>

                    <div class="recent-orders-wrapper">

                        @if($recentOrders->count())

                        <div class="recent-orders-list">

                            @foreach($recentOrders as $order)

                            <div class="recent-order-item">

                                <div class="recent-order-info">

                                    <div class="recent-order-number">
                                        #{{ $order->order_number }}
                                    </div>

                                    <div class="recent-order-customer">
                                        {{ $order->customer->name ?? 'Customer' }}
                                    </div>

                                </div>

                                <div class="recent-order-middle">

                                    <div class="recent-order-total">
                                        ₹{{ number_format($order->total_amount, 2) }}
                                    </div>

                                    <div class="recent-order-date">
                                        {{ $order->placed_at
                                    ? $order->placed_at->format('d M, Y')
                                    : $order->created_at->format('d M, Y') }}
                                    </div>

                                </div>

                                <div class="recent-order-status">

                                    <span class="order-status {{ strtolower($order->order_status) }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>

                                </div>

                            </div>

                            @endforeach

                        </div>

                        @else

                        <div class="empty-state">
                            No orders found.
                        </div>

                        @endif

                    </div>

                </div>
             </div>

                {{-- QUICK ACTIONS --}}

                <div class="dashboard-card">

                    <div class="card-header">

                        <h3>
                            Quick Actions
                        </h3>

                    </div>

                    <div class="card-body">

                        <div class="quick-actions">

                            <a href="{{ route('admin.products.create') }}" class="quick-action">

                                <strong>
                                    Add Product
                                </strong>

                                <span>
                                    Create a new product
                                </span>

                            </a>


                            <a href="{{ route('admin.categories.create') }}" class="quick-action">

                                <strong>
                                    Add Category
                                </strong>

                                <span>
                                    Create a category
                                </span>

                            </a>


                            <a href="{{ route('admin.brands.create') }}" class="quick-action">

                                <strong>
                                    Add Brand
                                </strong>

                                <span>
                                    Create a brand
                                </span>

                            </a>


                            <a href="{{ route('admin.coupons.create') }}" class="quick-action">

                                <strong>
                                    Add Coupon
                                </strong>

                                <span>
                                    Create a coupon
                                </span>

                            </a>

                        </div>

                    </div>

                </div>


            </div>

            {{-- =========================
     ADMIN MANAGEMENT
========================== --}}

            <div class="dashboard-card admin-management-card">

                <div class="card-header">

                    <h3>
                        Admin Management
                    </h3>

                    <a href="{{ route('admin.admins.create') }}" class="add-admin-btn">
                        + Add Admin
                    </a>

                </div>

                <div class="admin-table-wrapper">

                    <table class="admin-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Admin</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
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

                                        <a
                                            href="{{ route('admin.admins.edit', $admin) }}"
                                            class="admin-edit-btn">
                                            Edit
                                        </a>

                                        @if(auth('admin')->id() !== $admin->id)

                                        <form
                                            action="{{ route('admin.admins.toggle-status', $admin) }}"
                                            method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="admin-status-btn">
                                                {{ $admin->status ? 'Disable' : 'Enable' }}
                                            </button>

                                        </form>

                                        <form
                                            action="{{ route('admin.admins.destroy', $admin) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this admin?');">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="admin-delete-btn">
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

                                <td colspan="7" class="empty-admin">
                                    No admins found.
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>
        </main>

    </div>


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