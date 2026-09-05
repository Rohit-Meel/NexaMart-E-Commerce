<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display all sub-categories.
     */
    public function index()
    {
        $subCategories = SubCategory::with('category')
            ->latest()
            ->get();

        return view('admin.subcategories.index', compact('subCategories'));
    }


    /**
     * Show create form.
     */
    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.subcategories.create', compact('categories'));
    }


    /**
     * Store new sub-category.
     */
    public function store(Request $request)
    {
        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
        ]);

        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
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


        if ($request->hasFile('image')) {

            $validated['image'] = $request
                ->file('image')
                ->store('subcategories', 'public');
        }


        SubCategory::create($validated);


        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Sub-category created successfully.');
    }


    /**
     * Show edit form.
     */
    public function edit(SubCategory $subCategory)
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.subcategories.edit',
            compact('subCategory', 'categories')
        );
    }


    /**
     * Update sub-category.
     */
    public function update(
        Request $request,
        SubCategory $subCategory
    ) {

        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
        ]);


        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
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


        if ($request->hasFile('image')) {

            $validated['image'] = $request
                ->file('image')
                ->store('subcategories', 'public');
        }


        $subCategory->update($validated);


        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Sub-category updated successfully.');
    }


    /**
     * Delete sub-category.
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Sub-category deleted successfully.');
    }


    /**
     * Toggle status.
     */
    public function toggleStatus(SubCategory $subCategory)
    {
        $subCategory->update([
            'status' => !$subCategory->status,
        ]);

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Sub-category status updated successfully.');
    }
}