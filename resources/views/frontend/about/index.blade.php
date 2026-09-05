@extends('layouts.frontend')

@section('title', 'About Us - NexaMart')

@section('content')

<section class="about-page">

    <div class="about-container">

        <!-- BREADCRUMB -->

        <div class="about-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <span>
                About Us
            </span>

        </div>


        <!-- HERO -->

        <div class="about-hero">

            <div class="about-hero-content">

                <span class="about-tag">
                    ABOUT NEXAMART
                </span>

                <h1>
                    Making Shopping
                    <span>Simple & Better</span>
                </h1>

                <p>
                    NexaMart is your trusted online shopping destination,
                    bringing quality products, great prices and a smooth
                    shopping experience together in one place.
                </p>

                <p>
                    From everyday essentials to the latest products,
                    we are committed to making online shopping easier,
                    faster and more convenient for everyone.
                </p>

                <a href="{{ route('products') }}" class="about-shop-btn">
                    Explore Products

                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>


            <div class="about-hero-image">

                <img
                    src="{{ asset('assets/images/about/about.jpg') }}"
                    alt="NexaMart Shopping"
                >

            </div>

        </div>


        <!-- WHY US -->

        <div class="about-section-heading">

            <span>
                WHY CHOOSE US
            </span>

            <h2>
                Shopping Made For <strong>You</strong>
            </h2>

            <p>
                We focus on quality, convenience and customer satisfaction.
            </p>

        </div>


        <div class="about-features">


            <div class="about-feature-card">

                <div class="about-feature-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>

                <h3>
                    Quality Products
                </h3>

                <p>
                    Carefully selected products that meet our quality
                    standards.
                </p>

            </div>


            <div class="about-feature-card">

                <div class="about-feature-icon">
                    <i class="fa-solid fa-tags"></i>
                </div>

                <h3>
                    Best Prices
                </h3>

                <p>
                    Great products at competitive prices with exciting
                    offers and deals.
                </p>

            </div>


            <div class="about-feature-card">

                <div class="about-feature-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>

                <h3>
                    Fast Delivery
                </h3>

                <p>
                    Quick and reliable delivery to get your orders to you
                    on time.
                </p>

            </div>


            <div class="about-feature-card">

                <div class="about-feature-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>

                <h3>
                    Customer Support
                </h3>

                <p>
                    Our support team is always ready to help whenever
                    you need us.
                </p>

            </div>

        </div>


        <!-- STATS -->

        <div class="about-stats">

            <div class="about-stat">

                <strong>
                    10K+
                </strong>

                <span>
                    Happy Customers
                </span>

            </div>


            <div class="about-stat">

                <strong>
                    5K+
                </strong>

                <span>
                    Products
                </span>

            </div>


            <div class="about-stat">

                <strong>
                    50+
                </strong>

                <span>
                    Categories
                </span>

            </div>


            <div class="about-stat">

                <strong>
                    24/7
                </strong>

                <span>
                    Customer Support
                </span>

            </div>

        </div>


        <!-- CTA -->

        <div class="about-cta">

            <div>

                <span>
                    READY TO SHOP?
                </span>

                <h2>
                    Discover Something You'll Love
                </h2>

            </div>

            <a href="{{ route('products') }}">
                Shop Now

                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>

    </div>

</section>

@endsection