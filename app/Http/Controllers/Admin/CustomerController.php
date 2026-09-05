<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $customers = Customer::withCount('orders')
            ->latest()
            ->get();

        return view('admin.customers.index', compact('customers'));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.customers.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
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

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],

        ]);


        if ($request->hasFile('profile_image')) {

            $validated['profile_image'] =
                $request->file('profile_image')
                    ->store('customers', 'public');

        }


        $validated['password'] = Hash::make(
            $validated['password']
        );

        $validated['status'] = $request->boolean('status');


        Customer::create($validated);


        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Customer $customer)
    {
        $customer->load([
            'addresses',
            'orders',
            'reviews',
        ]);

        return view(
            'admin.customers.show',
            compact('customer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Customer $customer)
    {
        return view(
            'admin.customers.edit',
            compact('customer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Customer $customer
    ) {

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
                'unique:customers,email,' . $customer->id,
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],

        ]);


        if ($request->hasFile('profile_image')) {

            $validated['profile_image'] =
                $request->file('profile_image')
                    ->store('customers', 'public');

        }


        if (!empty($validated['password'])) {

            $validated['password'] =
                Hash::make($validated['password']);

        } else {

            unset($validated['password']);

        }


        $validated['status'] = $request->boolean('status');


        $customer->update($validated);


        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | TOGGLE STATUS
    |--------------------------------------------------------------------------
    */

    public function toggleStatus(Customer $customer)
    {
        $customer->update([
            'status' => !$customer->status,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Customer status updated successfully.');
    }
}