<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SUBSCRIBE TO NEWSLETTER
    |--------------------------------------------------------------------------
    */

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],
        ]);

        $email = strtolower(trim($request->email));

        /*
        |--------------------------------------------------------------------------
        | CHECK EXISTING SUBSCRIBER
        |--------------------------------------------------------------------------
        */

        $subscriber = NewsletterSubscriber::where(
            'email',
            $email
        )->first();

        if ($subscriber) {

            if ($subscriber->status) {

                return response()->json([
                    'success' => false,
                    'message' => 'This email is already subscribed.',
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | REACTIVATE SUBSCRIBER
            |--------------------------------------------------------------------------
            */

            $subscriber->update([
                'status' => true,
                'subscribed_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Welcome back! You are subscribed again.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE NEW SUBSCRIBER
        |--------------------------------------------------------------------------
        */

        NewsletterSubscriber::create([
            'email' => $email,
            'status' => true,
            'subscribed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'You have successfully subscribed to NexaMart!',
        ]);
    }
}