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

            <h2>
                Nexa<span>Mart</span>
            </h2>


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

                    <div class="card-header">

                        <h3>
                            Recent Orders
                        </h3>

                        <a href="#" class="view-link">
                            View All
                        </a>

                    </div>

                    <div class="card-body">

                        <p style="color:#6b7280; font-size:14px;">
                            Recent order data will appear here.
                        </p>

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

                            <a href="#" class="quick-action">

                                <strong>
                                    Add Product
                                </strong>

                                <span>
                                    Create a new product
                                </span>

                            </a>


                            <a href="{{ route('admin.categories.create') }}"class="quick-action">

                                <strong>
                                    Add Category
                                </strong>

                                <span>
                                    Create a category
                                </span>

                            </a>


                            <a href="#" class="quick-action">

                                <strong>
                                    Add Brand
                                </strong>

                                <span>
                                    Create a brand
                                </span>

                            </a>


                            <a href="#" class="quick-action">

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