<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    /**
     * Display all vendors.
     */
    public function index()
    {
        $vendors = Vendor::latest()->get();

        return view('admin.vendors.index', compact('vendors'));
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.vendors.create');
    }


    /**
     * Store new vendor.
     */
    public function store(Request $request)
    {
        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
        ]);

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
                'unique:vendors,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'shop_name' => [
                'required',
                'string',
                'max:255',
            ],

            'shop_description' => [
                'nullable',
                'string',
            ],

            'shop_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'address' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:255',
            ],

            'state' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:10',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);


        $validated['shop_slug'] = Str::slug(
            $validated['shop_name']
        );

        $validated['password'] = Hash::make(
            $validated['password']
        );


        if ($request->hasFile('shop_logo')) {

            $validated['shop_logo'] = $request
                ->file('shop_logo')
                ->store('vendors', 'public');
        }


        Vendor::create($validated);


        return redirect()
            ->route('admin.vendors.index')
            ->with('success', 'Vendor created successfully.');
    }


    /**
     * Show edit form.
     */
    public function edit(Vendor $vendor)
    {
        return view(
            'admin.vendors.edit',
            compact('vendor')
        );
    }


    /**
     * Update vendor.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
        ]);

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
                'unique:vendors,email,' . $vendor->id,
            ],

            'phone' => [
                'nullable',
                'string',
                'max:255',
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],

            'shop_name' => [
                'required',
                'string',
                'max:255',
            ],

            'shop_description' => [
                'nullable',
                'string',
            ],

            'shop_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'address' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:255',
            ],

            'state' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:10',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);


        $validated['shop_slug'] = Str::slug(
            $validated['shop_name']
        );


        if (empty($validated['password'])) {

            unset($validated['password']);

        } else {

            $validated['password'] = Hash::make(
                $validated['password']
            );
        }


        if ($request->hasFile('shop_logo')) {

            $validated['shop_logo'] = $request
                ->file('shop_logo')
                ->store('vendors', 'public');
        }


        $vendor->update($validated);


        return redirect()
            ->route('admin.vendors.index')
            ->with('success', 'Vendor updated successfully.');
    }


    /**
     * Delete vendor.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()
            ->route('admin.vendors.index')
            ->with('success', 'Vendor deleted successfully.');
    }


    /**
     * Toggle vendor status.
     */
    public function toggleStatus(Vendor $vendor)
    {
        $vendor->update([
            'status' => !$vendor->status,
        ]);

        return redirect()
            ->route('admin.vendors.index')
            ->with('success', 'Vendor status updated successfully.');
    }
}