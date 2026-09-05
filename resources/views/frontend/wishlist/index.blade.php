@extends('layouts.frontend')

@section('title', 'Wishlist - NexaMart')

@section('content')


<style>

    /*
    |--------------------------------------------------------------------------
    | WISHLIST AJAX TOAST
    |--------------------------------------------------------------------------
    */

    .wishlist-ajax-toast {

        position: fixed;

        top: 25px;
        right: 25px;

        min-width: 300px;
        max-width: 420px;

        padding: 14px 18px;

        display: flex;
        align-items: center;
        gap: 11px;

        background: #ffffff;

        border-radius: 8px;

        box-shadow:
            0 10px 30px rgba(0, 0, 0, 0.14);

        z-index: 99999;

        opacity: 0;

        transform: translateY(-20px);

        pointer-events: none;

        transition:
            opacity 0.3s ease,
            transform 0.3s ease;
    }


    .wishlist-ajax-toast.show {

        opacity: 1;

        transform: translateY(0);
    }


    .wishlist-ajax-toast.success {

        border-left:
            4px solid #198754;
    }


    .wishlist-ajax-toast.error {

        border-left:
            4px solid #dc3545;
    }


    .wishlist-ajax-toast i {

        font-size: 19px;
    }


    .wishlist-ajax-toast.success i {

        color: #198754;
    }


    .wishlist-ajax-toast.error i {

        color: #dc3545;
    }


    .wishlist-ajax-toast span {

        font-size: 14px;

        line-height: 1.4;
    }


    /*
    |--------------------------------------------------------------------------
    | BUTTON DISABLED
    |--------------------------------------------------------------------------
    */

    .wishlist-cart-btn:disabled,
    .wishlist-remove:disabled {

        opacity: 0.65;

        cursor: wait;
    }


    /*
    |--------------------------------------------------------------------------
    | EMPTY STATE AFTER AJAX REMOVE
    |--------------------------------------------------------------------------
    */

    .wishlist-ajax-empty {

        width: 100%;

        padding: 70px 20px;

        text-align: center;
    }


    .wishlist-ajax-empty .wishlist-empty-icon {

        margin: 0 auto 20px;
    }


    @media(max-width: 576px) {

        .wishlist-ajax-toast {

            left: 15px;
            right: 15px;

            top: 15px;

            min-width: auto;
            max-width: none;
        }

    }

</style>


<section class="wishlist-page">

    <div class="wishlist-container">


        <!-- ================================================= -->
        <!-- BREADCRUMB -->
        <!-- ================================================= -->

        <div class="wishlist-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <span>
                Wishlist
            </span>

        </div>



        <!-- ================================================= -->
        <!-- HEADING -->
        <!-- ================================================= -->

        <div class="wishlist-heading">

            <div>

                <span>
                    YOUR FAVOURITES
                </span>


                <h1>
                    My <strong>Wishlist</strong>
                </h1>


                <p>
                    Save your favourite products and shop them anytime.
                </p>

            </div>


            <a
                href="{{ route('products') }}"
                class="wishlist-shop-btn"
            >

                <i class="fa-solid fa-bag-shopping"></i>

                Continue Shopping

            </a>

        </div>



        <!-- ================================================= -->
        <!-- WISHLIST CONTENT -->
        <!-- ================================================= -->

        <div id="wishlistContent">


            @if($wishlistItems->isEmpty())


                <!-- EMPTY -->

                <div class="wishlist-empty">

                    <div class="wishlist-empty-icon">

                        <i class="fa-regular fa-heart"></i>

                    </div>


                    <h2>
                        Your Wishlist is Empty
                    </h2>


                    <p>
                        Looks like you haven't added anything to your wishlist yet.
                    </p>


                    <a
                        href="{{ route('products') }}"
                        class="wishlist-empty-btn"
                    >

                        <i class="fa-solid fa-bag-shopping"></i>

                        Start Shopping

                    </a>

                </div>


            @else


                <!-- ================================================= -->
                <!-- WISHLIST GRID -->
                <!-- ================================================= -->

                <div class="wishlist-grid">


                    @foreach($wishlistItems as $item)


                        @php

                            $product =
                                $item->product;

                        @endphp


                        @if($product)


                            <div
                                class="wishlist-card"
                                data-product-id="{{ $product->id }}"
                            >


                                <!-- ================================================= -->
                                <!-- PRODUCT IMAGE -->
                                <!-- ================================================= -->

                                <div class="wishlist-image">


                                    @if($product->thumbnail)

                                        <img
                                            src="{{ asset('assets/images/products/' . $product->thumbnail) }}"
                                            alt="{{ $product->name }}"
                                        >

                                    @elseif($product->image)

                                        <img
                                            src="{{ asset($product->image) }}"
                                            alt="{{ $product->name }}"
                                        >

                                    @else

                                        <img
                                            src="{{ asset('assets/images/products/Watch.jpg') }}"
                                            alt="{{ $product->name }}"
                                        >

                                    @endif



                                    <!-- REMOVE -->

                                    <form
                                        action="{{ route('wishlist.remove', $product->id) }}"
                                        method="POST"
                                        class="wishlist-remove-form"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="wishlist-remove"
                                            title="Remove from wishlist"
                                        >

                                            <i class="fa-solid fa-heart"></i>

                                        </button>

                                    </form>


                                </div>



                                <!-- ================================================= -->
                                <!-- PRODUCT INFO -->
                                <!-- ================================================= -->

                                <div class="wishlist-info">


                                    <!-- CATEGORY -->

                                    @if($product->category)

                                        <span class="wishlist-category">
                                            {{ $product->category->name }}
                                        </span>

                                    @else

                                        <span class="wishlist-category">
                                            Product
                                        </span>

                                    @endif



                                    <!-- PRODUCT NAME -->

                                    <h3>
                                        {{ $product->name }}
                                    </h3>



                                    <!-- RATING -->

                                    <div class="wishlist-rating">


                                        @php

                                            $averageRating =
                                                $product->reviews->avg('rating')
                                                ?? 0;

                                            $reviewCount =
                                                $product->reviews->count();

                                        @endphp


                                        <span>

                                            @for($i = 1; $i <= 5; $i++)

                                                @if(
                                                    $i <=
                                                    round($averageRating)
                                                )

                                                    ★

                                                @else

                                                    ☆

                                                @endif

                                            @endfor

                                        </span>


                                        <small>
                                            ({{ $reviewCount }})
                                        </small>

                                    </div>



                                    <!-- PRICE -->

                                    <div class="wishlist-price">


                                        @if(
                                            $product->sale_price &&
                                            $product->price > $product->sale_price
                                        )


                                            <strong>
                                                ₹{{ number_format($product->sale_price, 2) }}
                                            </strong>


                                            <del>
                                                ₹{{ number_format($product->price, 2) }}
                                            </del>


                                        @else


                                            <strong>
                                                ₹{{ number_format($product->price, 2) }}
                                            </strong>


                                        @endif


                                    </div>



                                    <!-- ================================================= -->
                                    <!-- ACTIONS -->
                                    <!-- ================================================= -->

                                    <div class="wishlist-actions">


                                        <!-- ADD TO CART -->

                                        <form
                                            action="{{ route('cart.add', $product->id) }}"
                                            method="POST"
                                            class="wishlist-cart-form"
                                        >

                                            @csrf


                                            <button
                                                type="submit"
                                                class="wishlist-cart-btn"
                                                title="Add to Cart"
                                            >

                                                <i class="fa-solid fa-cart-shopping"></i>

                                            </button>

                                        </form>



                                        <!-- BUY NOW -->

                                        <form
                                            action="{{ route('buy.now', $product->id) }}"
                                            method="POST"
                                            class="wishlist-buy-form"
                                        >

                                            @csrf


                                            <button
                                                type="submit"
                                                class="wishlist-buy-btn"
                                            >
                                                Buy Now
                                            </button>

                                        </form>


                                    </div>


                                </div>

                            </div>


                        @endif


                    @endforeach


                </div>


            @endif


        </div>


    </div>

</section>



<!-- ========================================================= -->
<!-- AJAX TOAST -->
<!-- ========================================================= -->

<div
    id="wishlistToast"
    class="wishlist-ajax-toast"
    aria-live="polite"
>

    <i
        id="wishlistToastIcon"
        class="fa-solid fa-circle-check"
    ></i>


    <span id="wishlistToastMessage">
        Product successfully added!
    </span>

</div>



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | TOAST
        |--------------------------------------------------------------------------
        */

        const toast =
            document.getElementById(
                'wishlistToast'
            );


        const toastIcon =
            document.getElementById(
                'wishlistToastIcon'
            );


        const toastMessage =
            document.getElementById(
                'wishlistToastMessage'
            );


        let toastTimer = null;



        function showToast(
            message,
            type = 'success'
        ) {


            if (!toast) {
                return;
            }


            clearTimeout(
                toastTimer
            );


            toastMessage.textContent =
                message;


            toast.classList.remove(
                'show',
                'success',
                'error'
            );


            if (type === 'error') {

                toast.classList.add(
                    'error'
                );


                toastIcon.className =
                    'fa-solid fa-circle-exclamation';

            } else {

                toast.classList.add(
                    'success'
                );


                toastIcon.className =
                    'fa-solid fa-circle-check';

            }


            setTimeout(
                function () {

                    toast.classList.add(
                        'show'
                    );

                },
                20
            );


            toastTimer =
                setTimeout(
                    function () {

                        toast.classList.remove(
                            'show'
                        );

                    },
                    3000
                );

        }



        /*
        |--------------------------------------------------------------------------
        | ADD TO CART FROM WISHLIST
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.wishlist-cart-form'
            )
            .forEach(
                function (form) {


                    form.addEventListener(
                        'submit',
                        function (event) {


                            event.preventDefault();


                            const button =
                                form.querySelector(
                                    '.wishlist-cart-btn'
                                );


                            if (
                                !button ||
                                button.disabled
                            ) {

                                return;
                            }


                            button.disabled =
                                true;


                            fetch(
                                form.action,
                                {

                                    method: 'POST',

                                    credentials:
                                        'same-origin',

                                    headers: {

                                        'X-CSRF-TOKEN':
                                            '{{ csrf_token() }}',

                                        'X-Requested-With':
                                            'XMLHttpRequest',

                                        'Accept':
                                            'application/json'

                                    },

                                    body:
                                        new FormData(form)

                                }
                            )


                            .then(
                                function (response) {


                                    if (
                                        response.status === 401 ||
                                        response.redirected
                                    ) {

                                        window.location.href =
                                            "{{ route('login') }}";

                                        return null;
                                    }


                                    return response.json();

                                }
                            )


                            .then(
                                function (data) {


                                    if (!data) {
                                        return;
                                    }


                                    if (data.success) {


                                        showToast(
                                            data.message ||
                                            'Product successfully added to cart!',
                                            'success'
                                        );


                                        /*
                                        | Update Cart Count
                                        */

                                        const cartCount =
                                            document.querySelector(
                                                '.cart-count'
                                            );


                                        if (
                                            cartCount &&
                                            data.cart_count !== undefined
                                        ) {

                                            cartCount.textContent =
                                                data.cart_count;

                                        }

                                    } else {


                                        showToast(
                                            data.message ||
                                            'Unable to add product to cart.',
                                            'error'
                                        );

                                    }

                                }
                            )


                            .catch(
                                function (error) {


                                    console.error(
                                        'Wishlist Cart Error:',
                                        error
                                    );


                                    showToast(
                                        'Unable to add product to cart.',
                                        'error'
                                    );

                                }
                            )


                            .finally(
                                function () {

                                    button.disabled =
                                        false;

                                }
                            );

                        }
                    );

                }
            );



        /*
        |--------------------------------------------------------------------------
        | REMOVE FROM WISHLIST
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.wishlist-remove-form'
            )
            .forEach(
                function (form) {


                    form.addEventListener(
                        'submit',
                        function (event) {


                            event.preventDefault();


                            const button =
                                form.querySelector(
                                    '.wishlist-remove'
                                );


                            if (
                                !button ||
                                button.disabled
                            ) {

                                return;
                            }


                            button.disabled =
                                true;


                            const card =
                                form.closest(
                                    '.wishlist-card'
                                );


                            fetch(
                                form.action,
                                {

                                    method: 'POST',

                                    credentials:
                                        'same-origin',

                                    headers: {

                                        'X-CSRF-TOKEN':
                                            '{{ csrf_token() }}',

                                        'X-Requested-With':
                                            'XMLHttpRequest',

                                        'Accept':
                                            'application/json'

                                    },

                                    body:
                                        new FormData(form)

                                }
                            )


                            .then(
                                function (response) {


                                    if (
                                        response.status === 401 ||
                                        response.redirected
                                    ) {

                                        window.location.href =
                                            "{{ route('login') }}";

                                        return null;
                                    }


                                    return response.json();

                                }
                            )


                            .then(
                                function (data) {


                                    if (!data) {
                                        return;
                                    }


                                    if (data.success) {


                                        showToast(
                                            data.message ||
                                            'Product removed from wishlist.',
                                            'success'
                                        );


                                        /*
                                        | Remove Card
                                        */

                                        if (card) {

                                            card.style.opacity =
                                                '0';

                                            card.style.transform =
                                                'scale(0.95)';


                                            card.style.transition =
                                                'all 0.3s ease';


                                            setTimeout(
                                                function () {

                                                    card.remove();


                                                    /*
                                                    | Check if any cards remain
                                                    */

                                                    const remainingCards =
                                                        document.querySelectorAll(
                                                            '.wishlist-card'
                                                        );


                                                    if (
                                                        remainingCards.length ===
                                                        0
                                                    ) {


                                                        const content =
                                                            document.getElementById(
                                                                'wishlistContent'
                                                            );


                                                        if (content) {


                                                            content.innerHTML = `

                                                                <div class="wishlist-empty">

                                                                    <div class="wishlist-empty-icon">

                                                                        <i class="fa-regular fa-heart"></i>

                                                                    </div>

                                                                    <h2>
                                                                        Your Wishlist is Empty
                                                                    </h2>

                                                                    <p>
                                                                        Looks like you haven't added anything to your wishlist yet.
                                                                    </p>

                                                                    <a
                                                                        href="{{ route('products') }}"
                                                                        class="wishlist-empty-btn"
                                                                    >

                                                                        <i class="fa-solid fa-bag-shopping"></i>

                                                                        Start Shopping

                                                                    </a>

                                                                </div>

                                                            `;

                                                        }

                                                    }

                                                },
                                                300
                                            );

                                        }

                                    } else {


                                        showToast(
                                            data.message ||
                                            'Unable to remove product.',
                                            'error'
                                        );


                                        button.disabled =
                                            false;

                                    }

                                }
                            )


                            .catch(
                                function (error) {


                                    console.error(
                                        'Wishlist Remove Error:',
                                        error
                                    );


                                    showToast(
                                        'Unable to remove product from wishlist.',
                                        'error'
                                    );


                                    button.disabled =
                                        false;

                                }
                            );

                        }
                    );

                }
            );


    }
);

</script>

@endsection