@extends('layouts.frontend')

@section('title', 'Shopping Cart - NexaMart')

@section('content')

@if(session('success') || session('error'))

<div class="cart-toast {{ session('success') ? 'success' : 'error' }}">

    <i class="fa-solid {{ session('success') ? 'fa-circle-check' : 'fa-circle-exclamation' }}"></i>

    <span>
        {{ session('success') ?? session('error') }}
    </span>

</div>

@endif


<section class="cart-page">

    <div class="cart-container">


        {{-- BREADCRUMB --}}

        <div class="cart-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <span>
                Shopping Cart
            </span>

        </div>


        {{-- HEADING --}}

        <div class="cart-heading">

            <div>

                <span>
                    YOUR CART
                </span>

                <h1>
                    Shopping <strong>Cart</strong>
                </h1>

            </div>


            <a
                href="{{ route('products') }}"
                class="continue-shopping"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Continue Shopping

            </a>

        </div>


        {{-- EMPTY CART --}}

        @if($cartItems->isEmpty())

            <div class="cart-empty">

                <div class="cart-empty-icon">

                    <i class="fa-solid fa-cart-shopping"></i>

                </div>

                <h2>
                    Your Cart is Empty
                </h2>

                <p>
                    Looks like you haven't added anything to your cart yet.
                </p>

                <a
                    href="{{ route('products') }}"
                    class="continue-shopping"
                >

                    <i class="fa-solid fa-arrow-left"></i>

                    Start Shopping

                </a>

            </div>

        @else


            <form
                action="{{ route('checkout.prepare') }}"
                method="POST"
                id="cartCheckoutForm"
            >

                @csrf


                <div class="cart-layout">


                    {{-- CART ITEMS --}}

                    <div class="cart-items-card">


                        <div class="cart-items-header">

                            <div>

                                <h2>
                                    Cart Items
                                </h2>

                                <span id="selectedItemsText">
                                    0 Items Selected
                                </span>

                            </div>


                            <label class="select-all-cart">

                                <input
                                    type="checkbox"
                                    id="selectAllCart"
                                >

                                <span>
                                    Select All
                                </span>

                            </label>

                        </div>


                        {{-- ITEMS --}}

                        @foreach($cartItems as $item)

                            @php

                                $product = $item->product;

                            @endphp


                            <div
                                class="cart-item"
                                data-cart-item="{{ $item->id }}"
                                data-price="{{ $item->price }}"
                                data-quantity="{{ $item->quantity }}"
                            >


                                {{-- CHECKBOX --}}

                                <div class="cart-item-select">

                                    <input
                                        type="checkbox"
                                        name="cart_items[]"
                                        value="{{ $item->id }}"
                                        class="cart-checkbox"
                                    >

                                </div>


                                {{-- PRODUCT IMAGE --}}

                                <div class="cart-product-image">

                                    @if($product && $product->thumbnail)

                                        <img
                                            src="{{ asset('assets/images/products/' . $product->thumbnail) }}"
                                            alt="{{ $product->name }}"
                                        >

                                    @else

                                        <img
                                            src="{{ asset('assets/images/products/Watch.jpg') }}"
                                            alt="{{ $product->name ?? 'Product' }}"
                                        >

                                    @endif

                                </div>


                                {{-- PRODUCT INFO --}}

                                <div class="cart-product-info">

                                    @if($product && $product->category)

                                        <span>
                                            {{ $product->category->name }}
                                        </span>

                                    @endif


                                    <h3>
                                        {{ $product->name ?? 'Product' }}
                                    </h3>


                                    @if($product && !empty($product->short_description))

                                        <p>
                                            {{ $product->short_description }}
                                        </p>

                                    @endif


                                    {{-- REMOVE --}}

                                    <button
                                        type="button"
                                        class="remove-cart-item"
                                        data-remove-url="{{ route('cart.remove', $item->id) }}"
                                    >

                                        <i class="fa-regular fa-trash-can"></i>

                                        Remove

                                    </button>

                                </div>


                                {{-- PRICE --}}

                                <div class="cart-item-price">

                                    <strong>
                                        ₹{{ number_format($item->price, 2) }}
                                    </strong>

                                </div>


                                {{-- QUANTITY --}}

                                <div class="cart-quantity">

                                    <button
                                        type="button"
                                        class="quantity-btn quantity-minus"
                                        data-url="{{ route('cart.update', $item->id) }}"
                                        data-quantity="{{ max(1, $item->quantity - 1) }}"
                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                    >
                                        −
                                    </button>


                                    <input
                                        type="text"
                                        value="{{ $item->quantity }}"
                                        readonly
                                        class="quantity-input"
                                    >


                                    <button
                                        type="button"
                                        class="quantity-btn quantity-plus"
                                        data-url="{{ route('cart.update', $item->id) }}"
                                        data-quantity="{{ $item->quantity + 1 }}"
                                    >
                                        +
                                    </button>

                                </div>


                                {{-- ITEM TOTAL --}}

                                <div class="cart-item-total">

                                    <strong>
                                        ₹{{ number_format($item->price * $item->quantity, 2) }}
                                    </strong>

                                </div>

                            </div>

                        @endforeach


                        {{-- SECURITY --}}

                        <div class="cart-security">

                            <i class="fa-solid fa-shield-halved"></i>

                            <span>
                                Your shopping information is secure with NexaMart.
                            </span>

                        </div>


                    </div>


                    {{-- ORDER SUMMARY --}}

                    <div class="cart-summary">

                        <h2>
                            Order Summary
                        </h2>


                        <div class="summary-row">

                            <span>
                                Selected Items
                            </span>

                            <strong id="summarySelectedCount">
                                0
                            </strong>

                        </div>


                        <div class="summary-row">

                            <span>
                                Subtotal
                            </span>

                            <strong id="summarySubtotal">
                                ₹0.00
                            </strong>

                        </div>


                        <div class="summary-row">

                            <span>
                                Discount
                            </span>

                            <strong class="discount">
                                ₹0.00
                            </strong>

                        </div>


                        <div class="summary-row">

                            <span>
                                Delivery
                            </span>

                            <strong class="free">
                                FREE
                            </strong>

                        </div>


                        <div class="summary-divider"></div>


                        <div class="summary-total">

                            <span>
                                Total
                            </span>

                            <strong id="summaryTotal">
                                ₹0.00
                            </strong>

                        </div>


                        <!-- {{-- COUPON --}}

                        <div class="coupon-box">

                            <input
                                type="text"
                                placeholder="Enter coupon code"
                                name="coupon"
                            >

                            <button type="button">
                                Apply
                            </button>

                        </div> -->


                        {{-- CHECKOUT --}}

                        <button
                            type="submit"
                            class="checkout-btn"
                            id="proceedCheckoutBtn"
                            disabled
                        >

                            Proceed to Checkout

                            <i class="fa-solid fa-arrow-right"></i>

                        </button>


                        {{-- PAYMENT NOTE --}}

                        <div class="payment-note">

                            <i class="fa-solid fa-lock"></i>

                            Secure & encrypted checkout

                        </div>

                    </div>


                </div>


            </form>

        @endif

    </div>

</section>


{{-- REMOVE / QUANTITY FORMS --}}

<form
    id="cartActionForm"
    method="POST"
    style="display:none;"
>

    @csrf

    <input
        type="hidden"
        name="quantity"
        id="cartActionQuantity"
    >

    <input
        type="hidden"
        name="_method"
        id="cartActionMethod"
    >

</form>


{{-- TOAST --}}

@if(session('success') || session('error'))

<script>

document.addEventListener('DOMContentLoaded', function () {

    const toast = document.querySelector('.cart-toast');

    if (!toast) {
        return;
    }

    setTimeout(function () {

        toast.classList.add('hide');

        setTimeout(function () {

            toast.remove();

        }, 400);

    }, 3500);

});

</script>

@endif


<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | ELEMENTS
    |--------------------------------------------------------------------------
    */

    const checkboxes =
        document.querySelectorAll('.cart-checkbox');

    const selectAll =
        document.getElementById('selectAllCart');

    const selectedItemsText =
        document.getElementById('selectedItemsText');

    const summarySelectedCount =
        document.getElementById('summarySelectedCount');

    const summarySubtotal =
        document.getElementById('summarySubtotal');

    const summaryTotal =
        document.getElementById('summaryTotal');

    const proceedButton =
        document.getElementById('proceedCheckoutBtn');


    /*
    |--------------------------------------------------------------------------
    | UPDATE SUMMARY
    |--------------------------------------------------------------------------
    */

    function updateSummary() {

        let selectedCount = 0;

        let subtotal = 0;


        checkboxes.forEach(function (checkbox) {

            if (checkbox.checked) {

                selectedCount++;

                const cartItem =
                    checkbox.closest('.cart-item');

                const price =
                    parseFloat(
                        cartItem.dataset.price
                    ) || 0;

                const quantity =
                    parseInt(
                        cartItem.dataset.quantity
                    ) || 1;

                subtotal += price * quantity;
            }

        });


        /*
        |--------------------------------------------------------------------------
        | Update Selected Count
        |--------------------------------------------------------------------------
        */

        summarySelectedCount.textContent =
            selectedCount;

        selectedItemsText.textContent =
            selectedCount +
            (selectedCount === 1
                ? ' Item Selected'
                : ' Items Selected'
            );


        /*
        |--------------------------------------------------------------------------
        | Update Amount
        |--------------------------------------------------------------------------
        */

        summarySubtotal.textContent =
            '₹' + subtotal.toFixed(2);

        summaryTotal.textContent =
            '₹' + subtotal.toFixed(2);


        /*
        |--------------------------------------------------------------------------
        | Checkout Button
        |--------------------------------------------------------------------------
        */

        proceedButton.disabled =
            selectedCount === 0;


        /*
        |--------------------------------------------------------------------------
        | Select All State
        |--------------------------------------------------------------------------
        */

        const totalCheckboxes =
            checkboxes.length;

        if (totalCheckboxes === 0) {

            selectAll.checked = false;

            selectAll.indeterminate = false;

        } else if (selectedCount === totalCheckboxes) {

            selectAll.checked = true;

            selectAll.indeterminate = false;

        } else if (selectedCount > 0) {

            selectAll.checked = false;

            selectAll.indeterminate = true;

        } else {

            selectAll.checked = false;

            selectAll.indeterminate = false;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | INDIVIDUAL CHECKBOX
    |--------------------------------------------------------------------------
    */

    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            updateSummary
        );

    });


    /*
    |--------------------------------------------------------------------------
    | SELECT ALL
    |--------------------------------------------------------------------------
    */

    if (selectAll) {

        selectAll.addEventListener(
            'change',
            function () {

                checkboxes.forEach(function (checkbox) {

                    checkbox.checked =
                        selectAll.checked;

                });

                updateSummary();
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PREVENT EMPTY CHECKOUT
    |--------------------------------------------------------------------------
    */

    const checkoutForm =
        document.getElementById('cartCheckoutForm');

    if (checkoutForm) {

        checkoutForm.addEventListener(
            'submit',
            function (event) {

                const selected =
                    document.querySelectorAll(
                        '.cart-checkbox:checked'
                    );

                if (selected.length === 0) {

                    event.preventDefault();

                    alert(
                        'Please select at least one product before checkout.'
                    );

                    return;
                }

                proceedButton.disabled = true;

                proceedButton.innerHTML =
                    'Preparing Checkout <i class="fa-solid fa-spinner fa-spin"></i>';

            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | QUANTITY UPDATE
    |--------------------------------------------------------------------------
    */

    const quantityButtons =
        document.querySelectorAll(
            '.quantity-btn'
        );

    quantityButtons.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                const url =
                    button.dataset.url;

                const quantity =
                    button.dataset.quantity;

                const form =
                    document.getElementById(
                        'cartActionForm'
                    );

                const quantityInput =
                    document.getElementById(
                        'cartActionQuantity'
                    );

                const methodInput =
                    document.getElementById(
                        'cartActionMethod'
                    );

                form.action = url;

                quantityInput.value =
                    quantity;

                methodInput.value =
                    'POST';

                form.submit();
            }
        );
    });


    /*
    |--------------------------------------------------------------------------
    | REMOVE CART ITEM
    |--------------------------------------------------------------------------
    */

    const removeButtons =
        document.querySelectorAll(
            '.remove-cart-item'
        );

    removeButtons.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                const confirmed =
                    confirm(
                        'Are you sure you want to remove this product?'
                    );

                if (!confirmed) {
                    return;
                }

                const url =
                    button.dataset.removeUrl;

                const form =
                    document.getElementById(
                        'cartActionForm'
                    );

                const methodInput =
                    document.getElementById(
                        'cartActionMethod'
                    );

                form.action = url;

                methodInput.value =
                    'DELETE';

                form.submit();
            }
        );
    });


    /*
    |--------------------------------------------------------------------------
    | INITIAL SUMMARY
    |--------------------------------------------------------------------------
    */

    updateSummary();

});

</script>

@endsection