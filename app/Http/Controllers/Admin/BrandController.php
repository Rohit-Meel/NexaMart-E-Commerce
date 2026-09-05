<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display all brands.
     */
    public function index()
    {
        $brands = Brand::latest()->get();

        return view('admin.brands.index', compact('brands'));
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.brands.create');
    }


    /**
     * Store new brand.
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

            'description' => [
                'nullable',
                'string',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);


        $validated['slug'] = Str::slug($validated['name']);


        if ($request->hasFile('logo')) {

            $validated['logo'] = $request
                ->file('logo')
                ->store('brands', 'public');
        }


        Brand::create($validated);


        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }


    /**
     * Show edit form.
     */
    public function edit(Brand $brand)
    {
        return view(
            'admin.brands.edit',
            compact('brand')
        );
    }


    /**
     * Update brand.
     */
    public function update(Request $request, Brand $brand)
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

            'description' => [
                'nullable',
                'string',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);


        $validated['slug'] = Str::slug($validated['name']);


        if ($request->hasFile('logo')) {

            $validated['logo'] = $request
                ->file('logo')
                ->store('brands', 'public');
        }


        $brand->update($validated);


        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }


    /**
     * Delete brand.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }


    /**
     * Toggle brand status.
     */
    public function toggleStatus(Brand $brand)
    {
        $brand->update([
            'status' => !$brand->status,
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand status updated successfully.');
    }
}