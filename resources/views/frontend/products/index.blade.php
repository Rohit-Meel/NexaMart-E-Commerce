@extends('layouts.frontend')

@section('title', 'Products - NexaMart')

@section('content')

@php

/*
|--------------------------------------------------------------------------
| Logged In Customer Wishlist IDs
|--------------------------------------------------------------------------
*/

$wishlistProductIds = [];

if (Auth::guard('customer')->check()) {

$wishlistProductIds = \App\Models\Wishlist::where(
'customer_id',
Auth::guard('customer')->id()
)
->pluck('product_id')
->toArray();
}

@endphp


<style>
    /*
    |--------------------------------------------------------------------------
    | PRODUCT IMAGE / WISHLIST POSITION
    |--------------------------------------------------------------------------
    */

    .shop-product-image {
        position: relative;
    }


    .shop-product-image .wishlist-form {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 20;
        margin: 0;
        padding: 0;
    }


    .shop-product-image .wishlist-btn {
        width: 34px;
        height: 34px;
        padding: 0;
        margin: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border: 1px solid #d9e2ef;
        border-radius: 50%;

        background: #ffffff;

        cursor: pointer;

        position: relative;
        z-index: 21;

        transition: all 0.2s ease;
    }


    .shop-product-image .wishlist-btn:hover {
        transform: scale(1.08);
    }


    .shop-product-image .wishlist-btn i {
        font-size: 17px;
    }


    .shop-product-image .wishlist-btn.wishlisted {
        color: #b91c1c;
    }


    /* .shop-product-image .wishlist-btn:disabled {
        opacity: 0.65;
        cursor: wait;
    } */


    /*
    |--------------------------------------------------------------------------
    | AJAX TOAST
    |--------------------------------------------------------------------------
    */

    .nexamart-ajax-toast {
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

        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.14);

        z-index: 99999;

        opacity: 0;

        transform: translateY(-20px);

        pointer-events: none;

        transition:
            opacity 0.3s ease,
            transform 0.3s ease;
    }


    .nexamart-ajax-toast.show {
        opacity: 1;
        transform: translateY(0);
    }


    .nexamart-ajax-toast.success {
        border-left: 4px solid #198754;
    }


    .nexamart-ajax-toast.error {
        border-left: 4px solid #dc3545;
    }


    .nexamart-ajax-toast i {
        font-size: 19px;
    }


    .nexamart-ajax-toast.success i {
        color: #198754;
    }


    .nexamart-ajax-toast.error i {
        color: #dc3545;
    }


    .nexamart-ajax-toast span {
        font-size: 14px;
        line-height: 1.4;
    }


    @media(max-width: 576px) {

        .shop-product-image .wishlist-form {
            top: 8px;
            right: 8px;
        }


        .shop-product-image .wishlist-btn {
            width: 32px;
            height: 32px;
        }


        .shop-product-image .wishlist-btn i {
            font-size: 16px;
        }


        .nexamart-ajax-toast {
            left: 15px;
            right: 15px;

            top: 15px;

            min-width: auto;
            max-width: none;
        }

    }
    /* ================================
   PRODUCT SECTION - BUY NOW BUTTON
================================ */

.product-card .buy-now-btn {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;

    width: 68px !important;
    height: 35px !important;

    padding: 0 8px !important;
    margin: 0 !important;

    border: none !important;
    border-radius: 4px !important;

    background: #FF7A00 !important;
    color: #ffffff !important;

    font-size: 10px !important;
    font-weight: 700 !important;
    line-height: 1 !important;

    text-align: center !important;
    text-decoration: none !important;

    cursor: pointer;

    white-space: nowrap;

    box-sizing: border-box;

    transition:
        background-color 0.25s ease,
        transform 0.2s ease,
        box-shadow 0.25s ease;
}


/* HOVER */

.product-card .buy-now-btn:hover {
    background: #D8001B !important;
    color: #ffffff !important;

    text-decoration: none !important;

    transform: translateY(-1px);

    box-shadow: 0 3px 8px rgba(216, 0, 27, 0.20);
}


/* ACTIVE */

.product-card .buy-now-btn:active {
    transform: translateY(0);
    box-shadow: none;
}


/* FOCUS */

.product-card .buy-now-btn:focus {
    outline: none !important;
    color: #ffffff !important;
}


/* DISABLED */

.product-card .buy-now-btn:disabled,
.product-card .buy-now-btn.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    pointer-events: none;
}


/* ================================
   PRODUCT ACTION AREA
================================ */

.product-card .product-actions,
.product-card .action-buttons,
.product-card .product-bottom {
    display: flex;
    align-items: center;
    gap: 5px;
}


/* CART BUTTON */

.product-card .cart-btn {
    width: 35px !important;
    height: 35px !important;

    padding: 0 !important;
    margin: 0 !important;

    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;

    border: none !important;
    border-radius: 4px !important;

    background: #003680 !important;
    color: #ffffff !important;

    cursor: pointer;
}


/* ================================
   MOBILE
================================ */

@media (max-width: 767px) {

    .product-card .buy-now-btn {
        width: 68px !important;
        height: 36px !important;
        font-size: 10px !important;
    }

    .product-card .cart-btn {
        width: 36px !important;
        height: 36px !important;
    }
}


@media (max-width: 480px) {

    .product-card .buy-now-btn {
        width: 64px !important;
        height: 35px !important;
        font-size: 9px !important;
        padding: 0 6px !important;
    }

    .product-card .cart-btn {
        width: 34px !important;
        height: 35px !important;
    }
}
/* PRODUCT SECTION BUY NOW */

.product-card .buy-now-btn {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    width: 68px !important;
    min-width: 68px !important;
    max-width: 68px !important;

    height: 35px !important;
    min-height: 35px !important;
    max-height: 35px !important;

    padding: 0 !important;
    margin: 0 !important;

    box-sizing: border-box !important;

    background: #FF7A00 !important;
    color: #ffffff !important;

    border: none !important;
    border-radius: 4px !important;

    font-size: 10px !important;
    font-weight: 700 !important;
    line-height: 1 !important;

    text-align: center !important;
    text-decoration: none !important;

    white-space: nowrap !important;

    flex: 0 0 68px !important;

    cursor: pointer;
}


/* HOVER */

.product-card .buy-now-btn:hover {
    background: #D8001B !important;
    color: #ffffff !important;
    text-decoration: none !important;
}


/* ACTION ROW */

.product-card .product-bottom,
.product-card .product-actions,
.product-card .product-price-row {
    display: flex !important;
    align-items: center !important;
}


/* CART BUTTON */

.product-card .cart-btn {
    width: 35px !important;
    min-width: 35px !important;
    max-width: 35px !important;

    height: 35px !important;
    min-height: 35px !important;
    max-height: 35px !important;

    flex: 0 0 35px !important;

    padding: 0 !important;
    margin: 0 !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    background: #003680 !important;
    color: #ffffff !important;

    border: none !important;
    border-radius: 4px !important;

    box-sizing: border-box !important;
}

/* ==========================================
   PRODUCT CARD BOTTOM - PRICE + ACTIONS FIX
========================================== */

.product-card .product-bottom,
.product-card .product-price-row {
    display: flex !important;
    align-items: center !important;
    width: 100% !important;
    min-width: 0 !important;
    gap: 5px !important;
}


/* PRICE AREA */

.product-card .product-price {
    flex: 1 1 auto !important;
    min-width: 0 !important;

    display: flex !important;
    align-items: center !important;
    gap: 5px !important;

    white-space: nowrap !important;
    overflow: hidden !important;
}


/* CURRENT PRICE */

.product-card .product-price strong,
.product-card .current-price {
    flex: 0 1 auto !important;
    min-width: 0 !important;

    white-space: nowrap !important;
}


/* OLD PRICE */

.product-card .old-price,
.product-card del,
.product-card .original-price {
    flex: 0 1 auto !important;

    white-space: nowrap !important;

    font-size: 8px !important;
}


/* CART BUTTON - NEVER SHRINK */

.product-card .cart-btn {
    flex: 0 0 35px !important;

    width: 35px !important;
    min-width: 35px !important;
    max-width: 35px !important;

    height: 35px !important;
    min-height: 35px !important;

    padding: 0 !important;
}


/* BUY NOW - NEVER SHRINK */

.product-card .buy-now-btn {
    flex: 0 0 68px !important;

    width: 68px !important;
    min-width: 68px !important;
    max-width: 68px !important;

    height: 35px !important;
    min-height: 35px !important;
    max-height: 35px !important;

    padding: 0 !important;
    margin: 0 !important;

    box-sizing: border-box !important;

    white-space: nowrap !important;
}


/* ==========================================
   SMALL CARD FIX
========================================== */

@media (max-width: 480px) {

    .product-card .product-bottom,
    .product-card .product-price-row {
        gap: 4px !important;
    }

    .product-card .cart-btn {
        flex-basis: 34px !important;
        width: 34px !important;
        min-width: 34px !important;
    }

    .product-card .buy-now-btn {
        flex-basis: 64px !important;
        width: 64px !important;
        min-width: 64px !important;
        max-width: 64px !important;
    }
}
</style>


<section class="products-page">

    <div class="products-container">


        <!-- PAGE HEADER -->

        <div class="products-page-header">

            <div>

                <span class="products-tag">
                    OUR STORE
                </span>

                <h1>
                    All <span>Products</span>
                </h1>

                <p>
                    Explore our latest collection of quality products.
                </p>

            </div>


            <div class="products-breadcrumb">

                <a href="{{ route('home') }}">
                    Home
                </a>

                <i class="fa-solid fa-angle-right"></i>

                <span>
                    Products
                </span>

            </div>

        </div>


        <!-- TOOLBAR -->

        <div class="products-toolbar">

            <div class="products-result">

                Showing

                <strong>
                    {{ $products->firstItem() ?? 0 }}
                    –
                    {{ $products->lastItem() ?? 0 }}
                </strong>

                of

                <strong>
                    {{ $products->total() }}
                </strong>

                products

            </div>


            <form
                method="GET"
                action="{{ route('products') }}"
                class="products-sort">

                @if(request('category'))

                <input
                    type="hidden"
                    name="category"
                    value="{{ request('category') }}">

                @endif


                @foreach((array) request('categories') as $category)

                <input
                    type="hidden"
                    name="categories[]"
                    value="{{ $category }}">

                @endforeach


                @if(request('min_price'))

                <input
                    type="hidden"
                    name="min_price"
                    value="{{ request('min_price') }}">

                @endif


                @if(request('max_price'))

                <input
                    type="hidden"
                    name="max_price"
                    value="{{ request('max_price') }}">

                @endif


                @if(request('rating'))

                <input
                    type="hidden"
                    name="rating"
                    value="{{ request('rating') }}">

                @endif


                <label for="sortProducts">
                    Sort By
                </label>


                <select
                    id="sortProducts"
                    name="sort"
                    onchange="this.form.submit()">

                    <option
                        value="latest"
                        {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>
                        Latest
                    </option>


                    <option
                        value="price-low"
                        {{ request('sort') == 'price-low' ? 'selected' : '' }}>
                        Price: Low to High
                    </option>


                    <option
                        value="price-high"
                        {{ request('sort') == 'price-high' ? 'selected' : '' }}>
                        Price: High to Low
                    </option>


                    <option
                        value="rating"
                        {{ request('sort') == 'rating' ? 'selected' : '' }}>
                        Top Rated
                    </option>

                </select>

            </form>

        </div>


        <!-- MAIN AREA -->

        <div class="products-main">


            <!-- SIDEBAR -->

            <aside class="products-sidebar">

                <div class="filter-header">

                    <h2>
                        Filters
                    </h2>


                    <a
                        href="{{ route('products') }}"
                        class="clear-filters">
                        Clear All
                    </a>

                </div>


                <!-- FILTER FORM -->

                <form
                    method="GET"
                    action="{{ route('products') }}"
                    id="filterForm">

                    @if(request('category'))

                    <input
                        type="hidden"
                        name="category"
                        value="{{ request('category') }}">

                    @endif


                    <!-- CATEGORY -->

                    <div class="filter-group">

                        <h3>
                            Categories
                        </h3>


                        @foreach($categories as $category)

                        <label class="filter-check">

                            <input
                                type="checkbox"
                                name="categories[]"
                                value="{{ $category->slug }}"
                                {{ in_array($category->slug, (array) request('categories')) ? 'checked' : '' }}>

                            <span>
                                {{ $category->name }}
                            </span>

                            <small>
                                ({{ $category->products_count }})
                            </small>

                        </label>

                        @endforeach

                    </div>


                    <!-- PRICE -->

                    <div class="filter-group">

                        <h3>
                            Price Range
                        </h3>


                        <div class="price-inputs">

                            <input
                                type="number"
                                name="min_price"
                                placeholder="Min"
                                value="{{ request('min_price') }}"
                                min="0">


                            <span>
                                —
                            </span>


                            <input
                                type="number"
                                name="max_price"
                                placeholder="Max"
                                value="{{ request('max_price') }}"
                                min="0">

                        </div>


                        <button
                            type="submit"
                            class="apply-filter">
                            Apply Filter
                        </button>

                    </div>


                    <!-- RATING -->

                    <div class="filter-group">

                        <h3>
                            Customer Rating
                        </h3>


                        <label class="filter-check">

                            <input
                                type="radio"
                                name="rating"
                                value="5"
                                {{ request('rating') == 5 ? 'checked' : '' }}>

                            <span class="filter-stars">
                                ★★★★★
                            </span>

                            <small>
                                & Up
                            </small>

                        </label>


                        <label class="filter-check">

                            <input
                                type="radio"
                                name="rating"
                                value="4"
                                {{ request('rating') == 4 ? 'checked' : '' }}>

                            <span class="filter-stars">
                                ★★★★
                            </span>

                            <small>
                                & Up
                            </small>

                        </label>


                        <label class="filter-check">

                            <input
                                type="radio"
                                name="rating"
                                value="3"
                                {{ request('rating') == 3 ? 'checked' : '' }}>

                            <span class="filter-stars">
                                ★★★
                            </span>

                            <small>
                                & Up
                            </small>

                        </label>

                    </div>


                    <button
                        type="submit"
                        class="apply-filter">
                        Apply Filters
                    </button>

                </form>

            </aside>


            <!-- PRODUCTS -->

            <div class="products-content">


                @if(request('category'))

                @php

                $selectedCategory =
                $categories->firstWhere(
                'slug',
                request('category')
                );

                @endphp


                @if($selectedCategory)

                <div class="active-filter">

                    Showing products from:

                    <strong>
                        {{ $selectedCategory->name }}
                    </strong>

                </div>

                @endif

                @endif


                @if($products->count())


                <div class="products-grid">


                    @foreach($products as $product)


                    @php

                    $isWishlisted =
                    in_array(
                    $product->id,
                    $wishlistProductIds
                    );

                    @endphp


                    <div class="shop-product-card">


                        <!-- IMAGE -->

                        <div class="shop-product-image">


                            <!-- BADGE -->

                            @if(
                            $product->sale_price &&
                            $product->price > $product->sale_price
                            )

                            @php

                            $discount = round(
                            (
                            ($product->price - $product->sale_price)
                            / $product->price
                            ) * 100
                            );

                            @endphp


                            <span class="shop-badge discount">
                                -{{ $discount }}%
                            </span>


                            @elseif($product->featured)


                            <span class="shop-badge">
                                FEATURED
                            </span>


                            @else


                            <span class="shop-badge">
                                NEW
                            </span>


                            @endif



                            <!-- WISHLIST -->

                            <form
                                action="{{ route('wishlist.add', $product->id) }}"
                                method="POST"
                                class="wishlist-form">

                                @csrf


                                <button
                                    type="submit"
                                    class="wishlist-btn {{ $isWishlisted ? 'wishlisted' : '' }}"
                                    title="{{ $isWishlisted ? 'Already in Wishlist' : 'Add to Wishlist' }}"
                                    data-product-id="{{ $product->id }}"
                                    {{ $isWishlisted ? 'disabled' : '' }}>


                                    <i
                                        class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>


                                </button>

                            </form>



                            <!-- PRODUCT IMAGE -->

                            @if($product->thumbnail)

                            <a
                                href="{{ route('product.show', $product->slug) }}"
                                class="shop-product-image-link">
                                <img
                                    src="{{ asset('assets/images/products/' . $product->thumbnail) }}"
                                    alt="{{ $product->name }}">
                            </a>

                            @else

                            <a
                                href="{{ route('product.show', $product->slug) }}"
                                class="shop-product-image-link">
                                <img
                                    src="{{ asset('assets/images/products/Watch.jpg') }}"
                                    alt="{{ $product->name }}">
                            </a>

                            @endif

                        </div>



                        <!-- INFO -->

                        <div class="shop-product-info">


                            <!-- CATEGORY -->

                            <span class="shop-category">

                                {{ $product->category->name ?? 'Uncategorized' }}

                            </span>


                            <!-- NAME -->

                            <h3>
                                {{ $product->name }}
                            </h3>


                            <!-- RATING -->

                            <div class="shop-rating">

                                @php

                                $averageRating =
                                $product->reviews_avg_rating
                                ?? $product->reviews->avg('rating')
                                ?? 0;

                                $reviewCount =
                                $product->reviews->count();

                                @endphp


                                <span>

                                    @for($i = 1; $i <= 5; $i++)

                                        @if($i <=round($averageRating))

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



                            <!-- PRICE + ACTIONS -->

                            <div class="shop-product-bottom">


                                <!-- PRICE -->

                                <div class="shop-price">


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



                                <!-- ACTIONS -->

                                <div class="shop-actions">


                                    <!-- ADD TO CART -->

                                    <button
                                        type="button"
                                        class="shop-cart add-to-cart-btn"
                                        data-product-id="{{ $product->id }}"
                                        data-cart-url="{{ route('cart.add', $product->id) }}"
                                        title="Add to Cart">

                                        <i class="fa-solid fa-cart-shopping"></i>

                                    </button>



                                    <!-- BUY NOW -->

                                    <a
                                        href="{{ route('product.show', $product->slug) }}"
                                        class="buy-now-btn">
                                        <i class="fa-solid fa-bolt"></i> 
                                    </a>


                                </div>

                            </div>

                        </div>

                    </div>

                    @endforeach


                </div>



                <!-- PAGINATION -->

                @if($products->hasPages())


                <div class="products-pagination">


                    @if($products->onFirstPage())


                    <span class="pagination-arrow disabled">

                        <i class="fa-solid fa-angle-left"></i>

                    </span>


                    @else


                    <a
                        href="{{ $products->previousPageUrl() }}"
                        class="pagination-arrow">

                        <i class="fa-solid fa-angle-left"></i>

                    </a>


                    @endif



                    @foreach(
                    $products->getUrlRange(
                    1,
                    $products->lastPage()
                    )
                    as $page => $url
                    )


                    @if(
                    $page ==
                    $products->currentPage()
                    )


                    <span class="pagination-number active">
                        {{ $page }}
                    </span>


                    @else


                    <a
                        href="{{ $url }}"
                        class="pagination-number">
                        {{ $page }}
                    </a>


                    @endif


                    @endforeach



                    @if($products->hasMorePages())


                    <a
                        href="{{ $products->nextPageUrl() }}"
                        class="pagination-arrow">

                        <i class="fa-solid fa-angle-right"></i>

                    </a>


                    @else


                    <span class="pagination-arrow disabled">

                        <i class="fa-solid fa-angle-right"></i>

                    </span>


                    @endif


                </div>


                @endif


                @else


                <div class="products-empty">

                    <i class="fa-solid fa-box-open"></i>

                    <h2>
                        No Products Found
                    </h2>

                    <p>
                        Try changing your filters.
                    </p>

                </div>


                @endif


            </div>

        </div>

    </div>

</section>



<!-- ========================================================= -->
<!-- AJAX TOAST -->
<!-- ========================================================= -->

<div
    id="nexaMartToast"
    class="nexamart-ajax-toast"
    aria-live="polite">

    <i
        id="nexaMartToastIcon"
        class="fa-solid fa-circle-check"></i>


    <span id="nexaMartToastMessage">
        Product successfully added!
    </span>

</div>



<script>
    document.addEventListener(
        'DOMContentLoaded',
        function() {


            /*
            |--------------------------------------------------------------------------
            | TOAST
            |--------------------------------------------------------------------------
            */

            const toast =
                document.getElementById(
                    'nexaMartToast'
                );


            const toastIcon =
                document.getElementById(
                    'nexaMartToastIcon'
                );


            const toastMessage =
                document.getElementById(
                    'nexaMartToastMessage'
                );


            let toastTimer = null;



            function showToast(
                message,
                type = 'success'
            ) {


                if (!toast) {
                    return;
                }


                clearTimeout(toastTimer);


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
                    function() {

                        toast.classList.add(
                            'show'
                        );

                    },
                    20
                );


                toastTimer =
                    setTimeout(
                        function() {

                            toast.classList.remove(
                                'show'
                            );

                        },
                        3000
                    );

            }



            /*
            |--------------------------------------------------------------------------
            | ADD TO CART
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll(
                    '.add-to-cart-btn'
                )
                .forEach(
                    function(button) {


                        button.addEventListener(
                            'click',
                            function() {


                                if (button.disabled) {
                                    return;
                                }


                                const productId =
                                    button.dataset.productId;


                                const cartUrl =
                                    button.dataset.cartUrl;


                                if (!productId || !cartUrl) {

                                    showToast(
                                        'Product could not be added to cart.',
                                        'error'
                                    );

                                    return;
                                }


                                button.disabled = true;


                                fetch(
                                        cartUrl, {

                                            method: 'POST',

                                            credentials: 'same-origin',

                                            headers: {

                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',

                                                'X-Requested-With': 'XMLHttpRequest',

                                                'Accept': 'application/json'

                                            }

                                        }
                                    )


                                    .then(
                                        function(response) {


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
                                        function(data) {


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
                                                | Update Header Cart Count
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
                                        function(error) {


                                            console.error(
                                                'Cart Error:',
                                                error
                                            );


                                            showToast(
                                                'Unable to add product to cart.',
                                                'error'
                                            );

                                        }
                                    )


                                    .finally(
                                        function() {

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
            | WISHLIST
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll(
                    '.wishlist-form'
                )
                .forEach(
                    function(form) {


                        form.addEventListener(
                            'submit',
                            function(event) {


                                event.preventDefault();


                                const button =
                                    form.querySelector(
                                        '.wishlist-btn'
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
                                        form.action, {

                                            method: 'POST',

                                            credentials: 'same-origin',

                                            headers: {

                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',

                                                'X-Requested-With': 'XMLHttpRequest',

                                                'Accept': 'application/json'

                                            },

                                            body: new FormData(form)

                                        }
                                    )


                                    .then(
                                        function(response) {


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
                                        function(data) {


                                            if (!data) {
                                                return;
                                            }


                                            if (data.success) {


                                                showToast(
                                                    data.message ||
                                                    'Product added to wishlist successfully!',
                                                    'success'
                                                );


                                                /*
                                                | Change Heart
                                                */

                                                const icon =
                                                    button.querySelector(
                                                        'i'
                                                    );


                                                if (icon) {

                                                    icon.classList.remove(
                                                        'fa-regular'
                                                    );


                                                    icon.classList.add(
                                                        'fa-solid'
                                                    );

                                                }


                                                button.classList.add(
                                                    'wishlisted'
                                                );


                                                button.title =
                                                    'Already in Wishlist';


                                                /*
                                                | Keep button disabled
                                                | because product is already added
                                                */

                                                button.disabled =
                                                    true;

                                            } else {


                                                showToast(
                                                    data.message ||
                                                    'Unable to update wishlist.',
                                                    'error'
                                                );


                                                button.disabled =
                                                    false;

                                            }

                                        }
                                    )


                                    .catch(
                                        function(error) {


                                            console.error(
                                                'Wishlist Error:',
                                                error
                                            );


                                            showToast(
                                                'Unable to update wishlist.',
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