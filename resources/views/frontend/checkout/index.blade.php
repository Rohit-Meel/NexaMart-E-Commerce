@extends('layouts.frontend')

@section('title', 'Checkout - NexaMart')

@section('content')

<section class="checkout-page">

    <div class="checkout-container">


        {{-- BREADCRUMB --}}

        <div class="checkout-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <a href="{{ route('cart') }}">
                Cart
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <span>
                Checkout
            </span>

        </div>



        {{-- HEADING --}}

        <div class="checkout-heading">

            <div>

                <span>
                    SECURE CHECKOUT
                </span>

                <h1>
                    Complete Your <strong>Order</strong>
                </h1>

            </div>


            <div class="checkout-secure">

                <i class="fa-solid fa-lock"></i>

                Secure Checkout

            </div>

        </div>



        {{-- CHECKOUT TYPE --}}

        <div class="checkout-type-message">

            @if($checkoutMode === 'buy_now')

                <i class="fa-solid fa-bolt"></i>

                <span>
                    Buy Now Checkout — Only this product will be ordered.
                </span>

            @else

                <i class="fa-solid fa-cart-shopping"></i>

                <span>
                    Cart Checkout — Only your selected cart products will be ordered.
                </span>

            @endif

        </div>



        {{-- VALIDATION ERRORS --}}

        @if($errors->any())

            <div class="checkout-error-message">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            </div>

        @endif



        <form
            action="{{ route('checkout.place-order') }}"
            method="POST"
            id="checkoutForm"
        >

            @csrf


            <div class="checkout-layout">


                {{-- ================================================= --}}
                {{-- LEFT --}}
                {{-- ================================================= --}}

                <div class="checkout-main">


                    {{-- DELIVERY ADDRESS --}}

                    <div class="checkout-card">

                        <div class="checkout-card-heading">

                            <div class="checkout-number">
                                01
                            </div>

                            <div>

                                <h2>
                                    Delivery Address
                                </h2>

                                <p>
                                    Where should we deliver your order?
                                </p>

                            </div>

                        </div>



                        {{-- NAME --}}

                        <div class="checkout-form-row">


                            <div class="checkout-form-group">

                                <label>
                                    First Name
                                </label>

                                <input
                                    type="text"
                                    name="first_name"
                                    value="{{ old('first_name', explode(' ', $customer->name)[0] ?? '') }}"
                                    placeholder="Enter first name"
                                    required
                                >

                            </div>



                            <div class="checkout-form-group">

                                <label>
                                    Last Name
                                </label>

                                <input
                                    type="text"
                                    name="last_name"
                                    value="{{ old('last_name', count(explode(' ', $customer->name)) > 1 ? implode(' ', array_slice(explode(' ', $customer->name), 1)) : '') }}"
                                    placeholder="Enter last name"
                                    required
                                >

                            </div>


                        </div>



                        {{-- EMAIL / PHONE --}}

                        <div class="checkout-form-row">


                            <div class="checkout-form-group">

                                <label>
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $customer->email) }}"
                                    placeholder="Enter email address"
                                    required
                                >

                            </div>



                            <div class="checkout-form-group">

                                <label>
                                    Phone Number
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone', $customer->phone) }}"
                                    placeholder="Enter phone number"
                                    required
                                >

                            </div>


                        </div>



                        {{-- ADDRESS --}}

                        <div class="checkout-form-group">

                            <label>
                                Address
                            </label>

                            <input
                                type="text"
                                name="address"
                                value="{{ old('address', $defaultAddress->address ?? '') }}"
                                placeholder="House no, street, area"
                                required
                            >

                        </div>



                        {{-- AREA --}}

                        <div class="checkout-form-group">

                            <label>
                                Area
                            </label>

                            <input
                                type="text"
                                name="area"
                                value="{{ old('area', $defaultAddress->area ?? '') }}"
                                placeholder="Area / Locality"
                            >

                        </div>



                        {{-- CITY STATE PINCODE --}}

                        <div class="checkout-form-row three">


                            <div class="checkout-form-group">

                                <label>
                                    City
                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    value="{{ old('city', $defaultAddress->city ?? '') }}"
                                    placeholder="City"
                                    required
                                >

                            </div>



                            <div class="checkout-form-group">

                                <label>
                                    State
                                </label>

                                <input
                                    type="text"
                                    name="state"
                                    value="{{ old('state', $defaultAddress->state ?? '') }}"
                                    placeholder="State"
                                    required
                                >

                            </div>



                            <div class="checkout-form-group">

                                <label>
                                    Pincode
                                </label>

                                <input
                                    type="text"
                                    name="pincode"
                                    value="{{ old('pincode', $defaultAddress->pincode ?? '') }}"
                                    placeholder="Pincode"
                                    maxlength="10"
                                    required
                                >

                            </div>


                        </div>


                    </div>



                    {{-- PAYMENT --}}

                    <div class="checkout-card">

                        <div class="checkout-card-heading">

                            <div class="checkout-number">
                                02
                            </div>

                            <div>

                                <h2>
                                    Payment Method
                                </h2>

                                <p>
                                    Choose how you'd like to pay.
                                </p>

                            </div>

                        </div>



                        <div class="payment-options">


                            {{-- COD --}}

                            <label class="payment-option active">

                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="cod"
                                    checked
                                >

                                <span class="payment-radio"></span>

                                <div class="payment-option-content">

                                    <strong>
                                        Cash on Delivery
                                    </strong>

                                    <small>
                                        Pay when your order arrives
                                    </small>

                                </div>

                                <i class="fa-solid fa-money-bill-wave"></i>

                            </label>



                            {{-- ONLINE --}}

                            <label class="payment-option">

                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="online"
                                >

                                <span class="payment-radio"></span>

                                <div class="payment-option-content">

                                    <strong>
                                        UPI / Online Payment
                                    </strong>

                                    <small>
                                        Pay securely online
                                    </small>

                                </div>

                                <i class="fa-solid fa-mobile-screen-button"></i>

                            </label>


                        </div>

                    </div>



                    {{-- ORDER NOTE --}}

                    <div class="checkout-card">

                        <div class="checkout-card-heading">

                            <div class="checkout-number">
                                03
                            </div>

                            <div>

                                <h2>
                                    Order Note
                                </h2>

                                <p>
                                    Any special instructions for your order?
                                </p>

                            </div>

                        </div>


                        <textarea
                            class="checkout-note"
                            name="customer_note"
                            placeholder="Write your note here..."
                        >{{ old('customer_note') }}</textarea>

                    </div>


                </div>



                {{-- ================================================= --}}
                {{-- RIGHT SUMMARY --}}
                {{-- ================================================= --}}

                <aside class="checkout-summary">


                    <h2>
                        Order Summary
                    </h2>



                    {{-- PRODUCTS --}}

                    <div class="checkout-products">


                        @foreach($cartItems as $item)

                            @if($item->product)

                                <div class="checkout-product">


                                    {{-- PRODUCT IMAGE --}}

                                    <div class="checkout-product-image">

                                        @if($item->product->thumbnail)

                                            <img
                                                src="{{ asset($item->product->thumbnail) }}"
                                                alt="{{ $item->product->name }}"
                                            >

                                        @elseif($item->product->image)

                                            <img
                                                src="{{ asset($item->product->image) }}"
                                                alt="{{ $item->product->name }}"
                                            >

                                        @else

                                            <img
                                                src="{{ asset('assets/images/products/default.jpg') }}"
                                                alt="{{ $item->product->name }}"
                                            >

                                        @endif


                                        <span>
                                            {{ $item->quantity }}
                                        </span>

                                    </div>



                                    {{-- PRODUCT INFO --}}

                                    <div class="checkout-product-info">

                                        <h3>
                                            {{ $item->product->name }}
                                        </h3>


                                        @if($item->product->sku)

                                            <span>
                                                SKU: {{ $item->product->sku }}
                                            </span>

                                        @else

                                            <span>
                                                Quantity: {{ $item->quantity }}
                                            </span>

                                        @endif

                                    </div>



                                    {{-- PRICE --}}

                                    <strong>

                                        ₹{{ number_format(
                                            $item->price * $item->quantity,
                                            2
                                        ) }}

                                    </strong>


                                </div>

                            @endif

                        @endforeach


                    </div>



                    {{-- SUBTOTAL --}}

                    <div class="checkout-summary-line">

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            ₹{{ number_format($subtotal, 2) }}
                        </strong>

                    </div>



                    {{-- DISCOUNT --}}

                    <div class="checkout-summary-line">

                        <span>
                            Discount
                        </span>

                        <strong class="discount">

                            @if($discount > 0)

                                − ₹{{ number_format($discount, 2) }}

                            @else

                                ₹0.00

                            @endif

                        </strong>

                    </div>



                    {{-- DELIVERY --}}

                    <div class="checkout-summary-line">

                        <span>
                            Delivery
                        </span>

                        <strong class="free">

                            @if($shippingCharge > 0)

                                ₹{{ number_format($shippingCharge, 2) }}

                            @else

                                FREE

                            @endif

                        </strong>

                    </div>



                    {{-- TAX --}}

                    @if($tax > 0)

                        <div class="checkout-summary-line">

                            <span>
                                Tax
                            </span>

                            <strong>
                                ₹{{ number_format($tax, 2) }}
                            </strong>

                        </div>

                    @endif



                    <div class="checkout-summary-divider"></div>



                    {{-- TOTAL --}}

                    <div class="checkout-grand-total">

                        <span>
                            Total
                        </span>

                        <strong>
                            ₹{{ number_format($totalAmount, 2) }}
                        </strong>

                    </div>



                    {{-- PLACE ORDER --}}

                    <button
                        type="submit"
                        class="place-order-btn"
                        id="placeOrderBtn"
                    >

                        <span>
                            Place Order
                        </span>

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>



                    {{-- PROTECTION --}}

                    <div class="checkout-protection">

                        <i class="fa-solid fa-shield-halved"></i>

                        <span>
                            Your personal and payment information
                            is protected.
                        </span>

                    </div>


                </aside>


            </div>


        </form>


    </div>

</section>



{{-- PAYMENT OPTION JS --}}

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | PAYMENT OPTIONS
    |--------------------------------------------------------------------------
    */

    const paymentOptions =
        document.querySelectorAll('.payment-option');


    paymentOptions.forEach(function (option) {

        option.addEventListener('click', function () {

            paymentOptions.forEach(function (item) {

                item.classList.remove('active');

            });


            option.classList.add('active');


            const radio =
                option.querySelector(
                    'input[type="radio"]'
                );


            if (radio) {

                radio.checked = true;

            }

        });

    });



    /*
    |--------------------------------------------------------------------------
    | PREVENT DOUBLE ORDER SUBMISSION
    |--------------------------------------------------------------------------
    */

    const checkoutForm =
        document.getElementById('checkoutForm');


    const placeOrderBtn =
        document.getElementById('placeOrderBtn');


    if (checkoutForm && placeOrderBtn) {

        checkoutForm.addEventListener(
            'submit',
            function () {

                placeOrderBtn.disabled = true;


                placeOrderBtn.querySelector(
                    'span'
                ).textContent =
                    'Placing Order...';

            }
        );

    }

});

</script>

@endsection