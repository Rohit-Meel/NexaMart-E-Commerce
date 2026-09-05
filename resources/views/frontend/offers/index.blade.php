@extends('layouts.frontend')

@section('title', 'Offers - NexaMart')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')


<style>
/* =========================================================
   OFFER WISHLIST - FORCE TOP RIGHT CORNER
========================================================= */

.offer-image {
    position: relative !important;
}


/* FORM WRAPPER */

.offer-image .offer-wishlist-form {
    position: absolute !important;

    top: 12px !important;
    right: 12px !important;

    bottom: auto !important;
    left: auto !important;

    width: 40px !important;
    height: 40px !important;

    margin: 0 !important;
    padding: 0 !important;

    display: block !important;

    z-index: 999 !important;

    transform: none !important;
}


/* WISHLIST BUTTON */

.offer-image .offer-wishlist-form .offer-wishlist-btn {
    position: absolute !important;

    top: 0 !important;
    right: 0 !important;

    bottom: auto !important;
    left: auto !important;

    width: 40px !important;
    height: 40px !important;

    min-width: 40px !important;
    min-height: 40px !important;

    max-width: 40px !important;
    max-height: 40px !important;

    margin: 0 !important;
    padding: 0 !important;

    display: flex !important;

    align-items: center !important;
    justify-content: center !important;

    border-radius: 50% !important;

    border: none !important;

    text-decoration: none !important;

    line-height: 1 !important;

    transform: none !important;

    z-index: 1000 !important;

    box-sizing: border-box !important;
}


/* LOGIN WISHLIST - <a> */

.offer-image > .offer-wishlist-btn {
    position: absolute !important;

    top: 12px !important;
    right: 12px !important;

    bottom: auto !important;
    left: auto !important;

    width: 40px !important;
    height: 40px !important;

    min-width: 40px !important;
    min-height: 40px !important;

    max-width: 40px !important;
    max-height: 40px !important;

    margin: 0 !important;
    padding: 0 !important;

    display: flex !important;

    align-items: center !important;
    justify-content: center !important;

    border-radius: 50% !important;

    text-decoration: none !important;

    z-index: 1000 !important;

    transform: none !important;

    box-sizing: border-box !important;
}


/* HEART ICON */

.offer-image .offer-wishlist-btn i {
    margin: 0 !important;
    padding: 0 !important;

    display: block !important;

    line-height: 1 !important;

    text-decoration: none !important;
}


/* REMOVE UNDERLINE */

.offer-image .offer-wishlist-btn,
.offer-image .offer-wishlist-btn:hover,
.offer-image .offer-wishlist-btn:focus,
.offer-image .offer-wishlist-btn:active {
    text-decoration: none !important;
}
/* =========================================================
   OFFERS PAGE
========================================================= */

.offers-page {
    width: 100%;
    padding: 35px 0 60px;
}

.offers-container {
    width: 92%;
    max-width: 1200px;
    margin: 0 auto;
}


/* =========================================================
   BREADCRUMB
========================================================= */

.offers-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 25px;
    font-size: 13px;
}

.offers-breadcrumb a {
    text-decoration: none !important;
}

.offers-breadcrumb i {
    font-size: 11px;
}


/* =========================================================
   HEADING
========================================================= */

.offers-heading {
    margin-bottom: 28px;
}

.offers-heading span {
    display: inline-block;
    margin-bottom: 8px;

    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
}

.offers-heading h1 {
    margin: 0 0 8px;
    font-size: 36px;
    line-height: 1.2;
}

.offers-heading strong {
    font-weight: 800;
}

.offers-heading p {
    margin: 0;
    font-size: 14px;
}


/* =========================================================
   OFFER BANNER
========================================================= */

.offers-banner {
    min-height: 210px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 35px 45px;

    border-radius: 12px;
    overflow: hidden;

    margin-bottom: 35px;
}

.offers-banner-content {
    max-width: 650px;
}

.offers-banner-content > span {
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
}

.offers-banner-content h2 {
    margin: 10px 0;
    font-size: 32px;
    line-height: 1.15;
}

.offers-banner-content p {
    margin: 0 0 18px;
    font-size: 14px;
}

.offers-banner-content a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    padding: 11px 20px;

    border-radius: 7px;

    text-decoration: none !important;
}

.offers-banner-side {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    min-width: 150px;
}

.offers-banner-side strong {
    font-size: 14px;
}

.offers-banner-side b {
    font-size: 60px;
    line-height: 1;
}

.offers-banner-side span {
    font-size: 18px;
    font-weight: 700;
}


/* =========================================================
   TOOLBAR
========================================================= */

.offers-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    margin-bottom: 22px;
}

.offers-toolbar h2 {
    margin: 0 0 5px;
    font-size: 24px;
}

.offers-toolbar p {
    margin: 0;
    font-size: 13px;
}

.offers-select {
    min-width: 190px;
    height: 42px;

    padding: 0 12px;

    border-radius: 7px;
    border: 1px solid #d8deea;

    outline: none;
}


/* =========================================================
   OFFERS GRID
========================================================= */

.offers-grid {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 20px;

    align-items: stretch;
}


/* =========================================================
   OFFER CARD
========================================================= */

.offer-card {
    min-width: 0;

    display: flex;
    flex-direction: column;

    border-radius: 9px;
    overflow: hidden;

    border: 1px solid #dce2ed;

    background: #ffffff;

    box-sizing: border-box;
}


/* =========================================================
   OFFER IMAGE
========================================================= */

.offer-image {
    position: relative;

    width: 100%;
    height: 230px;

    min-height: 230px;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    box-sizing: border-box;
}


/*
|--------------------------------------------------------------------------
| PRODUCT IMAGE
|--------------------------------------------------------------------------
*/

.offer-image > img {
    width: 100% !important;
    height: 100% !important;

    max-width: 100% !important;
    max-height: 100% !important;

    display: block !important;

    object-fit: contain !important;
    object-position: center center !important;

    margin: 0 !important;
    padding: 0 !important;

    box-sizing: border-box;
}


/* =========================================================
   OFFER BADGE
========================================================= */

.offer-badge {
    position: absolute;

    top: 12px;
    left: 12px;

    z-index: 10;

    padding: 5px 9px;

    border-radius: 3px;

    font-size: 10px;
    font-weight: 700;
}


/* =========================================================
   OFFER WISHLIST
========================================================= */

/*
|--------------------------------------------------------------------------
| FORM
|--------------------------------------------------------------------------
*/

.offer-wishlist-form {
    position: absolute !important;

    top: 12px !important;
    right: 12px !important;

    left: auto !important;
    bottom: auto !important;

    width: auto !important;
    height: auto !important;

    min-width: 0 !important;
    max-width: none !important;

    margin: 0 !important;
    padding: 0 !important;

    display: block !important;

    z-index: 30 !important;

    float: none !important;

    transform: none !important;
}


/*
|--------------------------------------------------------------------------
| BUTTON + LOGIN LINK
|--------------------------------------------------------------------------
*/

.offer-wishlist-btn {
    width: 40px !important;
    height: 40px !important;

    min-width: 40px !important;
    max-width: 40px !important;

    min-height: 40px !important;
    max-height: 40px !important;

    margin: 0 !important;
    padding: 0 !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    border: none !important;
    outline: none !important;

    border-radius: 50% !important;

    text-decoration: none !important;

    line-height: 1 !important;

    box-sizing: border-box !important;

    cursor: pointer;

    flex: 0 0 40px !important;
}


/*
|--------------------------------------------------------------------------
| REMOVE GLOBAL UNDERLINE
|--------------------------------------------------------------------------
*/

.offer-wishlist-btn,
.offer-wishlist-btn:hover,
.offer-wishlist-btn:focus,
.offer-wishlist-btn:active {
    text-decoration: none !important;
}


/*
|--------------------------------------------------------------------------
| HEART ICON
|--------------------------------------------------------------------------
*/

.offer-wishlist-btn i {
    display: block !important;

    margin: 0 !important;
    padding: 0 !important;

    line-height: 1 !important;

    text-decoration: none !important;
}


/* =========================================================
   OFFER INFO
========================================================= */

.offer-info {
    flex: 1;

    display: flex;
    flex-direction: column;

    padding: 14px;
}

.offer-category {
    display: block;

    margin-bottom: 5px;

    font-size: 10px;
    font-weight: 700;
}

.offer-info h3 {
    margin: 0 0 7px;

    font-size: 15px;
    line-height: 1.3;
}

.offer-brand {
    display: block;

    margin-bottom: 8px;

    font-size: 12px;
}


/* =========================================================
   RATING
========================================================= */

.offer-rating {
    display: flex;
    align-items: center;
    gap: 6px;

    margin-bottom: 7px;
}

.offer-rating span {
    font-size: 13px;
}

.offer-rating small {
    font-size: 10px;
}


/* =========================================================
   PRICE
========================================================= */

.offer-price {
    display: flex;
    align-items: center;
    gap: 8px;

    margin-bottom: 12px;
}

.offer-price strong {
    font-size: 16px;
}

.offer-price del {
    font-size: 10px;
}


/* =========================================================
   ACTIONS
========================================================= */

.offer-actions {
    width: 100%;

    display: flex;
    align-items: center;

    gap: 8px;

    margin-top: auto;

    box-sizing: border-box;
}


/*
|--------------------------------------------------------------------------
| CART FORM
|--------------------------------------------------------------------------
*/

.offer-cart-form {
    width: 42px !important;
    min-width: 42px !important;

    height: 38px !important;

    margin: 0 !important;
    padding: 0 !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    flex: 0 0 42px !important;
}


/*
|--------------------------------------------------------------------------
| CART BUTTON
|--------------------------------------------------------------------------
*/

.offer-cart-btn {
    width: 42px !important;
    height: 38px !important;

    min-width: 42px !important;

    margin: 0 !important;
    padding: 0 !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    border-radius: 6px !important;

    line-height: 1 !important;

    text-decoration: none !important;

    box-sizing: border-box !important;

    cursor: pointer;
}

.offer-cart-btn i {
    margin: 0 !important;
    padding: 0 !important;

    line-height: 1 !important;
}


/*
|--------------------------------------------------------------------------
| BUY NOW FORM
|--------------------------------------------------------------------------
*/

.offer-buy-form {
    margin: 0 !important;
    padding: 0 !important;

    flex: 1 1 auto !important;

    width: auto !important;

    height: 38px !important;

    min-width: 0 !important;

    display: flex !important;
}


/*
|--------------------------------------------------------------------------
| BUY NOW BUTTON
|--------------------------------------------------------------------------
*/

.offer-buy-btn {
    width: 100% !important;
    height: 38px !important;

    min-height: 38px !important;

    margin: 0 !important;
    padding: 0 12px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    border: none !important;

    border-radius: 6px !important;

    line-height: 1 !important;

    text-align: center !important;

    text-decoration: none !important;

    cursor: pointer;

    box-sizing: border-box !important;
}


/*
|--------------------------------------------------------------------------
| LOGIN BUY NOW
|--------------------------------------------------------------------------
*/

a.offer-buy-btn {
    text-decoration: none !important;
}


/* =========================================================
   SHOP DEAL
========================================================= */

.offer-deal-btn {
    width: 100%;

    height: 34px;

    margin-top: 8px;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    border-radius: 5px;

    text-decoration: none !important;

    font-size: 11px;

    box-sizing: border-box;
}

.offer-deal-btn:hover {
    text-decoration: none !important;
}


/* =========================================================
   NO RESULT
========================================================= */

.offers-no-result {
    min-height: 220px;

    display: flex;
    flex-direction: column;

    align-items: center;
    justify-content: center;

    text-align: center;

    padding: 30px;

    border: 1px dashed #d8deea;
    border-radius: 10px;
}

.offers-no-result i {
    font-size: 35px;

    margin-bottom: 12px;
}

.offers-no-result h3 {
    margin: 0 0 6px;
}

.offers-no-result p {
    margin: 0 0 15px;
}

.offers-no-result a {
    text-decoration: none !important;
}


/* =========================================================
   COUPONS
========================================================= */

.offers-coupons {
    margin-top: 45px;
}

.offers-coupons-heading {
    margin-bottom: 20px;
}

.offers-coupons-heading span {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
}

.offers-coupons-heading h2 {
    margin: 6px 0;

    font-size: 25px;
}

.offers-coupons-heading p {
    margin: 0;

    font-size: 13px;
}

.offers-coupons-grid {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 15px;
}

.offer-coupon-card {
    display: flex;
    align-items: center;

    gap: 12px;

    padding: 15px;

    border: 1px solid #dce2ed;
    border-radius: 8px;
}

.offer-coupon-icon {
    width: 40px;
    height: 40px;

    min-width: 40px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;
}

.offer-coupon-info {
    flex: 1;
    min-width: 0;
}

.offer-coupon-info h3 {
    margin: 0 0 4px;
}

.offer-coupon-info p {
    margin: 0 0 4px;

    font-size: 12px;
}

.offer-coupon-info small {
    font-size: 10px;
}

.offer-copy-btn {
    height: 34px;

    padding: 0 12px;

    border: none;

    border-radius: 5px;

    cursor: pointer;
}


/* =========================================================
   BOTTOM CTA
========================================================= */

.offers-cta {
    margin-top: 45px;

    padding: 30px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    border-radius: 10px;
}

.offers-cta span {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
}

.offers-cta h2 {
    margin: 7px 0;

    font-size: 25px;
}

.offers-cta p {
    margin: 0;

    font-size: 13px;
}

.offers-cta > a {
    display: flex;
    align-items: center;
    justify-content: center;

    gap: 8px;

    padding: 12px 20px;

    border-radius: 6px;

    text-decoration: none !important;

    white-space: nowrap;
}


/* =========================================================
   TOAST
========================================================= */

.offer-ajax-toast {
    position: fixed;

    top: 20px;
    left: 50%;

    transform: translate(-50%, -20px);

    z-index: 99999;

    min-width: 280px;
    max-width: 90%;

    padding: 13px 18px;

    display: flex;
    align-items: center;

    gap: 10px;

    border-radius: 7px;

    opacity: 0;

    pointer-events: none;

    transition:
        opacity .25s ease,
        transform .25s ease;

    box-sizing: border-box;
}

.offer-ajax-toast.show {
    opacity: 1;

    transform: translate(-50%, 0);
}

.offer-ajax-toast i {
    font-size: 16px;
}

.offer-ajax-toast span {
    font-size: 13px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .offers-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .offers-coupons-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}


@media (max-width: 600px) {

    .offers-container {
        width: 94%;
    }

    .offers-heading h1 {
        font-size: 28px;
    }

    .offers-banner {
        flex-direction: column;

        align-items: flex-start;

        padding: 25px;
    }

    .offers-banner-side {
        align-self: flex-end;
    }

    .offers-toolbar {
        flex-direction: column;

        align-items: stretch;
    }

    .offers-select {
        width: 100%;
    }

    .offers-grid {
        grid-template-columns: 1fr;

        gap: 16px;
    }

    .offers-coupons-grid {
        grid-template-columns: 1fr;
    }

    .offers-cta {
        flex-direction: column;

        align-items: flex-start;
    }

    .offer-image {
        height: 240px;

        min-height: 240px;
    }

}


</style>


<!-- =========================================================
     ALERTS
========================================================= -->

@if(session('success'))

    <div class="home-alert home-alert-success">

        <i class="fa-solid fa-circle-check"></i>

        <span>
            {{ session('success') }}
        </span>

    </div>

@endif


@if(session('error'))

    <div class="home-alert home-alert-error">

        <i class="fa-solid fa-circle-exclamation"></i>

        <span>
            {{ session('error') }}
        </span>

    </div>

@endif


<!-- =========================================================
     OFFERS PAGE
========================================================= -->

<section class="offers-page">

    <div class="offers-container">


        <!-- =====================================================
             BREADCRUMB
        ====================================================== -->

        <div class="offers-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <span>
                Offers
            </span>

        </div>


        <!-- =====================================================
             HEADING
        ====================================================== -->

        <div class="offers-heading">

            <div>

                <span>
                    SPECIAL DEALS
                </span>

                <h1>
                    Grab The Best
                    <strong>Offers</strong>
                </h1>

                <p>
                    Save more on your favourite products
                    with our latest deals.
                </p>

            </div>

        </div>


        <!-- =====================================================
             OFFER BANNER
        ====================================================== -->

        <div class="offers-banner">

            <div class="offers-banner-content">

                <span>
                    LIMITED TIME OFFER
                </span>

                <h2>
                    Big Savings.<br>
                    Bigger Shopping.
                </h2>

                <p>
                    Get amazing discounts on selected products.
                </p>

                <a href="{{ route('products') }}">

                    Shop Now

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>


            <div class="offers-banner-side">

                <strong>
                    UP TO
                </strong>

                <b>
                    50%
                </b>

                <span>
                    OFF
                </span>

            </div>

        </div>


        <!-- =====================================================
             TOOLBAR
        ====================================================== -->

        <div class="offers-toolbar">

            <div>

                <h2>
                    Today's Deals
                </h2>

                <p>
                    Fresh offers picked for you
                </p>

            </div>


            <select
                class="offers-select"
                id="offerCategoryFilter"
            >

                <option value="all">
                    All Offers
                </option>


                @foreach($categories as $category)

                    <option value="{{ $category->slug }}">

                        {{ $category->name }}

                    </option>

                @endforeach

            </select>

        </div>


        <!-- =====================================================
             OFFERS GRID
        ====================================================== -->

        @if($offerProducts->count())


            <div
                class="offers-grid"
                id="offersGrid"
            >


                @foreach($offerProducts as $product)


                    @php

                        $sellingPrice =
                            $product->sale_price;

                        $discount =
                            round(
                                (
                                    ($product->price - $product->sale_price)
                                    / $product->price
                                ) * 100
                            );

                        $reviewCount =
                            $product->reviews->count();

                    @endphp


                    <div
                        class="offer-card"
                        data-category="{{ $product->category->slug ?? '' }}"
                    >


                        <!-- =================================================
                             IMAGE
                        ================================================== -->

                        <div class="offer-image">


                            <!-- OFFER BADGE -->

                            <span class="offer-badge">

                                {{ $discount }}% OFF

                            </span>


                            <!-- =================================================
                                 WISHLIST
                            ================================================== -->

                            @auth('customer')


                                @php

                                    $isWishlisted =
                                        auth('customer')
                                            ->user()
                                            ->wishlists()
                                            ->where(
                                                'product_id',
                                                $product->id
                                            )
                                            ->exists();

                                @endphp


                                @if($isWishlisted)


                                    <form
                                        action="{{ route('wishlist.remove', $product->id) }}"
                                        method="POST"
                                        class="offer-wishlist-form"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="offer-wishlist-btn active"
                                            title="Remove from Wishlist"
                                        >

                                            <i class="fa-solid fa-heart"></i>

                                        </button>

                                    </form>


                                @else


                                    <form
                                        action="{{ route('wishlist.add', $product->id) }}"
                                        method="POST"
                                        class="offer-wishlist-form"
                                    >

                                        @csrf


                                        <button
                                            type="submit"
                                            class="offer-wishlist-btn"
                                            title="Add to Wishlist"
                                        >

                                            <i class="fa-regular fa-heart"></i>

                                        </button>

                                    </form>


                                @endif


                            @else


                                <a
                                    href="{{ route('login') }}"
                                    class="offer-wishlist-btn"
                                    title="Login to add Wishlist"
                                >

                                    <i class="fa-regular fa-heart"></i>

                                </a>


                            @endauth


                            <!-- =================================================
                                 PRODUCT IMAGE
                            ================================================== -->

                            @if($product->thumbnail)

                                <img
                                    src="{{ asset('assets/images/products/' . $product->thumbnail) }}"
                                    alt="{{ $product->name }}"
                                >

                            @else

                                <img
                                    src="{{ asset('assets/images/logo/banner.png') }}"
                                    alt="{{ $product->name }}"
                                >

                            @endif


                        </div>


                        <!-- =================================================
                             PRODUCT INFO
                        ================================================== -->

                        <div class="offer-info">


                            @if($product->category)

                                <span class="offer-category">

                                    {{ $product->category->name }}

                                </span>

                            @endif


                            <h3>

                                {{ $product->name }}

                            </h3>


                            @if($product->brand)

                                <small class="offer-brand">

                                    {{ $product->brand->name }}

                                </small>

                            @endif


                            <!-- RATING -->

                            <div class="offer-rating">

                                <span>
                                    ★★★★★
                                </span>

                                <small>
                                    ({{ $reviewCount }})
                                </small>

                            </div>


                            <!-- PRICE -->

                            <div class="offer-price">

                                <strong>

                                    ₹{{ number_format($sellingPrice, 2) }}

                                </strong>


                                <del>

                                    ₹{{ number_format($product->price, 2) }}

                                </del>

                            </div>


                            <!-- =================================================
                                 ACTIONS
                            ================================================== -->

                            <div class="offer-actions">


                                @auth('customer')


                                    <!-- ADD TO CART -->

                                    <form
                                        action="{{ route('cart.add', $product->id) }}"
                                        method="POST"
                                        class="offer-cart-form"
                                    >

                                        @csrf


                                        <button
                                            type="submit"
                                            class="offer-cart-btn"
                                            title="Add to Cart"
                                        >

                                            <i class="fa-solid fa-cart-shopping"></i>

                                        </button>

                                    </form>


                                    <!-- BUY NOW -->

                                    <form
                                        action="{{ route('buy.now', $product->id) }}"
                                        method="POST"
                                        class="offer-buy-form"
                                    >

                                        @csrf


                                        <button
                                            type="submit"
                                            class="offer-buy-btn"
                                        >

                                            Buy Now

                                        </button>

                                    </form>


                                @else


                                    <!-- LOGIN CART -->

                                    <a
                                        href="{{ route('login') }}"
                                        class="offer-cart-btn"
                                        title="Login to Add to Cart"
                                    >

                                        <i class="fa-solid fa-cart-shopping"></i>

                                    </a>


                                    <!-- LOGIN BUY NOW -->

                                    <a
                                        href="{{ route('login') }}"
                                        class="offer-buy-btn"
                                    >

                                        Buy Now

                                    </a>


                                @endauth


                            </div>


                            <!-- =================================================
                                 SHOP DEAL
                            ================================================== -->

                            <a
                                href="{{ route('products', ['search' => $product->name]) }}"
                                class="offer-deal-btn"
                            >

                                Shop Deal

                                <i class="fa-solid fa-arrow-right"></i>

                            </a>


                        </div>


                    </div>


                @endforeach


            </div>


            <!-- =====================================================
                 NO FILTER RESULT
            ====================================================== -->

            <div
                class="offers-no-result"
                id="offersNoResult"
                style="display:none;"
            >

                <i class="fa-solid fa-box-open"></i>

                <h3>
                    No Offers Found
                </h3>

                <p>
                    There are no offers available in this category.
                </p>

            </div>


        @else


            <!-- =====================================================
                 NO OFFERS
            ====================================================== -->

            <div class="offers-no-result">

                <i class="fa-solid fa-tags"></i>

                <h3>
                    No Offers Available
                </h3>

                <p>
                    There are currently no discounted products.
                </p>

                <a href="{{ route('products') }}">

                    Browse Products

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>


        @endif


        <!-- =====================================================
             ACTIVE COUPONS
        ====================================================== -->

        @if($coupons->count())


            <section class="offers-coupons">


                <div class="offers-coupons-heading">

                    <span>
                        EXTRA SAVINGS
                    </span>

                    <h2>
                        Available <strong>Coupons</strong>
                    </h2>

                    <p>
                        Use these coupons at checkout
                        to save even more.
                    </p>

                </div>


                <div class="offers-coupons-grid">


                    @foreach($coupons as $coupon)


                        <div class="offer-coupon-card">


                            <div class="offer-coupon-icon">

                                <i class="fa-solid fa-ticket"></i>

                            </div>


                            <div class="offer-coupon-info">

                                <h3>

                                    {{ $coupon->code }}

                                </h3>


                                <p>

                                    {{
                                        $coupon->description
                                        ?: (
                                            $coupon->discount_type === 'percentage'
                                            ? $coupon->discount_value . '% OFF'
                                            : '₹' . number_format($coupon->discount_value, 2) . ' OFF'
                                        )
                                    }}

                                </p>


                                @if($coupon->minimum_order_amount > 0)

                                    <small>

                                        Min. order:
                                        ₹{{ number_format($coupon->minimum_order_amount, 2) }}

                                    </small>

                                @endif


                            </div>


                            <button
                                type="button"
                                class="offer-copy-btn"
                                data-code="{{ $coupon->code }}"
                            >

                                <i class="fa-regular fa-copy"></i>

                                Copy

                            </button>


                        </div>


                    @endforeach


                </div>


            </section>


        @endif


        <!-- =====================================================
             BOTTOM CTA
        ====================================================== -->

        <div class="offers-cta">


            <div>

                <span>
                    DON'T MISS OUT
                </span>

                <h2>
                    More deals are waiting for you.
                </h2>

                <p>
                    Explore our complete collection
                    and save on every purchase.
                </p>

            </div>


            <a href="{{ route('products') }}">

                View All Products

                <i class="fa-solid fa-arrow-right"></i>

            </a>


        </div>


    </div>

</section>


<!-- =========================================================
     OFFERS JS
========================================================= -->

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------------------
        */

        const categoryFilter =
            document.querySelector(
                '#offerCategoryFilter'
            );


        const offerCards =
            document.querySelectorAll(
                '.offer-card'
            );


        const noResult =
            document.querySelector(
                '#offersNoResult'
            );


        if (categoryFilter) {

            categoryFilter.addEventListener(
                'change',
                function () {


                    const selectedCategory =
                        this.value;


                    let visibleCount =
                        0;


                    offerCards.forEach(
                        function (card) {


                            const cardCategory =
                                card.dataset.category;


                            if (
                                selectedCategory === 'all' ||
                                selectedCategory === cardCategory
                            ) {


                                card.style.display =
                                    '';


                                visibleCount++;


                            } else {


                                card.style.display =
                                    'none';

                            }

                        }
                    );


                    if (noResult) {

                        noResult.style.display =
                            visibleCount === 0
                            ? 'flex'
                            : 'none';

                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | COPY COUPON
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll(
            '.offer-copy-btn'
        ).forEach(
            function (button) {


                button.addEventListener(
                    'click',
                    async function () {


                        const code =
                            button.dataset.code;


                        try {


                            await navigator.clipboard.writeText(
                                code
                            );


                            const originalHTML =
                                button.innerHTML;


                            button.innerHTML =
                                '<i class="fa-solid fa-check"></i> Copied';


                            button.disabled =
                                true;


                            setTimeout(
                                function () {


                                    button.innerHTML =
                                        originalHTML;


                                    button.disabled =
                                        false;


                                },
                                1500
                            );


                        } catch (error) {


                            console.error(
                                'Coupon Copy Error:',
                                error
                            );

                        }

                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | ADD TO CART AJAX
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll(
            '.offer-cart-form'
        ).forEach(
            function (form) {


                form.addEventListener(
                    'submit',
                    async function (event) {


                        event.preventDefault();


                        const button =
                            form.querySelector(
                                'button[type="submit"]'
                            );


                        if (!button) {

                            return;

                        }


                        if (
                            button.dataset.loading ===
                            'true'
                        ) {

                            return;

                        }


                        const originalHTML =
                            button.innerHTML;


                        button.dataset.loading =
                            'true';


                        button.disabled =
                            true;


                        try {


                            const response =
                                await fetch(
                                    form.action,
                                    {
                                        method: 'POST',

                                        headers: {

                                            'X-CSRF-TOKEN':
                                                document
                                                    .querySelector(
                                                        'meta[name="csrf-token"]'
                                                    )
                                                    .getAttribute(
                                                        'content'
                                                    ),

                                            'Accept':
                                                'application/json',

                                            'X-Requested-With':
                                                'XMLHttpRequest'

                                        },

                                        body:
                                            new FormData(
                                                form
                                            )

                                    }
                                );


                            const data =
                                await response.json();


                            if (
                                !response.ok ||
                                !data.success
                            ) {


                                throw new Error(
                                    data.message ||
                                    'Unable to add product to cart.'
                                );

                            }


                            button.innerHTML =
                                '<i class="fa-solid fa-check"></i>';


                            showOfferToast(
                                data.message ||
                                'Product added to cart.',
                                'success'
                            );


                            setTimeout(
                                function () {


                                    button.innerHTML =
                                        originalHTML;


                                    button.disabled =
                                        false;


                                    button.dataset.loading =
                                        'false';


                                },
                                1200
                            );


                        } catch (error) {


                            console.error(
                                'Offer Cart Error:',
                                error
                            );


                            showOfferToast(
                                error.message ||
                                'Something went wrong.',
                                'error'
                            );


                            button.innerHTML =
                                originalHTML;


                            button.disabled =
                                false;


                            button.dataset.loading =
                                'false';

                        }

                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | WISHLIST AJAX
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll(
            '.offer-wishlist-form'
        ).forEach(
            function (form) {


                form.addEventListener(
                    'submit',
                    async function (event) {


                        event.preventDefault();


                        const button =
                            form.querySelector(
                                'button[type="submit"]'
                            );


                        if (!button) {

                            return;

                        }


                        if (
                            button.dataset.loading ===
                            'true'
                        ) {

                            return;

                        }


                        const originalHTML =
                            button.innerHTML;


                        const isRemove =
                            form.querySelector(
                                'input[name="_method"]'
                            )?.value === 'DELETE';


                        button.dataset.loading =
                            'true';


                        button.disabled =
                            true;


                        try {


                            const response =
                                await fetch(
                                    form.action,
                                    {

                                        method: 'POST',

                                        headers: {

                                            'X-CSRF-TOKEN':
                                                document
                                                    .querySelector(
                                                        'meta[name="csrf-token"]'
                                                    )
                                                    .getAttribute(
                                                        'content'
                                                    ),

                                            'Accept':
                                                'application/json',

                                            'X-Requested-With':
                                                'XMLHttpRequest'

                                        },

                                        body:
                                            new FormData(
                                                form
                                            )

                                    }
                                );


                            const data =
                                await response.json();


                            if (
                                !response.ok ||
                                !data.success
                            ) {


                                throw new Error(
                                    data.message ||
                                    'Unable to update wishlist.'
                                );

                            }


                            if (isRemove) {


                                button.classList.remove(
                                    'active'
                                );


                                button.innerHTML =
                                    '<i class="fa-regular fa-heart"></i>';


                                button.title =
                                    'Add to Wishlist';


                                form.action =
                                    form.action.replace(
                                        '/wishlist/remove/',
                                        '/wishlist/add/'
                                    );


                                const methodInput =
                                    form.querySelector(
                                        'input[name="_method"]'
                                    );


                                if (methodInput) {

                                    methodInput.remove();

                                }


                            } else {


                                button.classList.add(
                                    'active'
                                );


                                button.innerHTML =
                                    '<i class="fa-solid fa-heart"></i>';


                                button.title =
                                    'Remove from Wishlist';


                                let methodInput =
                                    form.querySelector(
                                        'input[name="_method"]'
                                    );


                                if (!methodInput) {


                                    methodInput =
                                        document.createElement(
                                            'input'
                                        );


                                    methodInput.type =
                                        'hidden';


                                    methodInput.name =
                                        '_method';


                                    form.appendChild(
                                        methodInput
                                    );

                                }


                                methodInput.value =
                                    'DELETE';


                                form.action =
                                    form.action.replace(
                                        '/wishlist/add/',
                                        '/wishlist/remove/'
                                    );

                            }


                            showOfferToast(
                                data.message ||
                                'Wishlist updated.',
                                'success'
                            );


                            button.disabled =
                                false;


                            button.dataset.loading =
                                'false';


                        } catch (error) {


                            console.error(
                                'Offer Wishlist Error:',
                                error
                            );


                            showOfferToast(
                                error.message ||
                                'Something went wrong.',
                                'error'
                            );


                            button.innerHTML =
                                originalHTML;


                            button.disabled =
                                false;


                            button.dataset.loading =
                                'false';

                        }

                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | OFFER TOAST
        |--------------------------------------------------------------------------
        */

        function showOfferToast(
            message,
            type
        ) {


            const oldToast =
                document.querySelector(
                    '.offer-ajax-toast'
                );


            if (oldToast) {

                oldToast.remove();

            }


            const toast =
                document.createElement(
                    'div'
                );


            toast.className =
                'offer-ajax-toast ' +
                (
                    type === 'success'
                    ? 'success'
                    : 'error'
                );


            toast.innerHTML = `
                <i class="${
                    type === 'success'
                        ? 'fa-solid fa-circle-check'
                        : 'fa-solid fa-circle-exclamation'
                }"></i>

                <span>
                    ${message}
                </span>
            `;


            document.body.appendChild(
                toast
            );


            requestAnimationFrame(
                function () {


                    toast.classList.add(
                        'show'
                    );

                }
            );


            setTimeout(
                function () {


                    toast.classList.remove(
                        'show'
                    );


                    setTimeout(
                        function () {


                            toast.remove();

                        },
                        350
                    );


                },
                2500
            );

        }


    }
);

</script>


@endsection