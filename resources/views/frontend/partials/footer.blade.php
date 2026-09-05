<!-- =========================================================
     FOOTER
========================================================= -->

<footer class="site-footer">

    <div class="footer-container">


        <!-- ABOUT -->

        <div class="footer-column footer-about">

            <a href="{{ route('home') }}" class="footer-logo">
                <img
                src="{{ asset('assets/images/logo/logo.png') }}"
                alt="NexaMart Shopping">

            </a>

            <p>
                Your trusted online marketplace for quality products,
                amazing deals and a simple shopping experience.
            </p>

            <div class="footer-social">

                <a href="#" aria-label="Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>

                <a href="#" aria-label="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a href="#" aria-label="Twitter">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>

                <a href="#" aria-label="YouTube">
                    <i class="fa-brands fa-youtube"></i>
                </a>

            </div>

        </div>


        <!-- QUICK LINKS -->

        <div class="footer-column">

            <h3>
                Quick Links
            </h3>

            <ul>

                <li>
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li>
                    <a href="{{ route('about') }}">
                        About Us
                    </a>
                </li>

                <li>
                    <a href="{{ route('products') }}">
                        Products
                    </a>
                </li>

                <li>
                    <a href="{{ route('categories') }}">
                        Categories
                    </a>
                </li>

                <li>
                    <a href="{{ route('contact') }}">
                        Contact Us
                    </a>
                </li>

            </ul>

        </div>


        <!-- CATEGORIES -->

        <div class="footer-column">

            <h3>
                Categories
            </h3>

            <ul>

                <li>
                    <a href="#">
                        Electronics
                    </a>
                </li>

                <li>
                    <a href="#">
                        Fashion
                    </a>
                </li>

                <li>
                    <a href="#">
                        Home & Living
                    </a>
                </li>

                <li>
                    <a href="#">
                        Beauty
                    </a>
                </li>

                <li>
                    <a href="#">
                        Sports
                    </a>
                </li>

            </ul>

        </div>


        <!-- CUSTOMER SERVICE -->

        <div class="footer-column">

            <h3>
                Customer Service
            </h3>

            <ul>

                <li>
                    <a href="{{route('customer.account')}}">
                        My Account
                    </a>
                </li>

                <li>
                    <a href="{{route('my-account.orders')}}">
                        My Orders
                    </a>
                </li>

                <li>
                    <a href="{{route('wishlist')}}">
                        Wishlist
                    </a>
                </li>

                <li>
                    <a href="#">
                        Shipping Policy
                    </a>
                </li>

                <li>
                    <a href="#">
                        Return Policy
                    </a>
                </li>

            </ul>

        </div>


        <!-- CONTACT -->

        <div class="footer-column footer-contact">

            <h3>
                Contact Us
            </h3>

            <div class="footer-contact-item">

                <i class="fa-solid fa-location-dot"></i>

                <span>
                    New Delhi, India
                </span>

            </div>


            <div class="footer-contact-item">

                <i class="fa-solid fa-phone"></i>

                <span>
                    +91 98765 43210
                </span>

            </div>


            <div class="footer-contact-item">

                <i class="fa-regular fa-envelope"></i>

                <span>
                    support@nexamart.com
                </span>
               

            </div>

        </div>

    </div>


    <!-- FOOTER BOTTOM -->

    <div class="footer-bottom">

        <div class="footer-bottom-container">

            <p>
                © {{ date('Y') }} NexaMart.
                All Rights Reserved.
            </p>

            <div class="footer-bottom-links">

                <a href="#">
                    Privacy Policy
                </a>

                <a href="#">
                    Terms & Conditions
                </a>

            </div>

        </div>

    </div>

</footer>