<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display all products.
     */
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


    /**
     * Show create product form.
     */
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

        return view(
            'admin.products.create',
            compact(
                'categories',
                'subCategories',
                'brands',
                'vendors'
            )
        );
    }


    /**
     * Store new product.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Status & Featured
        |--------------------------------------------------------------------------
        */

        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
            'featured' => $request->has('featured') ? 1 : 0,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

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

            /*
            |--------------------------------------------------------------------------
            | Thumbnail
            |--------------------------------------------------------------------------
            */

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | Multiple Product Images
            |--------------------------------------------------------------------------
            */

            'images' => [
                'nullable',
                'array',
                'max:10',
            ],

            'images.*' => [
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


        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */

        $validated['slug'] = Str::slug($validated['name']);

        if (
            Product::where('slug', $validated['slug'])->exists()
        ) {
            $validated['slug'] .= '-' . Str::random(5);
        }


        /*
        |--------------------------------------------------------------------------
        | Product Thumbnail Upload
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('thumbnail')) {

            $thumbnail = $request->file('thumbnail');

            $thumbnailName = time() . '_' . Str::slug(
                pathinfo(
                    $thumbnail->getClientOriginalName(),
                    PATHINFO_FILENAME
                )
            ) . '.' . $thumbnail->getClientOriginalExtension();

            $thumbnail->move(
                public_path('assets/images/products'),
                $thumbnailName
            );

            $validated['thumbnail'] = $thumbnailName;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        */

        $product = Product::create($validated);


        /*
        |--------------------------------------------------------------------------
        | Multiple Product Images Upload
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $index => $image) {

                $imageName = time() . '_' . Str::random(6) . '_' . Str::slug(
                    pathinfo(
                        $image->getClientOriginalName(),
                        PATHINFO_FILENAME
                    )
                ) . '.' . $image->getClientOriginalExtension();

                $image->move(
                    public_path('assets/images/products'),
                    $imageName
                );

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                    'is_primary' => false,
                    'sort_order' => $index,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }


    /**
     * Show edit product form.
     */
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

        /*
        |--------------------------------------------------------------------------
        | Load Product Images
        |--------------------------------------------------------------------------
        */

        $product->load([
            'images' => function ($query) {
                $query->orderBy('sort_order')
                    ->orderBy('id');
            }
        ]);

        return view(
            'admin.products.edit',
            compact(
                'product',
                'categories',
                'subCategories',
                'brands',
                'vendors'
            )
        );
    }


    /**
     * Update product.
     */
    public function update(Request $request, Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | Status & Featured
        |--------------------------------------------------------------------------
        */

        $request->merge([
            'status' => $request->has('status') ? 1 : 0,
            'featured' => $request->has('featured') ? 1 : 0,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

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

            /*
            |--------------------------------------------------------------------------
            | Thumbnail
            |--------------------------------------------------------------------------
            */

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | New Multiple Images
            |--------------------------------------------------------------------------
            */

            'images' => [
                'nullable',
                'array',
                'max:10',
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | Delete Existing Images
            |--------------------------------------------------------------------------
            */

            'delete_images' => [
                'nullable',
                'array',
            ],

            'delete_images.*' => [
                'integer',
                'exists:product_images,id',
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


        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */

        $validated['slug'] = Str::slug($validated['name']);

        if (
            Product::where('slug', $validated['slug'])
                ->where('id', '!=', $product->id)
                ->exists()
        ) {
            $validated['slug'] .= '-' . Str::random(5);
        }


        /*
        |--------------------------------------------------------------------------
        | New Product Thumbnail
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('thumbnail')) {

            $thumbnail = $request->file('thumbnail');


            /*
            |--------------------------------------------------------------------------
            | Delete Old Thumbnail
            |--------------------------------------------------------------------------
            */

            if (
                !empty($product->thumbnail) &&
                file_exists(
                    public_path(
                        'assets/images/products/' . $product->thumbnail
                    )
                )
            ) {
                unlink(
                    public_path(
                        'assets/images/products/' . $product->thumbnail
                    )
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Create New Thumbnail Name
            |--------------------------------------------------------------------------
            */

            $thumbnailName = time() . '_' . Str::slug(
                pathinfo(
                    $thumbnail->getClientOriginalName(),
                    PATHINFO_FILENAME
                )
            ) . '.' . $thumbnail->getClientOriginalExtension();


            /*
            |--------------------------------------------------------------------------
            | Move New Thumbnail
            |--------------------------------------------------------------------------
            */

            $thumbnail->move(
                public_path('assets/images/products'),
                $thumbnailName
            );


            $validated['thumbnail'] = $thumbnailName;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->update($validated);


        /*
        |--------------------------------------------------------------------------
        | Delete Selected Existing Product Images
        |--------------------------------------------------------------------------
        */

        if ($request->filled('delete_images')) {

            $deleteImages = ProductImage::where('product_id', $product->id)
                ->whereIn('id', $request->delete_images)
                ->get();

            foreach ($deleteImages as $productImage) {

                $imagePath = public_path(
                    'assets/images/products/' . $productImage->image
                );

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                $productImage->delete();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Get Current Maximum Sort Order
        |--------------------------------------------------------------------------
        */

        $maxSortOrder = ProductImage::where(
            'product_id',
            $product->id
        )->max('sort_order');

        $nextSortOrder = is_null($maxSortOrder)
            ? 0
            : $maxSortOrder + 1;


        /*
        |--------------------------------------------------------------------------
        | Upload New Multiple Product Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $imageName = time() . '_' . Str::random(6) . '_' . Str::slug(
                    pathinfo(
                        $image->getClientOriginalName(),
                        PATHINFO_FILENAME
                    )
                ) . '.' . $image->getClientOriginalExtension();

                $image->move(
                    public_path('assets/images/products'),
                    $imageName
                );

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                    'is_primary' => false,
                    'sort_order' => $nextSortOrder,
                ]);

                $nextSortOrder++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }


    /**
     * Delete product.
     */
    public function destroy(Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Thumbnail
        |--------------------------------------------------------------------------
        */

        if (
            !empty($product->thumbnail) &&
            file_exists(
                public_path(
                    'assets/images/products/' . $product->thumbnail
                )
            )
        ) {
            unlink(
                public_path(
                    'assets/images/products/' . $product->thumbnail
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Product Gallery Images
        |--------------------------------------------------------------------------
        */

        $productImages = ProductImage::where(
            'product_id',
            $product->id
        )->get();

        foreach ($productImages as $productImage) {

            $imagePath = public_path(
                'assets/images/products/' . $productImage->image
            );

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $productImage->delete();
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Product
        |--------------------------------------------------------------------------
        */

        $product->delete();


        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }


    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => !$product->status,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product status updated successfully.');
    }


    /**
     * Toggle featured status.
     */
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