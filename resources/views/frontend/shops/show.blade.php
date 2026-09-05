@extends('layouts.frontend')

@section('title', $shop->shop_name . ' - NexaMart')

@section('content')

<style>

/* =========================================================
   SHOP DETAIL - WISHLIST TOP RIGHT FIX
========================================================= */

.shop-product-image {
    position: relative !important;
}


/* =========================================================
   WISHLIST FORM
========================================================= */

.shop-product-image .shop-wishlist-form {
    position: absolute !important;

    top: 12px !important;
    right: 12px !important;

    bottom: auto !important;
    left: auto !important;

    width: 42px !important;
    height: 42px !important;

    margin: 0 !important;
    padding: 0 !important;

    display: block !important;

    z-index: 999 !important;

    transform: none !important;
}


/* =========================================================
   WISHLIST BUTTON
========================================================= */

.shop-product-image .shop-wishlist-form .shop-wishlist-btn {
    position: absolute !important;

    top: 0 !important;
    right: 0 !important;

    bottom: auto !important;
    left: auto !important;

    width: 42px !important;
    height: 42px !important;

    min-width: 42px !important;
    min-height: 42px !important;

    max-width: 42px !important;
    max-height: 42px !important;

    margin: 0 !important;
    padding: 0 !important;

    display: flex !important;

    align-items: center !important;
    justify-content: center !important;

    border-radius: 50% !important;

    box-sizing: border-box !important;

    text-decoration: none !important;

    line-height: 1 !important;

    transform: none !important;

    z-index: 1000 !important;
}


/* =========================================================
   LOGIN WISHLIST LINK
========================================================= */

.shop-product-image > .shop-wishlist-btn {
    position: absolute !important;

    top: 12px !important;
    right: 12px !important;

    bottom: auto !important;
    left: auto !important;

    width: 42px !important;
    height: 42px !important;

    min-width: 42px !important;
    min-height: 42px !important;

    max-width: 42px !important;
    max-height: 42px !important;

    margin: 0 !important;
    padding: 0 !important;

    display: flex !important;

    align-items: center !important;
    justify-content: center !important;

    border-radius: 50% !important;

    box-sizing: border-box !important;

    text-decoration: none !important;

    line-height: 1 !important;

    transform: none !important;

    z-index: 1000 !important;
}


/* =========================================================
   HEART ICON
========================================================= */

.shop-product-image .shop-wishlist-btn i {
    display: block !important;

    margin: 0 !important;
    padding: 0 !important;

    line-height: 1 !important;

    text-decoration: none !important;
}


/* =========================================================
   REMOVE UNDERLINE
========================================================= */

.shop-product-image .shop-wishlist-btn,
.shop-product-image .shop-wishlist-btn:hover,
.shop-product-image .shop-wishlist-btn:focus,
.shop-product-image .shop-wishlist-btn:active {
    text-decoration: none !important;
}


/* =========================================================
   PRODUCT IMAGE
========================================================= */

.shop-product-image-link {
    display: block !important;

    width: 100%;

    height: 100%;
}


.shop-product-image-link img {
    display: block !important;

    width: 100%;

    height: 100%;

    object-fit: contain;
}

</style>


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
     SHOP HERO
========================================================= -->

<section class="shop-detail-hero">

    <div class="shop-detail-back">

        <a href="{{ route('shops') }}">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Shops

        </a>

    </div>


    <div class="shop-detail-container">


        <div class="shop-detail-logo">

            @if($shop->shop_logo)

                <img
                    src="{{ asset('storage/' . $shop->shop_logo) }}"
                    alt="{{ $shop->shop_name }}"
                >

            @else

                <div class="shop-detail-logo-placeholder">

                    {{ strtoupper(substr($shop->shop_name, 0, 1)) }}

                </div>

            @endif

        </div>


        <div class="shop-detail-info">

            <span class="shop-detail-tag">

                VERIFIED SHOP

            </span>


            <h1>

                {{ $shop->shop_name }}

            </h1>


            <p>

                @if($shop->shop_description)

                    {{ $shop->shop_description }}

                @else

                    Discover quality products from
                    {{ $shop->shop_name }} on NexaMart.

                @endif

            </p>


            <div class="shop-detail-meta">

                @if($shop->city || $shop->state)

                    <span>

                        <i class="fa-solid fa-location-dot"></i>

                        {{ $shop->city }}

                        @if($shop->city && $shop->state)

                            ,

                        @endif

                        {{ $shop->state }}

                    </span>

                @endif


                @if($shop->pincode)

                    <span>

                        <i class="fa-solid fa-map-pin"></i>

                        {{ $shop->pincode }}

                    </span>

                @endif


                <span>

                    <i class="fa-solid fa-box-open"></i>

                    {{ $products->count() }}

                    {{ $products->count() == 1 ? 'Product' : 'Products' }}

                </span>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     SHOP CONTENT
========================================================= -->

<section class="shop-detail-section">

    <div class="shop-detail-content">


        <!-- =====================================================
             SHOP CATEGORIES
        ====================================================== -->

        @if($shopCategories->count())

            <div class="shop-categories-box">

                <div class="shop-section-heading">

                    <div>

                        <span>

                            SHOP CATEGORIES

                        </span>


                        <h2>

                            Explore

                            <strong>
                                {{ $shop->shop_name }}
                            </strong>

                        </h2>

                    </div>

                </div>


                <div class="shop-category-list">

                    <button
                        type="button"
                        class="shop-category-btn active"
                        data-category="all"
                    >

                        All Products

                    </button>


                    @foreach($shopCategories as $category)

                        <button
                            type="button"
                            class="shop-category-btn"
                            data-category="{{ $category->id }}"
                        >

                            {{ $category->name }}

                        </button>

                    @endforeach

                </div>

            </div>

        @endif


        <!-- =====================================================
             PRODUCTS HEADING
        ====================================================== -->

        <div class="shop-products-heading">

            <div>

                <span>

                    SHOP PRODUCTS

                </span>


                <h2>

                    Products from

                    <strong>
                        {{ $shop->shop_name }}
                    </strong>

                </h2>

            </div>


            <span class="shop-product-count">

                {{ $products->count() }}

                {{ $products->count() == 1 ? 'Product' : 'Products' }}

            </span>

        </div>


        <!-- =====================================================
             PRODUCTS
        ====================================================== -->

        @if($products->count())

            <div
                class="shop-products-grid"
                id="shopProductsGrid"
            >

                @foreach($products as $product)

                    @php

                        $sellingPrice =
                            $product->sale_price &&
                            $product->price > $product->sale_price
                            ? $product->sale_price
                            : $product->price;


                        $discount = 0;


                        if (
                            $product->sale_price &&
                            $product->price > $product->sale_price
                        ) {

                            $discount = round(

                                (
                                    ($product->price - $product->sale_price)
                                    / $product->price
                                ) * 100

                            );

                        }


                        $isWishlisted = false;


                        if (auth('customer')->check()) {

                            $isWishlisted = auth('customer')
                                ->user()
                                ->wishlists()
                                ->where(
                                    'product_id',
                                    $product->id
                                )
                                ->exists();

                        }

                    @endphp


                    <article
                        class="shop-product-card"
                        data-category="{{ $product->category_id }}"
                    >


                        <!-- =================================================
                             IMAGE
                        ================================================== -->

                        <div class="shop-product-image">


                            <!-- BADGE -->

                            @if($discount > 0)

                                <span class="shop-product-badge discount">

                                    -{{ $discount }}%

                                </span>

                            @elseif(
                                $product->created_at &&
                                $product->created_at->gt(now()->subDays(7))
                            )

                                <span class="shop-product-badge">

                                    NEW

                                </span>

                            @endif


                            <!-- WISHLIST -->

                            @auth('customer')

                                <form
                                    action="{{
                                        $isWishlisted
                                        ? route('wishlist.remove', $product->id)
                                        : route('wishlist.add', $product->id)
                                    }}"
                                    method="POST"
                                    class="shop-wishlist-form"
                                >

                                    @csrf


                                    @if($isWishlisted)

                                        @method('DELETE')

                                    @endif


                                    <button
                                        type="submit"
                                        class="shop-wishlist-btn {{ $isWishlisted ? 'active' : '' }}"
                                        title="{{
                                            $isWishlisted
                                            ? 'Remove from Wishlist'
                                            : 'Add to Wishlist'
                                        }}"
                                    >

                                        <i class="{{
                                            $isWishlisted
                                            ? 'fa-solid fa-heart'
                                            : 'fa-regular fa-heart'
                                        }}"></i>

                                    </button>

                                </form>

                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="shop-wishlist-btn"
                                    title="Login to add Wishlist"
                                >

                                    <i class="fa-regular fa-heart"></i>

                                </a>

                            @endauth


                            <!-- PRODUCT IMAGE -->

                            <a
                                href="{{ route('products') }}"
                                class="shop-product-image-link"
                            >

                                @if($product->thumbnail)

                                    <img
                                        src="{{ asset('assets/images/products/' . $product->thumbnail) }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                    >

                                @else

                                    <img
                                        src="{{ asset('assets/images/logo/banner.png') }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                    >

                                @endif

                            </a>

                        </div>


                        <!-- =================================================
                             PRODUCT INFO
                        ================================================== -->

                        <div class="shop-product-info">


                            @if($product->category)

                                <span class="shop-product-category">

                                    {{ $product->category->name }}

                                </span>

                            @endif


                            <a
                                href="{{ route('products') }}"
                                class="shop-product-name-link"
                            >

                                <h3>

                                    {{ $product->name }}

                                </h3>

                            </a>


                            @if($product->brand)

                                <small class="shop-product-brand">

                                    {{ $product->brand->name }}

                                </small>

                            @endif


                            <!-- RATING -->

                            <div class="shop-product-rating">

                                <span class="shop-stars">

                                    ★★★★★

                                </span>

                                <small>

                                    ({{ $product->reviews_count ?? 0 }})

                                </small>

                            </div>


                            <!-- PRICE -->

                            <div class="shop-product-price">

                                <strong>

                                    ₹{{ number_format($sellingPrice, 2) }}

                                </strong>


                                @if(
                                    $product->sale_price &&
                                    $product->price > $product->sale_price
                                )

                                    <del>

                                        ₹{{ number_format($product->price, 2) }}

                                    </del>

                                @endif

                            </div>


                            <!-- ACTIONS -->

                            <div class="shop-product-actions">


                                @auth('customer')


                                    <!-- ADD TO CART -->

                                    <form
                                        action="{{ route('cart.add', $product->id) }}"
                                        method="POST"
                                        class="shop-cart-form"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="shop-add-cart-btn"
                                            title="Add to Cart"
                                        >

                                            <i class="fa-solid fa-cart-shopping"></i>

                                            <span>

                                                Add to Cart

                                            </span>

                                        </button>

                                    </form>


                                    <!-- BUY NOW -->

                                    <form
                                        action="{{ route('buy.now', $product->id) }}"
                                        method="POST"
                                        class="shop-buy-form"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="shop-buy-btn"
                                        >

                                            Buy Now

                                        </button>

                                    </form>


                                @else


                                    <a
                                        href="{{ route('login') }}"
                                        class="shop-add-cart-btn"
                                        title="Login to Add to Cart"
                                    >

                                        <i class="fa-solid fa-cart-shopping"></i>

                                        <span>

                                            Add to Cart

                                        </span>

                                    </a>


                                    <a
                                        href="{{ route('login') }}"
                                        class="shop-buy-btn"
                                    >

                                        Buy Now

                                    </a>


                                @endauth


                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


            <!-- =====================================================
                 NO CATEGORY PRODUCTS
            ====================================================== -->

            <div
                class="shop-no-category-products"
                id="shopNoCategoryProducts"
            >

                <i class="fa-solid fa-box-open"></i>

                <h3>

                    No products found

                </h3>

                <p>

                    This shop doesn't have products in this category.

                </p>

            </div>


        @else


            <div class="shop-empty">

                <i class="fa-solid fa-box-open"></i>

                <h3>

                    No Products Available

                </h3>

                <p>

                    This shop has not added any products yet.

                </p>

            </div>


        @endif


    </div>

</section>


<!-- =========================================================
     SHOP DETAIL JAVASCRIPT
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | CATEGORY FILTER
    |--------------------------------------------------------------------------
    */

    const categoryButtons =
        document.querySelectorAll('.shop-category-btn');


    const productCards =
        document.querySelectorAll('.shop-product-card');


    const noProducts =
        document.querySelector('#shopNoCategoryProducts');


    categoryButtons.forEach(function (button) {

        button.addEventListener('click', function () {


            categoryButtons.forEach(function (btn) {

                btn.classList.remove('active');

            });


            button.classList.add('active');


            const selectedCategory =
                button.dataset.category;


            let visibleProducts = 0;


            productCards.forEach(function (card) {

                const productCategory =
                    card.dataset.category;


                if (
                    selectedCategory === 'all' ||
                    productCategory === selectedCategory
                ) {

                    card.style.display = '';

                    visibleProducts++;

                } else {

                    card.style.display = 'none';

                }

            });


            if (noProducts) {

                if (visibleProducts === 0) {

                    noProducts.style.display = 'flex';

                } else {

                    noProducts.style.display = 'none';

                }

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | ADD TO CART - AJAX
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.shop-cart-form').forEach(function (form) {

        form.addEventListener('submit', async function (event) {

            event.preventDefault();


            const button =
                form.querySelector('button[type="submit"]');


            if (!button) {

                return;

            }


            if (button.dataset.loading === 'true') {

                return;

            }


            const originalHTML =
                button.innerHTML;


            button.dataset.loading = 'true';

            button.disabled = true;


            try {

                const response = await fetch(

                    form.action,

                    {

                        method: 'POST',

                        headers: {

                            'X-CSRF-TOKEN': document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                .getAttribute('content'),

                            'Accept': 'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'

                        },

                        body: new FormData(form)

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


                /*
                | Success button
                */

                button.innerHTML =
                    '<i class="fa-solid fa-check"></i> Added';


                button.classList.add(
                    'cart-added'
                );


                /*
                | Cart count update
                */

                if (
                    data.cart_count !== undefined
                ) {

                    const cartCount =
                        document.querySelector(
                            '[data-cart-count]'
                        );


                    if (cartCount) {

                        cartCount.textContent =
                            data.cart_count;

                    }

                }


                /*
                | Toast
                */

                showShopToast(

                    data.message ||
                    'Product added to cart successfully.',

                    'success'

                );


                /*
                | Restore button
                */

                setTimeout(function () {

                    button.innerHTML =
                        originalHTML;


                    button.classList.remove(
                        'cart-added'
                    );


                    button.disabled = false;


                    button.dataset.loading =
                        'false';

                }, 1200);


            } catch (error) {


                console.error(

                    'Shop Add To Cart Error:',

                    error

                );


                showShopToast(

                    error.message ||
                    'Something went wrong.',

                    'error'

                );


                button.innerHTML =
                    originalHTML;


                button.disabled = false;


                button.dataset.loading =
                    'false';

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | WISHLIST - AJAX
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.shop-wishlist-form'
    ).forEach(function (form) {


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
                    button.dataset.loading === 'true'
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


                    const formData =
                        new FormData(form);


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

                                body: formData

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


                    /*
                    | REMOVE FROM WISHLIST
                    */

                    if (isRemove) {


                        button.classList.remove(
                            'active'
                        );


                        button.innerHTML =
                            '<i class="fa-regular fa-heart"></i>';


                        button.title =
                            'Add to Wishlist';


                        /*
                        | Change remove URL to add URL
                        */

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


                        showShopToast(

                            data.message ||
                            'Removed from wishlist.',

                            'success'

                        );


                    }


                    /*
                    | ADD TO WISHLIST
                    */

                    else {


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


                        /*
                        | Change add URL to remove URL
                        */

                        form.action =
                            form.action.replace(

                                '/wishlist/add/',

                                '/wishlist/remove/'

                            );


                        showShopToast(

                            data.message ||
                            'Added to wishlist.',

                            'success'

                        );

                    }


                    button.disabled =
                        false;


                    button.dataset.loading =
                        'false';


                } catch (error) {


                    console.error(

                        'Shop Wishlist Error:',

                        error

                    );


                    showShopToast(

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

    });


    /*
    |--------------------------------------------------------------------------
    | SHOP TOAST
    |--------------------------------------------------------------------------
    */

    function showShopToast(message, type = 'success') {


        /*
        | Remove old toast
        */

        const oldToast =
            document.querySelector(
                '.shop-ajax-toast'
            );


        if (oldToast) {

            oldToast.remove();

        }


        /*
        | Create toast
        */

        const toast =
            document.createElement('div');


        toast.className =
            'shop-ajax-toast ' +
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


        /*
        | Show
        */

        requestAnimationFrame(function () {

            toast.classList.add(
                'show'
            );

        });


        /*
        | Hide
        */

        setTimeout(function () {

            toast.classList.remove(
                'show'
            );


            setTimeout(function () {

                toast.remove();

            }, 350);

        }, 2500);

    }


});

</script>


@endsection