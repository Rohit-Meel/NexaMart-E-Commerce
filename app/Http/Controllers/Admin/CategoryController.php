<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index()
    {
        $categories = Category::latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show create category form.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store new category.
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', 'boolean'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */
        $validated['slug'] = Str::slug($validated['name']);

        /*
        |--------------------------------------------------------------------------
        | Category Image Upload
        |--------------------------------------------------------------------------
        | Image will be stored in:
        | public/assets/images/category
        |
        | Database will store only filename.
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            // Create unique image name
            $imageName = time() . '_' . Str::slug(
                pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $image->getClientOriginalExtension();

            // Move image to public category folder
            $image->move(
                public_path('assets/images/category'),
                $imageName
            );

            // Store only filename in database
            $validated['image'] = $imageName;
        }

        /*
        |--------------------------------------------------------------------------
        | Create Category
        |--------------------------------------------------------------------------
        */
        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show edit category form.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update category.
     */
    public function update(Request $request, Category $category)
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3048'],
            'status' => ['required', 'boolean'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */
        $validated['slug'] = Str::slug($validated['name']);

        /*
        |--------------------------------------------------------------------------
        | New Category Image
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            // Delete old image if it exists
            if (
                !empty($category->image) &&
                file_exists(
                    public_path('assets/images/category/' . $category->image)
                )
            ) {
                unlink(
                    public_path('assets/images/category/' . $category->image)
                );
            }

            // Create unique image name
            $imageName = time() . '_' . Str::slug(
                pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $image->getClientOriginalExtension();

            // Move new image
            $image->move(
                public_path('assets/images/category'),
                $imageName
            );

            // Store only filename in database
            $validated['image'] = $imageName;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Category
        |--------------------------------------------------------------------------
        */
        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Delete category.
     */
    public function destroy(Category $category)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Category Image
        |--------------------------------------------------------------------------
        */
        if (
            !empty($category->image) &&
            file_exists(
                public_path('assets/images/category/' . $category->image)
            )
        ) {
            unlink(
                public_path('assets/images/category/' . $category->image)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Category
        |--------------------------------------------------------------------------
        */
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Toggle category status.
     */
    public function toggleStatus(Category $category)
    {
        $category->update([
            'status' => !$category->status,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category status updated successfully.');
    }
}