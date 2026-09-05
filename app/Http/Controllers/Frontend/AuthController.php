<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Page
    |--------------------------------------------------------------------------
    */

    public function login()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('home');
        }

        return view('frontend.auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
            ],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
        ]);


        $remember = $request->boolean('remember');


        if (
            Auth::guard('customer')->attempt(
                [
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                    'status' => true,
                ],
                $remember
            )
        ) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('success', 'Welcome back to NexaMart!');
        }


        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'The email or password is incorrect.',
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Register Page
    |--------------------------------------------------------------------------
    */

    public function register()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('home');
        }

        return view('frontend.auth.register');
    }


    /*
    |--------------------------------------------------------------------------
    | Register Customer
    |--------------------------------------------------------------------------
    */

    public function storeRegister(Request $request)
    {
        $validated = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:customers,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'terms' => [
                'required',
            ],
        ], [
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Password and confirm password do not match.',
            'terms.required' => 'Please accept the Terms & Conditions and Privacy Policy.',
        ]);


        $customer = Customer::create([
            'name' => trim(
                $validated['first_name'] . ' ' . $validated['last_name']
            ),

            'email' => $validated['email'],

            'phone' => $validated['phone'] ?? null,

            'password' => $validated['password'],

            'status' => true,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Automatically Login After Registration
        |--------------------------------------------------------------------------
        */

        Auth::guard('customer')->login($customer);

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Go To Home
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('home')
            ->with('success', 'Account created successfully. Welcome to NexaMart!');
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
    ->route('login')
    ->with('logout_success', 'You have been logged out successfully.');
}
}