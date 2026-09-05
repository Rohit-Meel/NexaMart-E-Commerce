<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | NexaMart</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.10);
        }

        .login-title {
            text-align: center;
            margin-bottom: 8px;
            font-size: 28px;
            font-weight: 700;
        }

        .login-subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        .form-group input:focus {
            border-color: #ff7a00;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
            font-size: 14px;
        }

        .remember-row input {
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            border: none;
            padding: 13px;
            border-radius: 8px;
            background: #ff7a00;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .login-btn:hover {
            opacity: 0.9;
        }

        .field-error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
        }

        /* Toast */

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            min-width: 300px;
            max-width: 380px;
            padding: 15px 18px;
            margin-bottom: 10px;
            border-radius: 8px;
            color: #ffffff;
            font-size: 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;

            animation: slideIn 0.35s ease;
        }

        .toast-success {
            background: #28a745;
        }

        .toast-error {
            background: #dc3545;
        }

        .toast-close {
            border: none;
            background: transparent;
            color: #ffffff;
            font-size: 20px;
            cursor: pointer;
        }

        @keyframes slideIn {
            from {
                transform: translateX(120%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 576px) {
            .login-wrapper {
                padding: 15px;
            }

            .login-card {
                padding: 25px;
            }

            .toast-container {
                left: 15px;
                right: 15px;
                top: 15px;
            }

            .toast {
                min-width: auto;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    {{-- Toast Messages --}}
    <div class="toast-container">

        @if(session('success'))
            <div class="toast toast-success">
                <span>✓ {{ session('success') }}</span>

                <button type="button" class="toast-close"
                        onclick="this.parentElement.remove()">
                    &times;
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="toast toast-error">
                <span>✕ {{ session('error') }}</span>

                <button type="button" class="toast-close"
                        onclick="this.parentElement.remove()">
                    &times;
                </button>
            </div>
        @endif

    </div>


    <div class="login-wrapper">

        <div class="login-card">

            <h1 class="login-title">
                Admin Login
            </h1>

            <p class="login-subtitle">
                Login to your NexaMart admin panel
            </p>


            <form action="{{ route('admin.login.submit') }}" method="POST">

                @csrf


                {{-- Email --}}
                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        required
                        autofocus
                    >

                    @error('email')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Password --}}
                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                    @error('password')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Remember Me --}}
                <div class="remember-row">

                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        value="1"
                    >

                    <label for="remember">
                        Remember me
                    </label>

                </div>


                <button type="submit" class="login-btn">
                    Login
                </button>

            </form>

        </div>

    </div>


    {{-- Auto Hide Toast --}}
    <script>
        setTimeout(function () {

            const toast = document.querySelector('.toast');

            if (toast) {
                toast.remove();
            }

        }, 4000);
    </script>

</body>
</html>