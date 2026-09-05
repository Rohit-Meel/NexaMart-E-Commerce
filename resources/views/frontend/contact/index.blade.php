@extends('layouts.frontend')

@section('title', 'Contact Us - NexaMart')

@section('content')


<!-- =========================================================
     CONTACT ALERTS
========================================================= -->

@if(session('success'))

    <div class="contact-toast contact-toast-success">

        <i class="fa-solid fa-circle-check"></i>

        <span>
            {{ session('success') }}
        </span>

        <button
            type="button"
            class="contact-toast-close"
            onclick="this.parentElement.remove()"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

    </div>

@endif


@if(session('error'))

    <div class="contact-toast contact-toast-error">

        <i class="fa-solid fa-circle-exclamation"></i>

        <span>
            {{ session('error') }}
        </span>

        <button
            type="button"
            class="contact-toast-close"
            onclick="this.parentElement.remove()"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

    </div>

@endif


<!-- =========================================================
     CONTACT PAGE
========================================================= -->

<section class="contact-page">

    <div class="contact-container">


        <!-- =====================================================
             BREADCRUMB
        ====================================================== -->

        <div class="contact-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <i class="fa-solid fa-angle-right"></i>

            <span>
                Contact Us
            </span>

        </div>



        <!-- =====================================================
             PAGE HEADING
        ====================================================== -->

        <div class="contact-heading">

            <span>
                GET IN TOUCH
            </span>

            <h1>
                We're Here To <strong>Help</strong>
            </h1>

            <p>
                Have a question, suggestion or need help with your order?
                Send us a message and we'll be happy to help.
            </p>

        </div>



        <!-- =====================================================
             CONTACT CONTENT
        ====================================================== -->

        <div class="contact-content">


            <!-- =================================================
                 LEFT SIDE
            ================================================== -->

            <div class="contact-info">


                <div class="contact-info-heading">

                    <span>
                        CONTACT INFORMATION
                    </span>

                    <h2>
                        Let's Talk
                    </h2>

                    <p>
                        Our team is ready to answer your questions and
                        help you with anything you need.
                    </p>

                </div>



                <!-- LOCATION -->

                <div class="contact-info-item">

                    <div class="contact-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <div>

                        <h3>
                            Our Location
                        </h3>

                        <p>
                            <a
                                href="https://www.google.com/maps/search/?api=1&query=Jaipur,Rajasthan,India"
                                target="_blank"
                                rel="noopener"
                            >
                                Jaipur, Rajasthan, India
                            </a>
                        </p>

                    </div>

                </div>



                <!-- PHONE -->

                <div class="contact-info-item">

                    <div class="contact-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>

                    <div>

                        <h3>
                            Phone Number
                        </h3>

                        <p>
                            <a href="tel:+919876543210">
                                +91 98765 43210
                            </a>
                        </p>

                    </div>

                </div>



                <!-- EMAIL -->

                <div class="contact-info-item">

                    <div class="contact-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div>

                        <h3>
                            Email Address
                        </h3>

                        <p>
                            <a href="mailto:support@nexamart.com">
                                support@nexamart.com
                            </a>
                        </p>

                    </div>

                </div>



                <!-- WORKING HOURS -->

                <div class="contact-info-item">

                    <div class="contact-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <div>

                        <h3>
                            Working Hours
                        </h3>

                        <p>
                            Monday - Saturday, 9:00 AM - 7:00 PM
                        </p>

                    </div>

                </div>


            </div>



            <!-- =================================================
                 RIGHT SIDE FORM
            ================================================== -->

            <div class="contact-form-card">


                <div class="contact-form-heading">

                    <h2>
                        Send Us A Message
                    </h2>

                    <p>
                        Fill in the details below and we'll get back to you.
                    </p>

                </div>



                <!-- VALIDATION ERRORS -->

                @if($errors->any())

                    <div class="contact-validation-error">

                        <div class="contact-validation-icon">

                            <i class="fa-solid fa-circle-exclamation"></i>

                        </div>

                        <div>

                            <strong>
                                Please check the following:
                            </strong>

                            <ul>

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                @endif



                <!-- =================================================
                     CONTACT FORM
                ================================================== -->

                <form
                    action="{{ route('contact.store') }}"
                    method="POST"
                    id="contactForm"
                >

                    @csrf


                    <!-- NAME + EMAIL -->

                    <div class="contact-form-row">


                        <!-- NAME -->

                        <div class="contact-form-group">

                            <label for="contact-name">
                                Your Name
                            </label>

                            <input
                                type="text"
                                id="contact-name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter your name"
                                maxlength="255"
                                autocomplete="name"
                                required
                            >

                            @error('name')

                                <small class="contact-field-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>



                        <!-- EMAIL -->

                        <div class="contact-form-group">

                            <label for="contact-email">
                                Email Address
                            </label>

                            <input
                                type="email"
                                id="contact-email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                maxlength="255"
                                autocomplete="email"
                                required
                            >

                            @error('email')

                                <small class="contact-field-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                    </div>



                    <!-- PHONE + SUBJECT -->

                    <div class="contact-form-row">


                        <!-- PHONE -->

                        <div class="contact-form-group">

                            <label for="contact-phone">
                                Phone Number
                            </label>

                            <input
                                type="text"
                                id="contact-phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Enter your phone number"
                                maxlength="20"
                                autocomplete="tel"
                            >

                            @error('phone')

                                <small class="contact-field-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>



                        <!-- SUBJECT -->

                        <div class="contact-form-group">

                            <label for="contact-subject">
                                Subject
                            </label>

                            <input
                                type="text"
                                id="contact-subject"
                                name="subject"
                                value="{{ old('subject') }}"
                                placeholder="Enter subject"
                                maxlength="255"
                            >

                            @error('subject')

                                <small class="contact-field-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                    </div>



                    <!-- MESSAGE -->

                    <div class="contact-form-group">

                        <label for="contact-message">
                            Message
                        </label>

                        <textarea
                            id="contact-message"
                            name="message"
                            rows="6"
                            maxlength="5000"
                            placeholder="Write your message here..."
                            required
                        >{{ old('message') }}</textarea>

                        @error('message')

                            <small class="contact-field-error">
                                {{ $message }}
                            </small>

                        @enderror

                        <small
                            class="contact-message-counter"
                            id="contactMessageCounter"
                        >
                            0 / 5000
                        </small>

                    </div>



                    <!-- SUBMIT BUTTON -->

                    <button
                        type="submit"
                        class="contact-submit-btn"
                        id="contactSubmitBtn"
                    >

                        <span class="contact-submit-text">
                            Send Message
                        </span>

                        <i class="fa-solid fa-paper-plane contact-submit-icon"></i>

                        <i
                            class="fa-solid fa-spinner fa-spin contact-submit-loader"
                            style="display:none;"
                        ></i>

                    </button>


                </form>

            </div>

        </div>



        <!-- =====================================================
             FAQ / HELP STRIP
        ====================================================== -->

        <div class="contact-help">

            <div class="contact-help-icon">

                <i class="fa-solid fa-circle-question"></i>

            </div>

            <div>

                <span>
                    NEED QUICK HELP?
                </span>

                <h2>
                    Check our frequently asked questions.
                </h2>

            </div>

            <a href="#contactForm">

                Contact Support

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>


    </div>

</section>



<!-- =========================================================
     CONTACT PAGE CSS
========================================================= -->

<style>

.contact-toast {

    position: fixed;

    top: 90px;
    right: 25px;

    z-index: 999999;

    min-width: 320px;
    max-width: 430px;

    padding: 15px 18px;

    display: flex;
    align-items: center;

    gap: 11px;

    border-radius: 8px;

    color: #ffffff;

    font-size: 14px;
    font-weight: 600;

    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.18);

    animation:
        contactToastIn 0.35s ease;

    transition:
        opacity 0.35s ease,
        transform 0.35s ease;

}


.contact-toast-success {

    background: #20a65a;

}


.contact-toast-error {

    background: #dc3545;

}


.contact-toast > i {

    font-size: 19px;

}


.contact-toast span {

    flex: 1;

}


.contact-toast-close {

    border: none;

    background: transparent;

    color: #ffffff;

    cursor: pointer;

    font-size: 15px;

    padding: 2px 4px;

    opacity: 0.85;

}


.contact-toast-close:hover {

    opacity: 1;

}


@keyframes contactToastIn {

    from {

        opacity: 0;

        transform:
            translateX(100px);

    }

    to {

        opacity: 1;

        transform:
            translateX(0);

    }

}



/* =========================================================
   VALIDATION ERROR
========================================================= */

.contact-validation-error {

    display: flex;

    align-items: flex-start;

    gap: 12px;

    padding: 14px 16px;

    margin-bottom: 20px;

    border-radius: 8px;

    background: #fff1f1;

    border: 1px solid #ffcaca;

    color: #b42318;

    font-size: 13px;

}


.contact-validation-icon {

    font-size: 18px;

    flex-shrink: 0;

}


.contact-validation-error strong {

    display: block;

    margin-bottom: 5px;

}


.contact-validation-error ul {

    margin: 0;

    padding-left: 18px;

}


.contact-validation-error li {

    margin-bottom: 3px;

}



/* =========================================================
   FIELD ERROR
========================================================= */

.contact-field-error {

    display: block;

    margin-top: 5px;

    color: #dc3545;

    font-size: 12px;

}



/* =========================================================
   MESSAGE COUNTER
========================================================= */

.contact-message-counter {

    display: block;

    margin-top: 5px;

    text-align: right;

    font-size: 11px;

    opacity: 0.65;

}



/* =========================================================
   CLICKABLE CONTACT INFO
========================================================= */

.contact-info-item a {

    color: inherit;

    text-decoration: none;

    transition:
        color 0.2s ease;

}


.contact-info-item a:hover {

    color: #20a65a;

}



/* =========================================================
   SUBMIT LOADING
========================================================= */

.contact-submit-btn {

    position: relative;

}


.contact-submit-btn.is-loading {

    opacity: 0.75;

    cursor: not-allowed;

}


.contact-submit-loader {

    margin-left: 7px;

}



/* =========================================================
   RESPONSIVE TOAST
========================================================= */

@media (max-width: 576px) {

    .contact-toast {

        left: 15px;
        right: 15px;

        top: 75px;

        min-width: auto;
        max-width: none;

    }

}

</style>



<!-- =========================================================
     CONTACT PAGE JS
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | CONTACT FORM
    |--------------------------------------------------------------------------
    */

    const contactForm =
        document.getElementById('contactForm');

    const contactButton =
        document.getElementById('contactSubmitBtn');

    const contactSubmitText =
        contactButton
            ? contactButton.querySelector(
                '.contact-submit-text'
            )
            : null;

    const contactSubmitIcon =
        contactButton
            ? contactButton.querySelector(
                '.contact-submit-icon'
            )
            : null;

    const contactSubmitLoader =
        contactButton
            ? contactButton.querySelector(
                '.contact-submit-loader'
            )
            : null;


    if (contactForm && contactButton) {

        contactForm.addEventListener(
            'submit',
            function () {

                /*
                | Prevent double click
                */

                if (
                    contactButton.dataset.loading === 'true'
                ) {

                    return;

                }


                contactButton.dataset.loading =
                    'true';

                contactButton.disabled =
                    true;

                contactButton.classList.add(
                    'is-loading'
                );


                /*
                | Change button state
                */

                if (contactSubmitText) {

                    contactSubmitText.textContent =
                        'Sending...';

                }


                if (contactSubmitIcon) {

                    contactSubmitIcon.style.display =
                        'none';

                }


                if (contactSubmitLoader) {

                    contactSubmitLoader.style.display =
                        'inline-block';

                }

            }
        );

    }



    /*
    |--------------------------------------------------------------------------
    | MESSAGE CHARACTER COUNTER
    |--------------------------------------------------------------------------
    */

    const messageField =
        document.getElementById(
            'contact-message'
        );

    const messageCounter =
        document.getElementById(
            'contactMessageCounter'
        );


    function updateMessageCounter() {

        if (
            !messageField ||
            !messageCounter
        ) {

            return;

        }


        const length =
            messageField.value.length;


        messageCounter.textContent =
            length + ' / 5000';

    }


    if (messageField) {

        messageField.addEventListener(
            'input',
            updateMessageCounter
        );

        updateMessageCounter();

    }



    /*
    |--------------------------------------------------------------------------
    | AUTO HIDE TOAST
    |--------------------------------------------------------------------------
    */

    const contactToasts =
        document.querySelectorAll(
            '.contact-toast'
        );


    contactToasts.forEach(function (toast) {

        setTimeout(function () {

            toast.style.opacity =
                '0';

            toast.style.transform =
                'translateX(100px)';


            setTimeout(function () {

                toast.remove();

            }, 350);

        }, 4000);

    });


});

</script>


@endsection