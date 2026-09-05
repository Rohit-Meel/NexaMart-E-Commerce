<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'NexaMart Admin')
    </title>


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


            .admin-content {

                padding: 15px;
            }


            .profile-info {

                display: none;
            }

        }
    </style>

    @stack('styles')

</head>


<body>


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

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                        <span class="menu-icon">⌂</span>

                        Dashboard

                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">

                        <span class="menu-icon">▦</span>

                        Categories

                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('admin.subcategories.index') }}"
                        class="{{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">

                        <span class="menu-icon">≡</span>

                        Sub Categories

                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('admin.brands.index') }}"
                        class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">

                        <span class="menu-icon">◆</span>

                        Brands

                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('admin.vendors.index') }}"
                        class="{{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">

                        <span class="menu-icon">▣</span>

                        Vendors

                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">

                        <span class="menu-icon">□</span>

                        Products

                    </a>

                </li>


                <li>

                    <a href="{{ route('admin.orders.index') }}"
                        class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">

                        <span class="menu-icon">🛒</span>

                        Orders

                    </a>

                </li>


                <li>

                    <a href="{{ route('admin.customers.index') }}"
                        class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">

                        <span class="menu-icon">♙</span>

                        Customers

                    </a>

                </li>


            </ul>


            <div
                class="menu-title"
                style="margin-top: 25px;">
                Management
            </div>


            <ul>


                <li>

                    <a href="{{ route('admin.coupons.index') }}"
                        class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">

                        <span class="menu-icon">%</span>

                        Coupons

                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('admin.banners.index') }}"
                        class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">

                        <span class="menu-icon">▰</span>

                        Banners

                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('admin.reviews.index') }}"
                        class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">

                        <span class="menu-icon">★</span>

                        Reviews

                    </a>

                </li>

                <!-- 
                <li>

                    <a href="#">

                        <span class="menu-icon">◉</span>

                        Payments

                    </a>

                </li> -->


                <li>

                    <a
                        href="{{ route('admin.contacts.index') }}"
                        class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">


                        <span class="menu-icon">✉</span>

                        Contacts

                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('admin.settings.index') }}"
                        class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">

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


                <form
                    action="{{ route('admin.logout') }}"
                    method="POST">

                    @csrf

                    <button
                        type="submit"
                        class="logout-btn">
                        Logout
                    </button>

                </form>


            </div>

        </header>



        {{-- TOAST --}}

        @if(session('success'))

        <div class="toast-container">

            <div class="toast">

                ✓ {{ session('success') }}

            </div>

        </div>

        @endif



        {{-- PAGE CONTENT --}}

        <main class="admin-content">

            @yield('content')

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


    @stack('scripts')

</body>

</html>