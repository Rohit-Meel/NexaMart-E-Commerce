<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display all reviews.
     */
    public function index()
    {
        $reviews = Review::with([
            'customer',
            'product',
            'order'
        ])
        ->latest()
        ->get();

        return view('admin.reviews.index', compact('reviews'));
    }


    /**
     * Show create form.
     */
    public function create()
    {
        $customers = Customer::orderBy('id', 'desc')->get();

        $products = Product::orderBy('id', 'desc')->get();

        $orders = Order::orderBy('id', 'desc')->get();

        return view(
            'admin.reviews.create',
            compact(
                'customers',
                'products',
                'orders'
            )
        );
    }


    /**
     * Store review.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'customer_id' => [
                'required',
                'exists:customers,id'
            ],

            'product_id' => [
                'required',
                'exists:products,id'
            ],

            'order_id' => [
                'nullable',
                'exists:orders,id'
            ],

            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],

            'comment' => [
                'nullable',
                'string'
            ],

        ]);


        $validated['status'] = $request->has('status');


        Review::create($validated);


        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }


    /**
     * Show edit form.
     */
    public function edit(Review $review)
    {
        $customers = Customer::orderBy('id', 'desc')->get();

        $products = Product::orderBy('id', 'desc')->get();

        $orders = Order::orderBy('id', 'desc')->get();

        return view(
            'admin.reviews.edit',
            compact(
                'review',
                'customers',
                'products',
                'orders'
            )
        );
    }


    /**
     * Update review.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([

            'customer_id' => [
                'required',
                'exists:customers,id'
            ],

            'product_id' => [
                'required',
                'exists:products,id'
            ],

            'order_id' => [
                'nullable',
                'exists:orders,id'
            ],

            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],

            'comment' => [
                'nullable',
                'string'
            ],

        ]);


        $validated['status'] = $request->has('status');


        $review->update($validated);


        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }


    /**
     * Delete review.
     */
    public function destroy(Review $review)
    {
        $review->delete();


        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }


    /**
     * Toggle review status.
     */
    public function toggleStatus(Review $review)
    {
        $review->update([
            'status' => !$review->status
        ]);


        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review status updated successfully.');
    }
}