<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        abort_unless($product->status, 404);

        $validated = $request->validate([
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],

            'comment' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $customer = auth('customer')->user();

        $existingReview = Review::where(
                'customer_id',
                $customer->id
            )
            ->where(
                'product_id',
                $product->id
            )
            ->first();

        if ($existingReview) {

            $existingReview->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'status' => true,
            ]);

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => true,
                    'message' => 'Your review has been updated successfully.',
                    'review' => [
                        'customer_name' => $customer->name,
                        'rating' => (int) $existingReview->rating,
                        'comment' => $existingReview->comment,
                        'date' => now()->format('d M Y'),
                    ],
                ]);
            }

            return redirect()
                ->route(
                    'products.show',
                    $product->slug
                )
                ->with(
                    'success',
                    'Your review has been updated successfully.'
                );
        }

        $review = Review::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'order_id' => null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => true,
        ]);

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your review has been submitted successfully.',
                'review' => [
                    'customer_name' => $customer->name,
                    'rating' => (int) $review->rating,
                    'comment' => $review->comment,
                    'date' => now()->format('d M Y'),
                ],
            ]);
        }

        return redirect()
            ->route(
                'products.show',
                $product->slug
            )
            ->with(
                'success',
                'Thank you! Your review has been submitted successfully.'
            );
    }
}
