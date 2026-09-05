@extends('layouts.frontend')

@section('title', 'My Account - NexaMart')

@section('content')

<section class="account-page">

    <div class="account-container">


        {{-- =========================================================
             BREADCRUMB
        ========================================================== --}}

        <div class="account-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <span>
                My Account
            </span>

        </div>



        {{-- =========================================================
             ACCOUNT HEADER
        ========================================================== --}}

        <div class="account-header">

            <div class="account-user">

                <div class="account-avatar">

                    @if($customer->profile_image)

                        <img
                            src="{{ asset('storage/' . $customer->profile_image) }}"
                            alt="{{ $customer->name }}"
                        >

                    @else

                        <span>
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </span>

                    @endif

                </div>


                <div class="account-user-info">

                    <span>
                        MY ACCOUNT
                    </span>

                    <h1>
                        Welcome, {{ $customer->name }}
                    </h1>

                    <p>
                        Manage your profile, orders and addresses from one place.
                    </p>

                </div>

            </div>


            <form
                action="{{ route('logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="account-logout-btn"
                >

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </button>

            </form>

        </div>



        {{-- =========================================================
             STATISTICS
        ========================================================== --}}

        <div class="account-stats">


            {{-- TOTAL ORDERS --}}

            <div class="account-stat-card">

                <div class="account-stat-icon">

                    <i class="fa-solid fa-box"></i>

                </div>

                <div>

                    <span>
                        Total Orders
                    </span>

                    <strong>
                        {{ $totalOrders }}
                    </strong>

                </div>

            </div>


            {{-- PENDING --}}

            <div class="account-stat-card">

                <div class="account-stat-icon">

                    <i class="fa-solid fa-clock"></i>

                </div>

                <div>

                    <span>
                        Active Orders
                    </span>

                    <strong>
                        {{ $pendingOrders }}
                    </strong>

                </div>

            </div>


            {{-- DELIVERED --}}

            <div class="account-stat-card">

                <div class="account-stat-icon">

                    <i class="fa-solid fa-circle-check"></i>

                </div>

                <div>

                    <span>
                        Delivered
                    </span>

                    <strong>
                        {{ $deliveredOrders }}
                    </strong>

                </div>

            </div>


            {{-- SPENT --}}

            <div class="account-stat-card">

                <div class="account-stat-icon">

                    <i class="fa-solid fa-indian-rupee-sign"></i>

                </div>

                <div>

                    <span>
                        Total Spent
                    </span>

                    <strong>
                        ₹{{ number_format($totalSpent, 2) }}
                    </strong>

                </div>

            </div>


        </div>



        {{-- =========================================================
             ACCOUNT CONTENT
        ========================================================== --}}

        <div class="account-content">


            {{-- =====================================================
                 LEFT SIDEBAR
            ====================================================== --}}

            <aside class="account-sidebar">


                <div class="account-menu-title">

                    ACCOUNT MENU

                </div>


                <a
                    href="{{ route('customer.account') }}"
                    class="account-menu-item active"
                >

                    <i class="fa-solid fa-house"></i>

                    <span>
                        Dashboard
                    </span>

                </a>


                <a
                    href="{{ route('orders') }}"
                    class="account-menu-item"
                >

                    <i class="fa-solid fa-box"></i>

                    <span>
                        My Orders
                    </span>

                </a>


                <a
                    href="{{ route('wishlist') }}"
                    class="account-menu-item"
                >

                    <i class="fa-regular fa-heart"></i>

                    <span>
                        Wishlist
                    </span>

                    <b>
                        {{ $wishlistCount }}
                    </b>

                </a>


                <a
                    href="{{ route('cart') }}"
                    class="account-menu-item"
                >

                    <i class="fa-solid fa-cart-shopping"></i>

                    <span>
                        My Cart
                    </span>

                    <b>
                        {{ $cartCount }}
                    </b>

                </a>


                <a
                    href="#profile-section"
                    class="account-menu-item"
                >

                    <i class="fa-regular fa-user"></i>

                    <span>
                        My Profile
                    </span>

                </a>


                <a
                    href="#address-section"
                    class="account-menu-item"
                >

                    <i class="fa-solid fa-location-dot"></i>

                    <span>
                        My Addresses
                    </span>

                </a>


            </aside>



            {{-- =====================================================
                 RIGHT CONTENT
            ====================================================== --}}

            <div class="account-main">


                {{-- =================================================
                     PROFILE
                ================================================== --}}

                <div
                    class="account-panel"
                    id="profile-section"
                >

                    <div class="account-panel-heading">

                        <div>

                            <span>
                                PERSONAL INFORMATION
                            </span>

                            <h2>
                                My Profile
                            </h2>

                        </div>

                    </div>


                    <div class="account-profile-grid">


                        <div class="account-profile-item">

                            <span>
                                Full Name
                            </span>

                            <strong>
                                {{ $customer->name }}
                            </strong>

                        </div>


                        <div class="account-profile-item">

                            <span>
                                Email Address
                            </span>

                            <strong>
                                {{ $customer->email }}
                            </strong>

                        </div>


                        <div class="account-profile-item">

                            <span>
                                Phone Number
                            </span>

                            <strong>
                                {{ $customer->phone ?: 'Not added' }}
                            </strong>

                        </div>


                        <div class="account-profile-item">

                            <span>
                                Account Status
                            </span>

                            <strong class="account-status-active">

                                <i class="fa-solid fa-circle"></i>

                                {{ $customer->status ? 'Active' : 'Inactive' }}

                            </strong>

                        </div>


                    </div>

                </div>



                {{-- =================================================
                     DEFAULT ADDRESS
                ================================================== --}}

                <div
                    class="account-panel"
                    id="address-section"
                >

                    <div class="account-panel-heading">

                        <div>

                            <span>
                                DELIVERY ADDRESS
                            </span>

                            <h2>
                                My Address
                            </h2>

                        </div>

                    </div>


                    @if($defaultAddress)

                        <div class="account-address-card">

                            <div class="account-address-top">

                                <div>

                                    <span class="account-address-type">

                                        {{ ucfirst($defaultAddress->address_type) }}

                                    </span>

                                    <strong>
                                        {{ $defaultAddress->full_name }}
                                    </strong>

                                </div>


                                <span class="account-default-badge">

                                    Default

                                </span>

                            </div>


                            <p>

                                {{ $defaultAddress->address }}

                                @if($defaultAddress->area)
                                    , {{ $defaultAddress->area }}
                                @endif

                                , {{ $defaultAddress->city }}

                                , {{ $defaultAddress->state }}

                                - {{ $defaultAddress->pincode }}

                            </p>


                            <div class="account-address-phone">

                                <i class="fa-solid fa-phone"></i>

                                {{ $defaultAddress->phone }}

                            </div>

                        </div>

                    @else

                        <div class="account-empty-box">

                            <i class="fa-solid fa-location-dot"></i>

                            <h3>
                                No Default Address
                            </h3>

                            <p>
                                You haven't added a default delivery address yet.
                            </p>

                        </div>

                    @endif

                </div>



                {{-- =================================================
                     RECENT ORDERS
                ================================================== --}}

                <div class="account-panel">

                    <div class="account-panel-heading">

                        <div>

                            <span>
                                ORDER HISTORY
                            </span>

                            <h2>
                                Recent Orders
                            </h2>

                        </div>

                        <a
                            href="{{ route('orders') }}"
                            class="account-view-all"
                        >

                            View All

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>

                    </div>


                    @if($recentOrders->count())


                        <div class="account-orders">


                            @foreach($recentOrders as $order)


                                <div class="account-order-row">


                                    <div class="account-order-icon">

                                        <i class="fa-solid fa-box"></i>

                                    </div>


                                    <div class="account-order-info">

                                        <strong>

                                            #{{ $order->order_number }}

                                        </strong>

                                        <span>

                                            {{ $order->created_at->format('d M Y') }}

                                        </span>

                                    </div>


                                    <div class="account-order-payment">

                                        <span>
                                            Payment
                                        </span>

                                        <strong>

                                            {{ strtoupper($order->payment_method) }}

                                        </strong>

                                    </div>


                                    <div class="account-order-status">

                                        <span
                                            class="account-order-badge {{ $order->order_status }}"
                                        >

                                            {{ ucfirst($order->order_status) }}

                                        </span>

                                    </div>


                                    <div class="account-order-total">

                                        <strong>

                                            ₹{{ number_format($order->total_amount, 2) }}

                                        </strong>

                                    </div>


                                </div>


                            @endforeach


                        </div>


                    @else


                        <div class="account-empty-box">

                            <i class="fa-solid fa-box-open"></i>

                            <h3>
                                No Orders Yet
                            </h3>

                            <p>
                                Your recent orders will appear here.
                            </p>

                            <a href="{{ route('products') }}">

                                Start Shopping

                                <i class="fa-solid fa-arrow-right"></i>

                            </a>

                        </div>


                    @endif

                </div>


            </div>

        </div>

    </div>

</section>



{{-- =============================================================
     ACCOUNT CSS
============================================================= --}}

<style>

.account-page {
    padding: 40px 0 70px;
    background: #f8fafc;
}

.account-container {
    width: 92%;
    max-width: 1250px;
    margin: auto;
}


/* BREADCRUMB */

.account-breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 25px;
    font-size: 14px;
}

.account-breadcrumb a {
    color: #ff7a00;
    text-decoration: none;
    font-weight: 600;
}

.account-breadcrumb i {
    font-size: 11px;
    color: #94a3b8;
}

.account-breadcrumb span {
    color: #64748b;
}



/* HEADER */

.account-header {
    background: #fff;
    border-radius: 18px;
    padding: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 8px 30px rgba(0,0,0,.05);
    margin-bottom: 22px;
}

.account-user {
    display: flex;
    align-items: center;
    gap: 18px;
}

.account-avatar {
    width: 75px;
    height: 75px;
    min-width: 75px;
    border-radius: 50%;
    overflow: hidden;
    background: #fff3e8;
    border: 2px solid #ff7a00;
    display: flex;
    align-items: center;
    justify-content: center;
}

.account-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.account-avatar span {
    font-size: 28px;
    font-weight: 700;
    color: #ff7a00;
}

.account-user-info span {
    color: #ff7a00;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
}

.account-user-info h1 {
    margin: 4px 0;
    font-size: 27px;
    color: #111827;
}

.account-user-info p {
    margin: 0;
    color: #64748b;
}

.account-logout-btn {
    border: 0;
    background: #fff1f2;
    color: #dc2626;
    padding: 11px 18px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
}



/* STATS */

.account-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 22px;
}

.account-stat-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 6px 22px rgba(0,0,0,.04);
}

.account-stat-icon {
    width: 46px;
    height: 46px;
    min-width: 46px;
    border-radius: 12px;
    background: #fff3e8;
    color: #ff7a00;
    display: flex;
    align-items: center;
    justify-content: center;
}

.account-stat-card span {
    display: block;
    color: #64748b;
    font-size: 13px;
    margin-bottom: 3px;
}

.account-stat-card strong {
    display: block;
    font-size: 20px;
    color: #111827;
}



/* MAIN */

.account-content {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 22px;
    align-items: start;
}



/* SIDEBAR */

.account-sidebar {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 14px;
    box-shadow: 0 6px 22px rgba(0,0,0,.04);
    position: sticky;
    top: 20px;
}

.account-menu-title {
    font-size: 11px;
    color: #94a3b8;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 10px 12px;
}

.account-menu-item {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 12px;
    border-radius: 10px;
    color: #475569;
    text-decoration: none;
    margin-bottom: 4px;
    font-size: 14px;
}

.account-menu-item i {
    width: 18px;
    text-align: center;
}

.account-menu-item b {
    margin-left: auto;
    background: #f1f5f9;
    color: #475569;
    font-size: 11px;
    padding: 3px 7px;
    border-radius: 20px;
}

.account-menu-item:hover,
.account-menu-item.active {
    background: #fff3e8;
    color: #ff7a00;
}



/* PANELS */

.account-main {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.account-panel {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 6px 22px rgba(0,0,0,.04);
}

.account-panel-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 22px;
}

.account-panel-heading span {
    font-size: 11px;
    color: #ff7a00;
    font-weight: 700;
    letter-spacing: 1px;
}

.account-panel-heading h2 {
    margin: 4px 0 0;
    font-size: 21px;
    color: #111827;
}

.account-view-all {
    color: #ff7a00;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}



/* PROFILE */

.account-profile-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.account-profile-item {
    border: 1px solid #edf0f3;
    border-radius: 10px;
    padding: 15px;
}

.account-profile-item span {
    display: block;
    color: #94a3b8;
    font-size: 12px;
    margin-bottom: 6px;
}

.account-profile-item strong {
    color: #1e293b;
    font-size: 14px;
}

.account-status-active {
    color: #16a34a !important;
}

.account-status-active i {
    font-size: 7px;
    vertical-align: middle;
}



/* ADDRESS */

.account-address-card {
    border: 1px solid #edf0f3;
    border-radius: 12px;
    padding: 18px;
}

.account-address-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.account-address-top > div {
    display: flex;
    align-items: center;
    gap: 10px;
}

.account-address-type {
    background: #fff3e8;
    color: #ff7a00;
    padding: 4px 9px;
    border-radius: 5px;
    font-size: 11px;
    font-weight: 700;
}

.account-address-top strong {
    color: #1e293b;
}

.account-default-badge {
    background: #dcfce7;
    color: #15803d;
    padding: 5px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
}

.account-address-card p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.7;
    margin: 14px 0;
}

.account-address-phone {
    color: #475569;
    font-size: 13px;
}

.account-address-phone i {
    color: #ff7a00;
    margin-right: 5px;
}



/* ORDERS */

.account-orders {
    display: flex;
    flex-direction: column;
}

.account-order-row {
    display: grid;
    grid-template-columns: 45px 1.5fr 1fr 1fr 110px;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #edf0f3;
}

.account-order-row:last-child {
    border-bottom: 0;
}

.account-order-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #fff3e8;
    color: #ff7a00;
    display: flex;
    align-items: center;
    justify-content: center;
}

.account-order-info strong,
.account-order-info span,
.account-order-payment strong,
.account-order-payment span {
    display: block;
}

.account-order-info strong {
    color: #1e293b;
    font-size: 13px;
}

.account-order-info span,
.account-order-payment span {
    color: #94a3b8;
    font-size: 11px;
    margin-top: 4px;
}

.account-order-payment strong {
    color: #475569;
    font-size: 12px;
}

.account-order-badge {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
}

.account-order-badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.account-order-badge.confirmed,
.account-order-badge.processing {
    background: #dbeafe;
    color: #1d4ed8;
}

.account-order-badge.shipped {
    background: #e0e7ff;
    color: #4338ca;
}

.account-order-badge.delivered {
    background: #dcfce7;
    color: #15803d;
}

.account-order-badge.cancelled {
    background: #fee2e2;
    color: #b91c1c;
}

.account-order-total {
    text-align: right;
}

.account-order-total strong {
    color: #111827;
    font-size: 14px;
}



/* EMPTY */

.account-empty-box {
    text-align: center;
    padding: 35px 20px;
    border: 1px dashed #dbe1e8;
    border-radius: 12px;
}

.account-empty-box > i {
    font-size: 28px;
    color: #ff7a00;
    margin-bottom: 10px;
}

.account-empty-box h3 {
    margin: 0 0 6px;
    color: #1e293b;
}

.account-empty-box p {
    margin: 0 0 15px;
    color: #94a3b8;
    font-size: 13px;
}

.account-empty-box a {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #ff7a00;
    color: #fff;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}



/* RESPONSIVE */

@media (max-width: 992px) {

    .account-stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .account-content {
        grid-template-columns: 1fr;
    }

    .account-sidebar {
        position: static;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 5px;
    }

    .account-menu-title {
        grid-column: 1 / -1;
    }

}


@media (max-width: 700px) {

    .account-page {
        padding: 25px 0 50px;
    }

    .account-container {
        width: 94%;
    }

    .account-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .account-user-info h1 {
        font-size: 22px;
    }

    .account-stats {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .account-stat-card {
        padding: 14px;
    }

    .account-stat-card strong {
        font-size: 17px;
    }

    .account-profile-grid {
        grid-template-columns: 1fr;
    }

    .account-order-row {
        grid-template-columns: 42px 1fr;
    }

    .account-order-payment,
    .account-order-status,
    .account-order-total {
        grid-column: 2;
        text-align: left;
    }

    .account-sidebar {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 480px) {

    .account-user {
        align-items: flex-start;
    }

    .account-avatar {
        width: 60px;
        height: 60px;
        min-width: 60px;
    }

    .account-user-info h1 {
        font-size: 19px;
    }

    .account-user-info p {
        font-size: 12px;
    }

    .account-stats {
        grid-template-columns: 1fr;
    }

    .account-panel {
        padding: 17px;
    }

    .account-address-top {
        align-items: flex-start;
    }

    .account-address-top > div {
        flex-direction: column;
        align-items: flex-start;
    }

}

</style>

@endsection