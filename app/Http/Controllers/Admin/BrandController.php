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
        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */
        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */
        $validated['slug'] = Str::slug($validated['name']);

        /*
        |--------------------------------------------------------------------------
        | Brand Logo Upload
        |--------------------------------------------------------------------------
        | Image will be stored in:
        | public/assets/images/brand
        |
        | Database will store only filename.
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('logo')) {

            $logo = $request->file('logo');

            // Create unique logo name
            $logoName = time() . '_' . Str::slug(
                pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $logo->getClientOriginalExtension();

            // Move logo to public brand folder
            $logo->move(
                public_path('assets/images/brand'),
                $logoName
            );

            // Store only filename in database
            $validated['logo'] = $logoName;
        }

        /*
        |--------------------------------------------------------------------------
        | Create Brand
        |--------------------------------------------------------------------------
        */
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
        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */
        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */
        $validated['slug'] = Str::slug($validated['name']);

        /*
        |--------------------------------------------------------------------------
        | New Brand Logo
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('logo')) {

            $logo = $request->file('logo');

            /*
            | Delete old logo
            */
            if (
                !empty($brand->logo) &&
                file_exists(
                    public_path('assets/images/brand/' . $brand->logo)
                )
            ) {
                unlink(
                    public_path('assets/images/brand/' . $brand->logo)
                );
            }

            // Create unique logo name
            $logoName = time() . '_' . Str::slug(
                pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $logo->getClientOriginalExtension();

            // Move new logo
            $logo->move(
                public_path('assets/images/brand'),
                $logoName
            );

            // Store only filename in database
            $validated['logo'] = $logoName;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Brand
        |--------------------------------------------------------------------------
        */
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
        /*
        |--------------------------------------------------------------------------
        | Delete Brand Logo
        |--------------------------------------------------------------------------
        */
        if (
            !empty($brand->logo) &&
            file_exists(
                public_path('assets/images/brand/' . $brand->logo)
            )
        ) {
            unlink(
                public_path('assets/images/brand/' . $brand->logo)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Brand
        |--------------------------------------------------------------------------
        */
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