@extends('layouts.frontend')

@section('title', 'Categories - NexaMart')

@section('content')

<section class="categories-page">

    <div class="categories-container">

        <div class="categories-header">

            <div>
                <span class="categories-tag">
                    SHOP BY CATEGORY
                </span>

                <h1>
                    Explore Our <span>Categories</span>
                </h1>

                <p>
                    Find everything you need from our wide range of categories.
                </p>
            </div>

            <div class="categories-breadcrumb">

                <a href="{{ route('home') }}">
                    Home
                </a>

                <i class="fa-solid fa-angle-right"></i>

                <span>
                    Categories
                </span>

            </div>

        </div>


        <div class="categories-grid">

            @forelse($categories as $category)

            <a
                href="{{ route('products', ['category' => $category->slug]) }}"
                class="category-page-card">

                <div class="category-page-image">

                    @if($category->image)

                    <img
                        src="{{ asset('assets/images/category/' . $category->image) }}"
                        alt="{{ $category->name }}">

                    @else

                    <div class="category-image-placeholder">
                        <i class="fa-solid fa-image"></i>
                    </div>

                    @endif

                </div>


                <div class="category-page-info">

                    <div>

                        <h2>
                            {{ $category->name }}
                        </h2>

                        <span>
                            {{ $category->products_count }}
                            {{ $category->products_count == 1 ? 'Product' : 'Products' }}
                        </span>

                    </div>

                    <i class="fa-solid fa-arrow-right"></i>

                </div>

            </a>

            @empty

            <div class="empty-category-message">

                <i class="fa-solid fa-layer-group"></i>

                <h2>
                    No Categories Found
                </h2>

                <p>
                    Categories will appear here once they are added.
                </p>

            </div>

            @endforelse

        </div>

    </div>

</section>

@endsection