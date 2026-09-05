<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    /**
     * Display all coupons.
     */
    public function index()
    {
        $coupons = Coupon::latest()->get();

        return view('admin.coupons.index', compact('coupons'));
    }


    /**
     * Show create coupon form.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }


    /**
     * Store new coupon.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:coupons,code',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'discount_type' => [
                'required',
                Rule::in(['percentage', 'fixed']),
            ],

            'discount_value' => [
                'required',
                'numeric',
                'min:0',
            ],

            'minimum_order_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'maximum_discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'usage_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'start_at' => [
                'nullable',
                'date',
            ],

            'end_at' => [
                'nullable',
                'date',
                'after_or_equal:start_at',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ]);


        $validated['code'] = strtoupper($validated['code']);

        $validated['minimum_order_amount'] =
            $validated['minimum_order_amount'] ?? 0;

        $validated['status'] =
            $request->has('status');


        if (
            $validated['discount_type'] === 'percentage' &&
            $validated['discount_value'] > 100
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'discount_value' =>
                        'Percentage discount cannot be greater than 100.',
                ]);
        }


        Coupon::create($validated);


        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }


    /**
     * Show edit coupon form.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }


    /**
     * Update coupon.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:coupons,code,' . $coupon->id,
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'discount_type' => [
                'required',
                Rule::in(['percentage', 'fixed']),
            ],

            'discount_value' => [
                'required',
                'numeric',
                'min:0',
            ],

            'minimum_order_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'maximum_discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'usage_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'start_at' => [
                'nullable',
                'date',
            ],

            'end_at' => [
                'nullable',
                'date',
                'after_or_equal:start_at',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ]);


        $validated['code'] = strtoupper($validated['code']);

        $validated['minimum_order_amount'] =
            $validated['minimum_order_amount'] ?? 0;

        $validated['status'] =
            $request->has('status');


        if (
            $validated['discount_type'] === 'percentage' &&
            $validated['discount_value'] > 100
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'discount_value' =>
                        'Percentage discount cannot be greater than 100.',
                ]);
        }


        $coupon->update($validated);


        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }


    /**
     * Toggle coupon status.
     */
    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update([
            'status' => !$coupon->status,
        ]);


        return back()
            ->with('success', 'Coupon status updated successfully.');
    }


    /**
     * Delete coupon.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();


        return back()
            ->with('success', 'Coupon deleted successfully.');
    }
}