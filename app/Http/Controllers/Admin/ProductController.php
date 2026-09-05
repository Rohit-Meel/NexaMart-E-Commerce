<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'category',
            'subCategory',
            'brand',
            'vendor'
        ])->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        $subCategories = SubCategory::where('status', true)
            ->orderBy('name')
            ->get();

        $brands = Brand::where('status', true)
            ->orderBy('name')
            ->get();

        $vendors = Vendor::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.products.create', compact(
            'categories',
            'subCategories',
            'brands',
            'vendors'
        ));
    }

    public function store(Request $request)
    {
        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
            'featured' => $request->has('featured') ? 1 : 0,
        ]);

        $validated = $request->validate([

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'sub_category_id' => [
                'nullable',
                'exists:sub_categories,id',
            ],

            'brand_id' => [
                'nullable',
                'exists:brands,id',
            ],

            'vendor_id' => [
                'nullable',
                'exists:vendors,id',
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

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'sku' => [
                'required',
                'string',
                'max:255',
                'unique:products,sku',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'featured' => [
                'required',
                'boolean',
            ],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] .= '-' . Str::random(5);
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('products', 'public');
        }

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        $subCategories = SubCategory::where('status', true)
            ->orderBy('name')
            ->get();

        $brands = Brand::where('status', true)
            ->orderBy('name')
            ->get();

        $vendors = Vendor::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.products.edit', compact(
            'product',
            'categories',
            'subCategories',
            'brands',
            'vendors'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
            'featured' => $request->has('featured') ? 1 : 0,
        ]);

        $validated = $request->validate([

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'sub_category_id' => [
                'nullable',
                'exists:sub_categories,id',
            ],

            'brand_id' => [
                'nullable',
                'exists:brands,id',
            ],

            'vendor_id' => [
                'nullable',
                'exists:vendors,id',
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

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'sku' => [
                'required',
                'string',
                'max:255',
                'unique:products,sku,' . $product->id,
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'featured' => [
                'required',
                'boolean',
            ],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if (
            Product::where('slug', $validated['slug'])
                ->where('id', '!=', $product->id)
                ->exists()
        ) {
            $validated['slug'] .= '-' . Str::random(5);
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => !$product->status,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product status updated successfully.');
    }

    public function toggleFeatured(Product $product)
    {
        $product->update([
            'featured' => !$product->featured,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Featured status updated successfully.');
    }
}