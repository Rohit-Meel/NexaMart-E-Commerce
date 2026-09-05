@extends('layouts.frontend')

@section('title', 'Login - NexaMart')

@section('content')

<section class="auth-page">

    <div class="auth-container">

        <div class="auth-card">
                {{-- SUCCESS MESSAGE --}}
@if(session('success'))

    <div class="auth-alert auth-alert-success">

        <i class="fa-solid fa-circle-check"></i>

        <span>
            {{ session('success') }}
        </span>

    </div>

@endif


{{-- LOGOUT MESSAGE --}}
@if(session('logout_success'))

    <div class="auth-alert auth-alert-logout">

        <i class="fa-solid fa-circle-check"></i>

        <span>
            {{ session('logout_success') }}
        </span>

    </div>

@endif
            <div class="auth-logo">

                <a href="{{ route('home') }}">

                    <img
                        src="{{ asset('assets/images/logo/logo.png') }}"
                        alt="NexaMart"
                    >

                </a>

            </div>


            <div class="auth-heading">

                <span>WELCOME BACK</span>

                <h1>
                    Login to <strong>NexaMart</strong>
                </h1>

                <p>
                    Sign in to continue shopping with us.
                </p>

            </div>


            {{-- SUCCESS MESSAGE --}}

            @if(session('success'))

                <div class="auth-success-message">
                    {{ session('success') }}
                </div>

            @endif


            {{-- ERROR MESSAGE --}}

            @if($errors->any())

                <div class="auth-error-message">

                    {{ $errors->first() }}

                </div>

            @endif


            <form
                action="{{ route('login.authenticate') }}"
                method="POST"
            >

                @csrf


                <div class="auth-form-group">

                    <label>
                        Email Address
                    </label>

                    <div class="auth-input">

                        <i class="fa-regular fa-envelope"></i>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                            required
                        >

                    </div>

                </div>


                <div class="auth-form-group">

                    <div class="auth-label-row">

                        <label>
                            Password
                        </label>

                        <a href="#">
                            Forgot Password?
                        </a>

                    </div>


                    <div class="auth-input">

                        <i class="fa-solid fa-lock"></i>

                        <input
                            type="password"
                            name="password"
                            id="loginPassword"
                            placeholder="Enter your password"
                            required
                        >

                        <i
                            class="fa-regular fa-eye auth-eye"
                            id="loginPasswordToggle"
                            style="cursor:pointer;"
                        ></i>

                    </div>

                </div>


                <label class="remember-me">

                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                    >

                    <span>
                        Remember me
                    </span>

                </label>


                <button
                    type="submit"
                    class="auth-submit"
                >

                    Login

                    <i class="fa-solid fa-arrow-right"></i>

                </button>

            </form>


            <div class="auth-divider">

                <span>OR</span>

            </div>


            <div class="auth-register">

                <span>
                    Don't have an account?
                </span>

                <a href="{{ route('register') }}">
                    Create Account
                </a>

            </div>


            <a
                href="{{ route('home') }}"
                class="auth-back"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Back to Shopping

            </a>

        </div>

    </div>

</section>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('loginPassword');

    const toggle = document.getElementById('loginPasswordToggle');


    if (password && toggle) {

        toggle.addEventListener('click', function () {

            if (password.type === 'password') {

                password.type = 'text';

                toggle.classList.remove('fa-eye');

                toggle.classList.add('fa-eye-slash');

            } else {

                password.type = 'password';

                toggle.classList.remove('fa-eye-slash');

                toggle.classList.add('fa-eye');

            }

        });

    }

});

    setTimeout(function () {

        document.querySelectorAll(
            '.auth-alert, .home-alert'
        ).forEach(function (alert) {

            alert.style.transition = '0.4s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(40px)';

            setTimeout(function () {
                alert.remove();
            }, 400);

        });

    }, 4000);

</script>

@endsection