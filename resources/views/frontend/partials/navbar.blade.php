

<nav class="main-navbar">

    <div class="container">

        <ul>

            <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    Home
                </a>
            </li>

            <li class="{{ request()->routeIs('categories') ? 'active' : '' }}">
                <a href="{{ route('categories') }}">
                    Categories
                </a>
            </li>

            <li class="{{ request()->routeIs('products') ? 'active' : '' }}">
                <a href="{{ route('products') }}">
                    Products
                </a>
            </li>

            <li class="{{ request()->routeIs('brands') ? 'active' : '' }}">
                <a href="{{ route('brands') }}">
                    Brands
                </a>
            </li>

            <li class="{{ request()->routeIs('shops') ? 'active' : '' }}">
                <a href="{{ route('shops') }}">
                    Shops
                </a>
            </li>

            <li class="offers-link {{ request()->routeIs('offers') ? 'active' : '' }}">
                <a href="{{ route('offers') }}">
                    Offers
                </a>
            </li>

            <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                <a href="{{ route('about') }}">
                    About Us
                </a>
            </li>

            <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                <a href="{{ route('contact') }}">
                    Contact Us
                </a>
            </li>

        </ul>

    </div>

</nav>