@extends('layouts.frontend')

@section('title', 'NexaMart - Online Shopping')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

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
     HOME HERO / BANNER SLIDER
========================================================= -->

@if($banners->count())

<section class="home-hero">

    <div class="home-banner-slider">

        @foreach($banners as $index => $banner)

        <div
            class="home-banner-slide {{ $index === 0 ? 'active' : '' }}"
            data-slide="{{ $index }}">

            <img
                src="{{ asset('assets/images/banners/' . $banner->image) }}"
                alt="{{ $banner->title }}">

        </div>

        @endforeach

    </div>


    @if($banners->count() > 1)

    <!-- Previous -->
    <button
        type="button"
        class="home-banner-arrow home-banner-prev"
        aria-label="Previous Banner">
        <i class="fa-solid fa-chevron-left"></i>
    </button>


    <!-- Next -->
    <button
        type="button"
        class="home-banner-arrow home-banner-next"
        aria-label="Next Banner">
        <i class="fa-solid fa-chevron-right"></i>
    </button>


    <!-- Dots -->
    <div class="home-banner-dots">

        @foreach($banners as $index => $banner)

        <button
            type="button"
            class="home-banner-dot {{ $index === 0 ? 'active' : '' }}"
            data-slide="{{ $index }}"
            aria-label="Go to banner {{ $index + 1 }}"></button>

        @endforeach

    </div>

    @endif

</section>

@else

<!-- =====================================================
         FALLBACK HERO
    ====================================================== -->

<section class="home-hero home-hero-fallback">

    <div class="home-hero-inner">

        <div class="home-hero-content">

            <span class="hero-tag">
                NEXAMART SPECIAL
            </span>

            <h1>
                Shop Smart.
                <br>
                <span>Live Better.</span>
            </h1>

            <p>
                Discover amazing products, exciting offers
                and trusted brands at the best prices.
            </p>

            <div class="hero-actions">

                <a
                    href="{{ route('products') }}"
                    class="hero-btn hero-btn-primary">
                    Shop Now
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <a
                    href="{{ route('categories') }}"
                    class="hero-btn hero-btn-outline">
                    Explore Categories
                </a>

            </div>

        </div>

        <div class="home-hero-image">

            <img
                src="{{ asset('assets/images/logo/banner.png') }}"
                alt="NexaMart Shopping">

        </div>

    </div>

</section>

@endif


<!-- =========================================================
     FEATURES
========================================================= -->

<section class="features-section">

    <div class="container">

        <div class="features-grid">

            <div class="feature-card">

                <div class="feature-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>

                <div>
                    <h3>Fast Delivery</h3>

                    <p>
                        Quick and reliable delivery
                        at your doorstep.
                    </p>
                </div>

            </div>


            <div class="feature-card">

                <div class="feature-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <div>
                    <h3>Secure Payment</h3>

                    <p>
                        Safe and secure payment
                        methods.
                    </p>
                </div>

            </div>


            <div class="feature-card">

                <div class="feature-icon">
                    <i class="fa-solid fa-rotate-left"></i>
                </div>

                <div>
                    <h3>Easy Returns</h3>

                    <p>
                        Simple and hassle-free
                        returns.
                    </p>
                </div>

            </div>


            <div class="feature-card">

                <div class="feature-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>

                <div>
                    <h3>24/7 Support</h3>

                    <p>
                        We're always here
                        to help you.
                    </p>
                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     FEATURED PRODUCTS
========================================================= -->

<section class="products-section">

    <div class="products-container">

        <div class="section-heading">

            <div>

                <span class="section-tag">
                    OUR COLLECTION
                </span>

                <h2>
                    Featured <span>Products</span>
                </h2>

                <p>
                    Discover our most popular products selected
                    specially for you.
                </p>

            </div>

            <a
                href="{{ route('products') }}"
                class="view-all-btn">
                View All
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>


        <div class="products-grid">

            @forelse($featuredProducts as $product)

            @php
            $isWishlisted = $wishlistProductIds->contains($product->id);

            $sellingPrice = $product->sale_price &&
            $product->price > $product->sale_price
            ? $product->sale_price
            : $product->price;
            @endphp

            <div class="product-card">

                <div class="product-image">

                    @if(
                    $product->sale_price &&
                    $product->price > $product->sale_price
                    )

                    <span class="product-badge">
                        SALE
                    </span>

                    @elseif(
                    $product->created_at &&
                    $product->created_at->gt(now()->subDays(7))
                    )

                    <span class="product-badge">
                        NEW
                    </span>

                    @endif


                    {{-- WISHLIST --}}

                    @auth('customer')

                    @if($isWishlisted)

                    <form
                        action="{{ route('wishlist.remove', $product->id) }}"
                        method="POST"
                        class="home-wishlist-form">

                        @csrf
                        @method('DELETE')

                        <button
                            class="wishlist-btn active"
                            type="submit"
                            title="Remove from Wishlist">
                            <i class="fa-solid fa-heart"></i>
                        </button>

                    </form>

                    @else

                    <form
                        action="{{ route('wishlist.add', $product->id) }}"
                        method="POST"
                        class="home-wishlist-form">

                        @csrf

                        <button
                            class="wishlist-btn"
                            type="submit"
                            title="Add to Wishlist">
                            <i class="fa-regular fa-heart"></i>
                        </button>

                    </form>

                    @endif

                    @else

                    <a
                        href="{{ route('login') }}"
                        class="wishlist-btn"
                        title="Login to add Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </a>

                    @endauth


                    {{-- PRODUCT IMAGE --}}

                    <a href="{{ route('product.show', $product->slug) }}" class="product-image-link">

                        @if($product->thumbnail)

                        <img
                            src="{{ asset('assets/images/products/' . $product->thumbnail) }}"
                            alt="{{ $product->name }}">

                        @else

                        <img
                            src="{{ asset('assets/images/logo/banner.png') }}"
                            alt="{{ $product->name }}">

                        @endif

                    </a>

                </div>


                <div class="product-info">

                    <span class="product-category">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </span>


                    <h3>
                        {{ $product->name }}
                    </h3>


                    @if($product->brand)

                    <small class="product-brand">
                        {{ $product->brand->name }}
                    </small>

                    @endif


                    <div class="product-rating">

                        <span class="stars">
                            ★★★★★
                        </span>

                        <span class="rating-count">
                            ({{ $product->reviews_count ?? 0 }})
                        </span>

                    </div>


                    <div class="product-bottom">

                        <div class="product-price">

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


                        <div class="product-actions">

                            {{-- ADD TO CART --}}

                            @auth('customer')

                            <form
                                action="{{ route('cart.add', $product->id) }}"
                                method="POST"
                                class="home-cart-form">

                                @csrf

                                <button
                                    class="add-cart-btn"
                                    type="submit"
                                    title="Add to Cart">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </button>

                            </form>

                            @else

                            <a
                                href="{{ route('login') }}"
                                class="add-cart-btn"
                                title="Login to Add to Cart">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>

                            @endauth


                            {{-- BUY NOW --}}

                            @auth('customer')

                            <a
                                href="{{ route('product.show', $product->slug) }}"
                                class="buy-now-btn">
                                Buy Now
                            </a>

                            @else

                            <a
                                href="{{ route('login') }}"
                                class="buy-now-btn">
                                Buy Now
                            </a>

                            @endauth

                        </div>

                    </div>

                </div>

            </div>

            @empty

            <div class="no-products">

                <p>
                    No featured products available.
                </p>

            </div>

            @endforelse

        </div>

    </div>

</section>


<!-- =========================================================
     OFFER BANNER
========================================================= -->

<section class="offer-section">

    <div class="offer-banner">

        <div class="offer-content">

            <span class="offer-small-text">
                LIMITED TIME OFFER
            </span>

            <h2>
                Get Up To
                <span>50% OFF</span>
            </h2>

            <p>
                Grab amazing deals on your favourite products
                before the offer ends.
            </p>

            <a
                href="{{ route('offers') }}"
                class="offer-btn">
                Shop Offers
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>


        <div class="offer-highlight">

            <div class="offer-circle">

                <strong>50%</strong>

                <span>OFF</span>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     LATEST PRODUCTS
========================================================= -->

<section class="latest-products-section">

    <div class="latest-products-container">

        <div class="latest-products-heading">

            <div>

                <span class="latest-products-tag">
                    JUST ARRIVED
                </span>

                <h2>
                    Latest <span>Products</span>
                </h2>

                <p>
                    Check out the newest products added to NexaMart.
                </p>

            </div>

            <a
                href="{{ route('products') }}"
                class="latest-view-all">
                View All
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>


        <div class="latest-products-grid">

            @forelse($latestProducts as $product)

            @php
            $isWishlisted = $wishlistProductIds->contains($product->id);

            $sellingPrice = $product->sale_price &&
            $product->price > $product->sale_price
            ? $product->sale_price
            : $product->price;
            @endphp

            <div class="latest-product-card">

                <div class="latest-product-image">

                    @if(
                    $product->sale_price &&
                    $product->price > $product->sale_price
                    )

                    @php
                    $discount = round(
                    (($product->price - $product->sale_price)
                    / $product->price) * 100
                    );
                    @endphp

                    <span class="latest-product-badge discount">
                        -{{ $discount }}%
                    </span>

                    @elseif(
                    $product->created_at &&
                    $product->created_at->gt(now()->subDays(7))
                    )

                    <span class="latest-product-badge">
                        NEW
                    </span>

                    @endif


                    {{-- WISHLIST --}}

                    @auth('customer')

                    @if($isWishlisted)

                    <form
                        action="{{ route('wishlist.remove', $product->id) }}"
                        method="POST"
                        class="home-wishlist-form">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="latest-wishlist active"
                            title="Remove from Wishlist">
                            <i class="fa-solid fa-heart"></i>
                        </button>

                    </form>

                    @else

                    <form
                        action="{{ route('wishlist.add', $product->id) }}"
                        method="POST"
                        class="home-wishlist-form">

                        @csrf

                        <button
                            type="submit"
                            class="latest-wishlist"
                            title="Add to Wishlist">
                            <i class="fa-regular fa-heart"></i>
                        </button>

                    </form>

                    @endif

                    @else

                    <a
                        href="{{ route('login') }}"
                        class="latest-wishlist"
                        title="Login to add Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </a>

                    @endauth

                    {{-- PRODUCT IMAGE --}}

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
                            src="{{ asset('assets/images/logo/banner.png') }}"
                            alt="{{ $product->name }}">
                    </a>

                    @endif

                </div>


                <div class="latest-product-info">

                    <span class="latest-category">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </span>


                    <h3>
                        {{ $product->name }}
                    </h3>


                    @if($product->brand)

                    <small class="product-brand">
                        {{ $product->brand->name }}
                    </small>

                    @endif


                    <div class="latest-rating">

                        <span>
                            ★★★★★
                        </span>

                        <small>
                            ({{ $product->reviews_count ?? 0 }})
                        </small>

                    </div>


                    <div class="latest-product-footer">

                        <div class="latest-price">

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


                        <div class="latest-actions">

                            {{-- CART --}}

                            @auth('customer')

                            <form
                                action="{{ route('cart.add', $product->id) }}"
                                method="POST">

                                @csrf

                                <button
                                    type="submit"
                                    class="latest-cart-btn"
                                    title="Add to Cart">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </button>

                            </form>

                            @else

                            <a
                                href="{{ route('login') }}"
                                class="latest-cart-btn"
                                title="Login to Add to Cart">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>

                            @endauth


                            {{-- BUY NOW --}}

                            @auth('customer')
                            <a
                                href="{{ route('product.show', $product->slug) }}"
                                class="buy-now-btn">
                                Buy Now
                            </a>

                            @else

                            <a
                                href="{{ route('login') }}"
                                class="buy-now-btn">
                                Buy Now
                            </a>

                            @endauth

                        </div>

                    </div>

                </div>

            </div>

            @empty

            <div class="no-products">

                <p>
                    No products available.
                </p>

            </div>

            @endforelse

        </div>

    </div>

</section>


<!-- =========================================================
     BRANDS
========================================================= -->

<section class="brands-section">

    <div class="brands-container">

        <div class="brands-heading">

            <span class="brands-tag">
                TOP BRANDS
            </span>

            <h2>
                Shop By <span>Brands</span>
            </h2>

            <p>
                Discover products from trusted and popular brands.
            </p>

        </div>


        <div class="brands-grid">

            @forelse($brands as $brand)

            <a
                href="{{ route('products', ['brand' => $brand->slug]) }}"
                class="brand-card">

                <div class="brand-logo">

                    @if($brand->logo)

                    <img
                        src="{{ asset('assets/images/brand/' . $brand->logo) }}"
                        alt="{{ $brand->name }}">

                    @else

                    <div class="brand-image-placeholder">
                        <i class="fa-solid fa-image"></i>
                    </div>

                    @endif
                </div>

                <h3>
                    {{ $brand->name }}
                </h3>

            </a>

            @empty

            <p>
                No brands available.
            </p>

            @endforelse

        </div>

    </div>

</section>


<!-- =========================================================
     NEWSLETTER
========================================================= -->

<section class="newsletter-section">

    <div class="newsletter-container">

        <div class="newsletter-content">

            <span class="newsletter-tag">
                STAY UPDATED
            </span>

            <h2>
                Get The Latest
                <span>Deals & Offers</span>
            </h2>

            <p>
                Subscribe to our newsletter and be the first to know
                about new products, special offers and exclusive deals.
            </p>


            <form
                class="newsletter-form"
                action="{{ route('newsletter.subscribe') }}"
                method="POST"
                id="newsletterForm">
                @csrf

                <div class="newsletter-input">

                    <i class="fa-regular fa-envelope"></i>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email address"
                        required>

                </div>

                <button type="submit">
                    Subscribe
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>


            <small>
                We respect your privacy. Unsubscribe at any time.
            </small>

        </div>


        <div class="newsletter-icon">

            <div class="newsletter-circle">

                <i class="fa-regular fa-envelope"></i>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     ALERT AUTO HIDE
========================================================= -->

<script>
    setTimeout(function() {

        document.querySelectorAll(
            '.auth-alert, .home-alert'
        ).forEach(function(alert) {

            alert.style.transition = '0.4s ease';

            alert.style.opacity = '0';

            alert.style.transform = 'translateX(40px)';

            setTimeout(function() {
                alert.remove();
            }, 400);

        });

    }, 4000);
    /*
<script>

    /*
    |--------------------------------------------------------------------------
    | NEWSLETTER TOAST
    |--------------------------------------------------------------------------
    */

    function showNewsletterToast(message, type) {

        const oldToast = document.querySelector(
            '.home-ajax-toast'
        );

        if (oldToast) {
            oldToast.remove();
        }

        const toast = document.createElement('div');

        toast.className =
            'home-ajax-toast ' +
            (
                type === 'success' ?
                'success' :
                'error'
            );

        toast.innerHTML = `

            <i class="${
                type === 'success'
                    ? 'fa-solid fa-circle-check'
                    : 'fa-solid fa-circle-exclamation'
            }"></i>

            <span>${message}</span>

        `;

        document.body.appendChild(toast);

        requestAnimationFrame(function() {

            toast.classList.add('show');

        });

        setTimeout(function() {

            toast.classList.remove('show');

            setTimeout(function() {

                toast.remove();

            }, 350);

        }, 2500);

    }


    /*
    |--------------------------------------------------------------------------
    | NEWSLETTER - AJAX
    |--------------------------------------------------------------------------
    */

    const newsletterForm =
        document.querySelector('#newsletterForm');

    if (newsletterForm) {

        newsletterForm.addEventListener(
            'submit',
            async function(event) {

                event.preventDefault();

                const button =
                    newsletterForm.querySelector(
                        'button[type="submit"]'
                    );

                const input =
                    newsletterForm.querySelector(
                        'input[name="email"]'
                    );

                if (!button || !input) {
                    return;
                }

                const originalHTML =
                    button.innerHTML;

                if (button.dataset.loading === 'true') {
                    return;
                }

                button.dataset.loading = 'true';
                button.disabled = true;

                try {

                    const csrfToken =
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        );

                    if (!csrfToken) {

                        throw new Error(
                            'CSRF token not found.'
                        );

                    }

                    const response = await fetch(
                        newsletterForm.action, {
                            method: 'POST',

                            headers: {

                                'X-CSRF-TOKEN': csrfToken.getAttribute(
                                    'content'
                                ),

                                'Accept': 'application/json',

                                'X-Requested-With': 'XMLHttpRequest'
                            },

                            body: new FormData(
                                newsletterForm
                            )
                        }
                    );


                    const data =
                        await response.json();


                    /*
                    |--------------------------------------------------------------------------
                    | ERROR RESPONSE
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !response.ok ||
                        !data.success
                    ) {

                        throw new Error(
                            data.message ||
                            'Unable to subscribe.'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SUCCESS
                    |--------------------------------------------------------------------------
                    */

                    showNewsletterToast(
                        data.message,
                        'success'
                    );


                    input.value = '';


                    button.innerHTML =
                        '<i class="fa-solid fa-check"></i> Subscribed';


                    setTimeout(function() {

                        button.innerHTML =
                            originalHTML;

                        button.disabled =
                            false;

                        button.dataset.loading =
                            'false';

                    }, 1500);


                } catch (error) {

                    console.error(
                        'Newsletter Error:',
                        error
                    );


                    showNewsletterToast(
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
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        /*
        |--------------------------------------------------------------------------
        | HOME ADD TO CART - AJAX
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll('.home-cart-form, .latest-actions form').forEach(function(form) {

            /*
            | Only process forms which are actually cart forms.
            */

            if (!form.action.includes('/cart/add/')) {
                return;
            }


            form.addEventListener('submit', async function(event) {

                event.preventDefault();


                const button = form.querySelector(
                    'button[type="submit"]'
                );


                if (!button) {
                    return;
                }


                const originalHTML = button.innerHTML;


                /*
                | Prevent double click
                */

                if (button.dataset.loading === 'true') {
                    return;
                }


                button.dataset.loading = 'true';

                button.disabled = true;


                try {

                    const response = await fetch(
                        form.action, {
                            method: 'POST',

                            headers: {
                                'X-CSRF-TOKEN': document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),

                                'Accept': 'application/json',

                                'X-Requested-With': 'XMLHttpRequest'
                            },

                            body: new FormData(form)
                        }
                    );


                    const data = await response.json();


                    if (!response.ok || !data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to add product to cart.'
                        );
                    }


                    /*
                    | Success icon
                    */

                    button.innerHTML =
                        '<i class="fa-solid fa-check"></i>';


                    /*
                    | Small success effect
                    */

                    button.classList.add('cart-added');


                    /*
                    | Optional cart count update
                    */

                    if (
                        data.cart_count !== undefined &&
                        document.querySelector('[data-cart-count]')
                    ) {

                        document.querySelector(
                            '[data-cart-count]'
                        ).textContent = data.cart_count;
                    }


                    /*
                    | Show notification
                    */

                    showHomeToast(
                        data.message,
                        'success'
                    );


                    /*
                    | Restore button
                    */

                    setTimeout(function() {

                        button.innerHTML = originalHTML;

                        button.classList.remove(
                            'cart-added'
                        );

                        button.disabled = false;

                        button.dataset.loading = 'false';

                    }, 1200);


                } catch (error) {

                    console.error(
                        'Add To Cart Error:',
                        error
                    );


                    showHomeToast(
                        error.message ||
                        'Something went wrong.',
                        'error'
                    );


                    button.innerHTML = originalHTML;

                    button.disabled = false;

                    button.dataset.loading = 'false';
                }

            });

        });



        /*
        |--------------------------------------------------------------------------
        | WISHLIST - AJAX
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll(
            '.home-wishlist-form'
        ).forEach(function(form) {

            form.addEventListener(
                'submit',
                async function(event) {

                    event.preventDefault();


                    const button = form.querySelector(
                        'button[type="submit"]'
                    );


                    if (!button) {
                        return;
                    }


                    /*
                    | Prevent double click
                    */

                    if (button.dataset.loading === 'true') {
                        return;
                    }


                    button.dataset.loading = 'true';

                    button.disabled = true;


                    const originalHTML =
                        button.innerHTML;


                    const isRemove =
                        form.querySelector(
                            'input[name="_method"]'
                        )?.value === 'DELETE';


                    try {

                        const formData =
                            new FormData(form);


                        /*
                        | Laravel method spoofing
                        */

                        const response =
                            await fetch(
                                form.action, {
                                    method: 'POST',

                                    headers: {
                                        'X-CSRF-TOKEN': document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            .getAttribute(
                                                'content'
                                            ),

                                        'Accept': 'application/json',

                                        'X-Requested-With': 'XMLHttpRequest'
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
                        |--------------------------------------------------------------------------
                        | REMOVE FROM WISHLIST
                        |--------------------------------------------------------------------------
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
                            | Change form to ADD
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


                            showHomeToast(
                                data.message,
                                'success'
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | ADD TO WISHLIST
                        |--------------------------------------------------------------------------
                        */
                        else {

                            button.classList.add(
                                'active'
                            );


                            button.innerHTML =
                                '<i class="fa-solid fa-heart"></i>';


                            button.title =
                                'Remove from Wishlist';


                            /*
                            | Add DELETE method field
                            */

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
                            | Change form action
                            */

                            form.action =
                                form.action.replace(
                                    '/wishlist/add/',
                                    '/wishlist/remove/'
                                );


                            showHomeToast(
                                data.message,
                                'success'
                            );
                        }


                        button.disabled = false;

                        button.dataset.loading =
                            'false';


                    } catch (error) {

                        console.error(
                            'Wishlist Error:',
                            error
                        );


                        showHomeToast(
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

                }
            );

        });



        /*
        |--------------------------------------------------------------------------
        | TOAST
        |--------------------------------------------------------------------------
        */

        function showHomeToast(message, type) {

            /*
            | Remove previous toast
            */

            const oldToast =
                document.querySelector(
                    '.home-ajax-toast'
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
                'home-ajax-toast ' +
                (
                    type === 'success' ?
                    'success' :
                    'error'
                );


            toast.innerHTML = `

            <i class="${
                type === 'success'
                    ? 'fa-solid fa-circle-check'
                    : 'fa-solid fa-circle-exclamation'
            }"></i>

            <span>${message}</span>

        `;


            document.body.appendChild(toast);


            /*
            | Show
            */

            requestAnimationFrame(function() {

                toast.classList.add(
                    'show'
                );

            });


            /*
            | Hide
            */

            setTimeout(function() {

                toast.classList.remove(
                    'show'
                );


                setTimeout(function() {

                    toast.remove();

                }, 350);

            }, 2500);

        }

    });
    document.addEventListener('DOMContentLoaded', function() {

        const slides = document.querySelectorAll('.home-banner-slide');
        const dots = document.querySelectorAll('.home-banner-dot');

        const prevButton = document.querySelector('.home-banner-prev');
        const nextButton = document.querySelector('.home-banner-next');

        if (!slides.length) {
            return;
        }

        let currentSlide = 0;
        let autoSlide;


        function showSlide(index) {

            if (index >= slides.length) {
                index = 0;
            }

            if (index < 0) {
                index = slides.length - 1;
            }

            currentSlide = index;


            slides.forEach(function(slide, slideIndex) {

                slide.classList.toggle(
                    'active',
                    slideIndex === currentSlide
                );

            });


            dots.forEach(function(dot, dotIndex) {

                dot.classList.toggle(
                    'active',
                    dotIndex === currentSlide
                );

            });

        }


        function nextSlide() {

            showSlide(currentSlide + 1);

        }


        function previousSlide() {

            showSlide(currentSlide - 1);

        }


        function startAutoSlide() {

            if (slides.length > 1) {

                autoSlide = setInterval(function() {

                    nextSlide();

                }, 5000);

            }

        }


        function resetAutoSlide() {

            clearInterval(autoSlide);

            startAutoSlide();

        }


        if (nextButton) {

            nextButton.addEventListener('click', function() {

                nextSlide();

                resetAutoSlide();

            });

        }


        if (prevButton) {

            prevButton.addEventListener('click', function() {

                previousSlide();

                resetAutoSlide();

            });

        }


        dots.forEach(function(dot, index) {

            dot.addEventListener('click', function() {

                showSlide(index);

                resetAutoSlide();

            });

        });


        showSlide(0);

        startAutoSlide();

    });
</script>

@endsection