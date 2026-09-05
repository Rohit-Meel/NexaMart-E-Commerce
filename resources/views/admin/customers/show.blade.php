@extends('layouts.admin')

@section('title', 'Customer Details | NexaMart Admin')

@section('page-title', 'Customer Details')

@section('page-subtitle', 'View customer information')

@section('content')

<style>

.customer-detail-card {
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:12px;
    margin-bottom:20px;
    overflow:hidden;
}

.customer-card-header {
    padding:18px 20px;
    border-bottom:1px solid #e5e7eb;

    display:flex;
    align-items:center;
    justify-content:space-between;
}

.customer-card-header h3 {
    margin:0;
    font-size:16px;
    color:#1f2937;
}

.customer-card-body {
    padding:20px;
}

.customer-profile {
    display:flex;
    align-items:center;
    gap:15px;
}

.customer-profile img,
.customer-profile-placeholder {
    width:70px;
    height:70px;

    border-radius:50%;

    object-fit:cover;
}

.customer-profile-placeholder {
    display:flex;
    align-items:center;
    justify-content:center;

    background:#fff3e8;
    color:#ff7a00;

    font-size:25px;
    font-weight:700;
}

.profile-name {
    font-size:18px;
    font-weight:700;
    color:#1f2937;
}

.profile-email {
    color:#6b7280;
    font-size:13px;
}

.info-grid {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:15px;
}

.info-box {
    padding:15px;

    background:#fafafa;

    border:1px solid #eeeeee;

    border-radius:8px;
}

.info-box label {
    display:block;

    color:#6b7280;

    font-size:11px;

    font-weight:700;

    text-transform:uppercase;

    margin-bottom:7px;
}

.info-box span {
    color:#1f2937;

    font-size:13px;

    font-weight:600;
}

.status-badge {
    display:inline-block;

    padding:5px 10px;

    border-radius:20px;

    font-size:11px;

    font-weight:700;
}

.status-active {
    background:#e9f8ef;
    color:#198754;
}

.status-inactive {
    background:#fdecec;
    color:#dc3545;
}

.customer-table {
    width:100%;
    border-collapse:collapse;
}

.customer-table th {
    background:#fafafa;

    color:#6b7280;

    font-size:11px;

    text-transform:uppercase;

    padding:13px 15px;

    text-align:left;

    border-bottom:1px solid #e5e7eb;
}

.customer-table td {
    padding:13px 15px;

    font-size:13px;

    border-bottom:1px solid #f0f0f0;
}

.action-btn {
    display:inline-block;

    padding:8px 13px;

    border-radius:7px;

    background:#fff3e8;

    color:#ff7a00;

    text-decoration:none;

    font-size:12px;

    font-weight:600;
}

.action-btn:hover {
    background:#ff7a00;
    color:#fff;
}

@media(max-width:768px) {

    .info-grid {
        grid-template-columns:1fr;
    }

}

</style>


<div style="margin-bottom:20px;">

    <a
        href="{{ route('admin.customers.index') }}"
        class="action-btn"
    >

        <i class="fa-solid fa-arrow-left"></i>

        Back to Customers

    </a>

</div>



<div class="customer-detail-card">

    <div class="customer-card-body">

        <div class="customer-profile">

            @if($customer->profile_image)

                <img
                    src="{{ asset('storage/' . $customer->profile_image) }}"
                >

            @else

                <div class="customer-profile-placeholder">

                    {{ strtoupper(substr($customer->name, 0, 1)) }}

                </div>

            @endif


            <div>

                <div class="profile-name">
                    {{ $customer->name }}
                </div>

                <div class="profile-email">
                    {{ $customer->email }}
                </div>

            </div>

        </div>

    </div>

</div>



<div class="customer-detail-card">

    <div class="customer-card-header">

        <h3>
            Customer Information
        </h3>

    </div>


    <div class="customer-card-body">

        <div class="info-grid">


            <div class="info-box">

                <label>
                    Name
                </label>

                <span>
                    {{ $customer->name }}
                </span>

            </div>


            <div class="info-box">

                <label>
                    Email
                </label>

                <span>
                    {{ $customer->email }}
                </span>

            </div>


            <div class="info-box">

                <label>
                    Phone
                </label>

                <span>
                    {{ $customer->phone ?? '-' }}
                </span>

            </div>


            <div class="info-box">

                <label>
                    Status
                </label>

                <span>

                    @if($customer->status)

                        <span class="status-badge status-active">
                            Active
                        </span>

                    @else

                        <span class="status-badge status-inactive">
                            Inactive
                        </span>

                    @endif

                </span>

            </div>


            <div class="info-box">

                <label>
                    Email Verified
                </label>

                <span>
                    {{ $customer->email_verified_at ? 'Yes' : 'No' }}
                </span>

            </div>


            <div class="info-box">

                <label>
                    Registered
                </label>

                <span>
                    {{ $customer->created_at->format('d M Y, h:i A') }}
                </span>

            </div>


        </div>

    </div>

</div>



<div class="customer-detail-card">

    <div class="customer-card-header">

        <h3>
            Customer Orders
        </h3>

        <span>
            Total: {{ $customer->orders->count() }}
        </span>

    </div>


    <div style="overflow-x:auto;">

        <table class="customer-table">

            <thead>

                <tr>

                    <th>
                        Order
                    </th>

                    <th>
                        Total
                    </th>

                    <th>
                        Payment
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Date
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($customer->orders as $order)

                    <tr>

                        <td>
                            {{ $order->order_number }}
                        </td>

                        <td>
                            ₹{{ number_format($order->total_amount, 2) }}
                        </td>

                        <td>
                            {{ strtoupper($order->payment_method) }}
                        </td>

                        <td>
                            {{ ucfirst($order->order_status) }}
                        </td>

                        <td>
                            {{ $order->created_at->format('d M Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            style="text-align:center;padding:30px;"
                        >
                            No orders found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



<div class="customer-detail-card">

    <div class="customer-card-header">

        <h3>
            Customer Addresses
        </h3>

        <span>
            Total: {{ $customer->addresses->count() }}
        </span>

    </div>


    <div class="customer-card-body">

        @forelse($customer->addresses as $address)

            <div
                style="
                    padding:15px;
                    margin-bottom:10px;
                    background:#fafafa;
                    border:1px solid #eeeeee;
                    border-radius:8px;
                "
            >

                {{ $address->address ?? '' }}

                <br>

                {{ $address->city ?? '' }},
                {{ $address->state ?? '' }}
                - {{ $address->pincode ?? '' }}

            </div>

        @empty

            <p style="color:#6b7280;">
                No addresses found.
            </p>

        @endforelse

    </div>

</div>

@endsection