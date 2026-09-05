@extends('layouts.frontend')

@section('title', 'Brands - NexaMart')

@section('content')

<section class="brands-page">

    <div class="brands-container">


        <!-- =====================================================
             BREADCRUMB
        ====================================================== -->

        <div class="brands-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <span>
                Brands
            </span>

        </div>


        <!-- =====================================================
             HEADING
        ====================================================== -->

        <div class="brands-heading">

            <div>

                <span>
                    SHOP BY BRAND
                </span>

                <h1>
                    Explore Our <strong>Brands</strong>
                </h1>

                <p>
                    Discover products from brands you know and trust.
                </p>

            </div>

        </div>


        <!-- =====================================================
             SEARCH
        ====================================================== -->

        <form
            action="{{ route('brands') }}"
            method="GET"
            class="brands-search">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search brands...">

            @if(request('search'))

            <a
                href="{{ route('brands') }}"
                class="brands-search-clear"
                title="Clear Search">
                <i class="fa-solid fa-xmark"></i>
            </a>

            @endif

        </form>


        <!-- =====================================================
             BRANDS
        ====================================================== -->

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


                <!-- @if($brand->description)

                        <p>
                            {{ \Illuminate\Support\Str::limit(
                                $brand->description,
                                70
                            ) }}
                        </p>

                    @else

                        <p>
                            Explore {{ $brand->name }} products
                        </p>

                    @endif -->


                <small class="brand-product-count">

                    {{ $brand->products_count }}

                    {{ $brand->products_count == 1 ? 'Product' : 'Products' }}

                </small>

            </a>

            @empty

            <div class="no-brands">

                @if(request('search'))

                <h3>
                    No brands found
                </h3>

                <p>
                    No brand matches your search.
                </p>

                <a
                    href="{{ route('brands') }}"
                    class="brands-reset-btn">
                    View All Brands
                </a>

                @else

                <h3>
                    No Brands Available
                </h3>

                <p>
                    There are currently no active brands.
                </p>

                @endif

            </div>

            @endforelse

        </div>


        <!-- =====================================================
             CTA
        ====================================================== -->

        <div class="brands-cta">

            <div>

                <span>
                    FIND YOUR FAVOURITE
                </span>

                <h2>
                    Looking for something specific?
                </h2>

                <p>
                    Explore all our products and find exactly what you need.
                </p>

            </div>

            <a href="{{ route('products') }}">

                Explore Products

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>

    </div>

</section>

@endsection