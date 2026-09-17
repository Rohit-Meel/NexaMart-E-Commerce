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
                                                src="{{ asset('assets/images/products/' . $item->product->thumbnail) }}"
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



                    {{-- ================================================= --}}
                    {{-- COUPON --}}
                    {{-- ================================================= --}}

                    <div
                        class="checkout-coupon"
                        data-apply-url="{{ route('checkout.coupon.apply') }}"
                        data-remove-url="{{ route('checkout.coupon.remove') }}"
                    >

                        <div class="checkout-coupon-heading">

                            <div>

                                <strong>
                                    Have a Coupon?
                                </strong>

                                <span>
                                    Apply your coupon and save more.
                                </span>

                            </div>

                            <i class="fa-solid fa-ticket"></i>

                        </div>



                        {{-- COUPON INPUT --}}

                        <div class="coupon-input-row">

                            <input
                                type="text"
                                id="couponCode"
                                placeholder="Enter coupon code"
                                value="{{ $couponCode ?? '' }}"
                                autocomplete="off"
                            >

                            <button
                                type="button"
                                id="applyCouponBtn"
                            >
                                Apply
                            </button>

                        </div>



                        {{-- APPLIED COUPON --}}

                        <div
                            id="appliedCoupon"
                            class="applied-coupon{{ !empty($couponCode) ? ' show' : '' }}"
                        >

                            <div>

                                <i class="fa-solid fa-circle-check"></i>

                                <span>

                                    Coupon

                                    <strong id="appliedCouponCode">
                                        {{ $couponCode ?? '' }}
                                    </strong>

                                    applied

                                </span>

                            </div>


                            <button
                                type="button"
                                id="removeCouponBtn"
                            >
                                Remove
                            </button>

                        </div>



                        {{-- COUPON MESSAGE --}}

                        <div
                            id="couponMessage"
                            class="coupon-message"
                        ></div>



                        {{-- AVAILABLE COUPONS --}}

                        @if(isset($availableCoupons) && $availableCoupons->count())

                            <div class="available-coupons">

                                <span class="available-coupons-title">
                                    Available Coupons
                                </span>


                                @foreach($availableCoupons as $availableCoupon)

                                    <button
                                        type="button"
                                        class="available-coupon"
                                        data-code="{{ $availableCoupon->code }}"
                                    >

                                        <span>

                                            <strong>
                                                {{ $availableCoupon->code }}
                                            </strong>

                                            @if($availableCoupon->discount_type === 'percentage')

                                                {{ rtrim(rtrim(number_format($availableCoupon->discount_value, 2), '0'), '.') }}% OFF

                                            @else

                                                ₹{{ number_format($availableCoupon->discount_value, 0) }} OFF

                                            @endif

                                        </span>

                                        <i class="fa-solid fa-arrow-right"></i>

                                    </button>

                                @endforeach

                            </div>

                        @endif

                    </div>



                    {{-- SUBTOTAL --}}

                    <div class="checkout-summary-line">

                        <span>
                            Subtotal
                        </span>

                        <strong id="checkoutSubtotal">
                            ₹{{ number_format($subtotal, 2) }}
                        </strong>

                    </div>



                    {{-- DISCOUNT --}}

                    <div class="checkout-summary-line">

                        <span>
                            Discount
                        </span>

                        <strong
                            class="discount"
                            id="checkoutDiscount"
                        >

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

                        <strong id="checkoutTotal">
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



{{-- ========================================================= --}}
{{-- CHECKOUT JS --}}
{{-- ========================================================= --}}

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
    | COUPON ELEMENTS
    |--------------------------------------------------------------------------
    */

    const couponBox =
        document.querySelector('.checkout-coupon');


    const couponCodeInput =
        document.getElementById('couponCode');


    const applyCouponBtn =
        document.getElementById('applyCouponBtn');


    const removeCouponBtn =
        document.getElementById('removeCouponBtn');


    const appliedCoupon =
        document.getElementById('appliedCoupon');


    const appliedCouponCode =
        document.getElementById('appliedCouponCode');


    const couponMessage =
        document.getElementById('couponMessage');


    const checkoutDiscount =
        document.getElementById('checkoutDiscount');


    const checkoutTotal =
        document.getElementById('checkoutTotal');



    /*
    |--------------------------------------------------------------------------
    | COUPON URLs
    |--------------------------------------------------------------------------
    */

    const applyCouponUrl =
        couponBox
            ? couponBox.dataset.applyUrl
            : '';


    const removeCouponUrl =
        couponBox
            ? couponBox.dataset.removeUrl
            : '';



    /*
    |--------------------------------------------------------------------------
    | COUPON MESSAGE
    |--------------------------------------------------------------------------
    */

    function showCouponMessage(message, type)
    {

        if (!couponMessage) {
            return;
        }


        couponMessage.textContent =
            message;


        couponMessage.className =
            'coupon-message ' + (type || 'error');


        couponMessage.style.display =
            'block';

    }



    function hideCouponMessage()
    {

        if (!couponMessage) {
            return;
        }


        couponMessage.textContent =
            '';


        couponMessage.style.display =
            'none';

    }



    /*
    |--------------------------------------------------------------------------
    | UPDATE CHECKOUT SUMMARY
    |--------------------------------------------------------------------------
    */

    function updateCheckoutSummary(data)
    {

        if (checkoutDiscount) {

            const discount =
                Number(data.discount || 0);


            checkoutDiscount.textContent =
                discount > 0
                    ? '− ₹' + discount.toFixed(2)
                    : '₹0.00';

        }


        if (checkoutTotal) {

            const total =
                Number(data.total_amount || 0);


            checkoutTotal.textContent =
                '₹' + total.toFixed(2);

        }

    }



    /*
    |--------------------------------------------------------------------------
    | APPLY COUPON
    |--------------------------------------------------------------------------
    */

    if (applyCouponBtn) {

        applyCouponBtn.addEventListener(
            'click',
            function () {

                const code =
                    couponCodeInput
                        ? couponCodeInput.value.trim()
                        : '';


                if (!code) {

                    showCouponMessage(
                        'Please enter a coupon code.',
                        'error'
                    );

                    return;

                }


                if (!applyCouponUrl) {

                    showCouponMessage(
                        'Coupon service is unavailable.',
                        'error'
                    );

                    return;

                }


                applyCouponBtn.disabled =
                    true;


                applyCouponBtn.textContent =
                    'Applying...';


                hideCouponMessage();


                fetch(
                    applyCouponUrl,
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .getAttribute('content'),

                            'Accept':
                                'application/json'

                        },

                        body: JSON.stringify({

                            coupon_code: code

                        })

                    }
                )


                .then(async function (response) {

                    const data =
                        await response.json();


                    if (!response.ok) {

                        throw new Error(
                            data.message ||
                            'Unable to apply coupon.'
                        );

                    }


                    return data;

                })


                .then(function (data) {

                    updateCheckoutSummary(data);


                    if (appliedCoupon) {

                        appliedCoupon.classList.add(
                            'show'
                        );

                    }


                    if (appliedCouponCode) {

                        appliedCouponCode.textContent =
                            data.coupon_code;

                    }


                    showCouponMessage(
                        data.message ||
                        'Coupon applied successfully.',
                        'success'
                    );

                })


                .catch(function (error) {

                    showCouponMessage(
                        error.message ||
                        'Unable to apply coupon.',
                        'error'
                    );

                })


                .finally(function () {

                    applyCouponBtn.disabled =
                        false;


                    applyCouponBtn.textContent =
                        'Apply';

                });

            }
        );

    }



    /*
    |--------------------------------------------------------------------------
    | ENTER KEY - APPLY COUPON
    |--------------------------------------------------------------------------
    */

    if (couponCodeInput) {

        couponCodeInput.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Enter') {

                    event.preventDefault();


                    if (applyCouponBtn) {

                        applyCouponBtn.click();

                    }

                }

            }
        );

    }



    /*
    |--------------------------------------------------------------------------
    | AVAILABLE COUPONS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.available-coupon')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const code =
                        button.dataset.code || '';


                    if (couponCodeInput) {

                        couponCodeInput.value =
                            code;

                    }


                    if (applyCouponBtn) {

                        applyCouponBtn.click();

                    }

                }
            );

        });



    /*
    |--------------------------------------------------------------------------
    | REMOVE COUPON
    |--------------------------------------------------------------------------
    */

    if (removeCouponBtn) {

        removeCouponBtn.addEventListener(
            'click',
            function () {

                if (!removeCouponUrl) {

                    showCouponMessage(
                        'Coupon service is unavailable.',
                        'error'
                    );

                    return;

                }


                removeCouponBtn.disabled =
                    true;


                hideCouponMessage();


                fetch(
                    removeCouponUrl,
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .getAttribute('content'),

                            'Accept':
                                'application/json'

                        }

                    }
                )


                .then(async function (response) {

                    const data =
                        await response.json();


                    if (!response.ok) {

                        throw new Error(
                            data.message ||
                            'Unable to remove coupon.'
                        );

                    }


                    return data;

                })


                .then(function (data) {

                    if (couponCodeInput) {

                        couponCodeInput.value =
                            '';

                    }


                    if (appliedCoupon) {

                        appliedCoupon.classList.remove(
                            'show'
                        );

                    }


                    updateCheckoutSummary(data);


                    showCouponMessage(
                        data.message ||
                        'Coupon removed successfully.',
                        'success'
                    );

                })


                .catch(function (error) {

                    showCouponMessage(
                        error.message ||
                        'Unable to remove coupon.',
                        'error'
                    );

                })


                .finally(function () {

                    removeCouponBtn.disabled =
                        false;

                });

            }
        );

    }



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

                placeOrderBtn.disabled =
                    true;


                placeOrderBtn.querySelector(
                    'span'
                ).textContent =
                    'Placing Order...';

            }
        );

    }

});

</script>



{{-- ========================================================= --}}
{{-- COUPON CSS --}}
{{-- ========================================================= --}}

<style>

/* =========================================================
   CHECKOUT COUPON
========================================================= */

.checkout-coupon {
    margin: 20px 0;
    padding: 16px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: #fff;
}

.checkout-coupon-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 12px;
}

.checkout-coupon-heading strong {
    display: block;
    color: #003680;
    font-size: 14px;
}

.checkout-coupon-heading span {
    display: block;
    margin-top: 3px;
    color: #777;
    font-size: 11px;
}

.checkout-coupon-heading > i {
    color: #FF7A00;
    font-size: 18px;
}


/* =========================================================
   COUPON INPUT
========================================================= */

.coupon-input-row {
    display: flex;
    gap: 8px;
}

.coupon-input-row input {
    flex: 1;
    min-width: 0;
    height: 40px;
    padding: 0 12px;
    border: 1px solid #dfe3e8;
    border-radius: 8px;
    outline: none;
    font-size: 13px;
}

.coupon-input-row input:focus {
    border-color: #003680;
}

.coupon-input-row button {
    flex: 0 0 72px;
    height: 40px;
    border: 0;
    border-radius: 8px;
    background: #003680;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.coupon-input-row button:hover {
    background: #CD001C;
}

.coupon-input-row button:disabled {
    opacity: .6;
    cursor: not-allowed;
}


/* =========================================================
   APPLIED COUPON
========================================================= */

.applied-coupon {
    display: none;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-top: 10px;
    padding: 9px 10px;
    border-radius: 8px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
}

.applied-coupon.show {
    display: flex;
}

.applied-coupon > div {
    display: flex;
    align-items: center;
    gap: 7px;
}

.applied-coupon i {
    color: #16A34A;
}

.applied-coupon span {
    color: #333;
    font-size: 11px;
}

.applied-coupon span strong {
    color: #16A34A;
}

.applied-coupon button {
    border: 0;
    background: transparent;
    color: #CD001C;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}


/* =========================================================
   COUPON MESSAGE
========================================================= */

.coupon-message {
    display: none;
    margin-top: 8px;
    font-size: 11px;
    line-height: 1.4;
}

.coupon-message.success {
    color: #16A34A;
}

.coupon-message.error {
    color: #CD001C;
}


/* =========================================================
   AVAILABLE COUPONS
========================================================= */

.available-coupons {
    margin-top: 14px;
}

.available-coupons-title {
    display: block;
    margin-bottom: 7px;
    color: #555;
    font-size: 11px;
    font-weight: 600;
}

.available-coupon {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-top: 6px;
    padding: 8px 9px;
    border: 1px dashed #d7dce2;
    border-radius: 7px;
    background: #fafafa;
    color: #333;
    cursor: pointer;
    text-align: left;
}

.available-coupon:hover {
    border-color: #003680;
    background: #f7faff;
}

.available-coupon span {
    font-size: 10px;
}

.available-coupon span strong {
    margin-right: 5px;
    color: #003680;
}

.available-coupon i {
    color: #FF7A00;
    font-size: 10px;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 480px) {

    .coupon-input-row {
        gap: 6px;
    }

    .coupon-input-row button {
        flex: 0 0 65px;
        width: 65px;
    }

    .checkout-coupon {
        padding: 13px;
    }

}

</style>

@endsection