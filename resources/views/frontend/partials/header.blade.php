<header class="top-header">

    <div class="container">

        <div class="header-wrapper">

            {{-- LOGO --}}
            <div class="logo">

                <a href="{{ route('home') }}">

                    <img
                        src="{{ asset('assets/images/logo/logo.png') }}"
                        alt="NexaMart">

                </a>

            </div>


            {{-- SEARCH --}}
            <div class="search-box">

                <form action="{{ route('products') }}" method="GET">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search products, brands and categories...">

                    <button type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                </form>

            </div>


            {{-- HEADER RIGHT --}}
            <div class="header-right">


                {{-- CUSTOMER AUTH --}}
                @if(Auth::guard('customer')->check())

                {{-- USER NAME --}}
                <a
                    href="{{ route('customer.account') }}"
                    class="header-user">

                    <i class="fa-regular fa-user"></i>

                    <span>
                        {{ Auth::guard('customer')->user()->name }}
                    </span>

                </a>

                {{-- LOGOUT --}}
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="logout-form">

                    @csrf

                    <button
                        type="submit"
                        class="header-logout">

                        <i class="fa-solid fa-right-from-bracket"></i>

                        <span>
                            Logout
                        </span>

                    </button>

                </form>

                @else

                {{-- LOGIN --}}
                <a href="{{ route('login') }}">

                    <i class="fa-regular fa-user"></i>

                    <span>
                        Login
                    </span>

                </a>

                @endif


                {{-- WISHLIST --}}
                <a href="{{ route('wishlist') }}">

                    <i class="fa-regular fa-heart"></i>

                    <span>
                        Wishlist
                    </span>

                </a>


                {{-- CART --}}
                <a
                    href="{{ route('cart') }}"
                    class="cart-link">

                    <i class="fa-solid fa-cart-shopping"></i>

                    <!-- <span class="cart-count">
                        0
                    </span> -->

                </a>


            </div>

        </div>

    </div>

</header>