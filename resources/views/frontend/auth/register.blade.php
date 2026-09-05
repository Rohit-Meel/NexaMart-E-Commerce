@extends('layouts.frontend')

@section('title', 'Create Account - NexaMart')

@section('content')

<section class="auth-page">

    <div class="auth-container">

        <div class="auth-card register-card">

            <!-- LOGO -->

            <div class="auth-logo">

                <a href="{{ route('home') }}">

                    <img
                        src="{{ asset('assets/images/logo/logo.png') }}"
                        alt="NexaMart"
                    >

                </a>

            </div>


            <!-- HEADING -->

            <div class="auth-heading">

                <span>
                    JOIN NEXAMART
                </span>

                <h1>
                    Create Your <strong>Account</strong>
                </h1>

                <p>
                    Create an account and start shopping today.
                </p>

            </div>


            <!-- ERRORS -->

            @if($errors->any())

                <div class="auth-error">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <div>

                        @foreach($errors->all() as $error)

                            <div>
                                {{ $error }}
                            </div>

                        @endforeach

                    </div>

                </div>

            @endif


            <!-- REGISTER FORM -->

            <form
                action="{{ route('register.store') }}"
                method="POST"
            >

                @csrf


                <!-- FIRST / LAST NAME -->

                <div class="auth-form-row">

                    <div class="auth-form-group">

                        <label>
                            First Name
                        </label>

                        <div class="auth-input">

                            <i class="fa-regular fa-user"></i>

                            <input
                                type="text"
                                name="first_name"
                                value="{{ old('first_name') }}"
                                placeholder="First name"
                                required
                            >

                        </div>

                    </div>


                    <div class="auth-form-group">

                        <label>
                            Last Name
                        </label>

                        <div class="auth-input">

                            <i class="fa-regular fa-user"></i>

                            <input
                                type="text"
                                name="last_name"
                                value="{{ old('last_name') }}"
                                placeholder="Last name"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- EMAIL -->

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
                            autocomplete="email"
                        >

                    </div>

                </div>


                <!-- PHONE -->

                <div class="auth-form-group">

                    <label>
                        Phone Number
                    </label>

                    <div class="auth-input">

                        <i class="fa-solid fa-phone"></i>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Enter phone number"
                        >

                    </div>

                </div>


                <!-- PASSWORD -->

                <div class="auth-form-row">

                    <div class="auth-form-group">

                        <label>
                            Password
                        </label>

                        <div class="auth-input">

                            <i class="fa-solid fa-lock"></i>

                            <input
                                type="password"
                                name="password"
                                placeholder="Password"
                                required
                                autocomplete="new-password"
                            >

                        </div>

                    </div>


                    <div class="auth-form-group">

                        <label>
                            Confirm Password
                        </label>

                        <div class="auth-input">

                            <i class="fa-solid fa-lock"></i>

                            <input
                                type="password"
                                name="password_confirmation"
                                placeholder="Confirm password"
                                required
                                autocomplete="new-password"
                            >

                        </div>

                    </div>

                </div>


                <!-- TERMS -->

                <label class="terms-check">

                    <input
                        type="checkbox"
                        name="terms"
                        value="1"
                        {{ old('terms') ? 'checked' : '' }}
                        required
                    >

                    <span>

                        I agree to the

                        <a href="#">
                            Terms & Conditions
                        </a>

                        and

                        <a href="#">
                            Privacy Policy
                        </a>

                    </span>

                </label>


                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="auth-submit"
                >

                    Create Account

                    <i class="fa-solid fa-arrow-right"></i>

                </button>

            </form>


            <!-- DIVIDER -->

            <div class="auth-divider">

                <span>
                    OR
                </span>

            </div>


            <!-- LOGIN -->

            <div class="auth-register">

                <span>
                    Already have an account?
                </span>

                <a href="{{ route('login') }}">
                    Login
                </a>

            </div>


            <!-- BACK -->

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

@endsection