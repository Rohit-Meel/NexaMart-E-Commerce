@extends('layouts.frontend')

@section('title', 'Shops - NexaMart')

@section('content')

<section class="shops-page">

    <div class="shops-container">
   
        <!-- =========================================================
             BREADCRUMB
        ========================================================= -->

        <div class="shops-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <span>
                Shops
            </span>

        </div>


        <!-- =========================================================
             HEADING
        ========================================================= -->

        <div class="shops-heading">

            <div>

                <span>
                    DISCOVER OUR SHOPS
                </span>

                <h1>
                    Explore <strong>Shops</strong>
                </h1>

                <p>
                    Find your favourite products from trusted shops and sellers.
                </p>

            </div>

        </div>


        <!-- =========================================================
             SEARCH + FILTER
        ========================================================= -->

        <form
            action="{{ route('shops') }}"
            method="GET"
            class="shops-toolbar"
        >

            <div class="shops-search">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search shops..."
                >

            </div>


            <select
                name="category"
                class="shops-select"
                onchange="this.form.submit()"
            >

                <option value="">
                    All Categories
                </option>

                @foreach($categories as $category)

                    <option
                        value="{{ $category->slug }}"
                        {{ request('category') == $category->slug ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>


            <button
                type="submit"
                style="display:none;"
            >
                Search
            </button>

        </form>


        <!-- =========================================================
             ACTIVE FILTER
        ========================================================= -->

        @if(request('search') || request('category'))

            <div class="shops-filter-info">

                @if(request('search'))

                    <span>
                        Search:
                        <strong>
                            {{ request('search') }}
                        </strong>
                    </span>

                @endif


                @if(request('category'))

                    @php
                        $selectedCategory = $categories
                            ->firstWhere('slug', request('category'));
                    @endphp

                    @if($selectedCategory)

                        <span>
                            Category:
                            <strong>
                                {{ $selectedCategory->name }}
                            </strong>
                        </span>

                    @endif

                @endif


                <a href="{{ route('shops') }}">
                    Clear
                </a>

            </div>

        @endif


        <!-- =========================================================
             SHOP GRID
        ========================================================= -->

        <div class="shops-grid">

            @forelse($shops as $shop)

                @php

                    $shopCategories = $shop->products
                        ->pluck('category')
                        ->filter()
                        ->unique('id')
                        ->values();

                @endphp


                <!-- =================================================
                     SHOP CARD
                ================================================= -->

                <div class="shop-card">

                    <div class="shop-cover">

                        @if($shop->status)

                            <span class="shop-status">
                                Open
                            </span>

                        @else

                            <span class="shop-status">
                                Closed
                            </span>

                        @endif

                    </div>


                    <div class="shop-content">


                        <!-- SHOP LOGO -->

                        <div class="shop-logo">

                            @if($shop->shop_logo)

                                <img
                                    src="{{ asset('assets/images/vendor/' . $shop->shop_logo) }}"
                                    alt="{{ $shop->shop_name }}"
                                >

                            @else

                                <i class="fa-solid fa-store"></i>

                            @endif

                        </div>


                        <!-- SHOP DETAILS -->

                        <div class="shop-details">

                            <h3>
                                {{ $shop->shop_name }}
                            </h3>


                            <!-- SHOP CATEGORIES -->

                            <p class="shop-category">

                                @forelse($shopCategories as $shopCategory)

                                    {{ $shopCategory->name }}@if(!$loop->last), @endif

                                @empty

                                    No category

                                @endforelse

                            </p>


                            <!-- RATING -->

                            <div class="shop-rating">

                                <span>
                                    ★★★★★
                                </span>

                                <small>
                                    Shop
                                </small>

                            </div>


                            <!-- LOCATION -->

                            <p class="shop-location">

                                <i class="fa-solid fa-location-dot"></i>

                                {{ $shop->city ?: 'Location not available' }}

                            </p>

                        </div>


                        <!-- VISIT SHOP -->

                        <a
                            href="{{ route('shop.show', $shop->shop_slug) }}"
                            class="shop-view-btn"
                        >

                            Visit Shop

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>

                    </div>

                </div>

            @empty

                <!-- =================================================
                     NO SHOPS
                ================================================= -->

                <div class="no-shops">

                    <div class="no-shops-icon">

                        <i class="fa-solid fa-store-slash"></i>

                    </div>

                    <h3>
                        No Shops Found
                    </h3>

                    <p>
                        We couldn't find any shop matching your search.
                    </p>

                    <a href="{{ route('shops') }}">
                        View All Shops
                    </a>

                </div>

            @endforelse

        </div>


        <!-- =========================================================
             CTA
        ========================================================= -->

        <div class="shops-cta">

            <div>

                <span>
                    ARE YOU A SELLER?
                </span>

                <h2>
                    Start selling with NexaMart
                </h2>

                <p>
                    Grow your business and reach more customers.
                </p>

            </div>


            <a href="#">

                Become a Seller

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>


    </div>

</section>

@endsection