<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONTACT PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('frontend.contact.index');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE CONTACT MESSAGE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'subject' => [
                'nullable',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
                'max:5000',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | SAVE MESSAGE
        |--------------------------------------------------------------------------
        */

        Contact::create([

            'name' => $validated['name'],

            'email' => $validated['email'],

            'phone' => $validated['phone'] ?? null,

            'subject' => $validated['subject'] ?? null,

            'message' => $validated['message'],

            'status' => false,

        ]);


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('contact')
            ->with(
                'success',
                'Your message has been sent successfully!'
            );
    }
}