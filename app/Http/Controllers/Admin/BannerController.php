<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display all banners.
     */
    public function index()
    {
        $banners = Banner::orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.banners.index', compact('banners'));
    }


    /**
     * Show create banner form.
     */
    public function create()
    {
        return view('admin.banners.create');
    }


    /**
     * Store new banner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'button_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'button_url' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'nullable',
                'boolean',
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

        ]);


        /*
        |--------------------------------------------------------------------------
        | BANNER IMAGE UPLOAD
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move(
                public_path('assets/images/banners'),
                $imageName
            );

            // Database me sirf filename save hoga
            $validated['image'] = $imageName;
        }


        $validated['status'] = $request->boolean('status');

        $validated['sort_order'] = $validated['sort_order'] ?? 0;


        Banner::create($validated);


        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }


    /**
     * Show edit banner form.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }


    /**
     * Update banner.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([

            'title' => [
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

            'button_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'button_url' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'nullable',
                'boolean',
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

        ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE BANNER IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            // Delete old image
            if ($banner->image) {

                $oldImage = public_path(
                    'assets/images/banners/' . $banner->image
                );

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }


            // Upload new image
            $image = $request->file('image');

            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move(
                public_path('assets/images/banners'),
                $imageName
            );

            // Database me sirf filename
            $validated['image'] = $imageName;
        }


        $validated['status'] = $request->boolean('status');

        $validated['sort_order'] = $validated['sort_order'] ?? 0;


        $banner->update($validated);


        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }


    /**
     * Delete banner.
     */
    public function destroy(Banner $banner)
    {
        /*
        |--------------------------------------------------------------------------
        | DELETE BANNER IMAGE
        |--------------------------------------------------------------------------
        */

        if ($banner->image) {

            $imagePath = public_path(
                'assets/images/banners/' . $banner->image
            );

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }


        $banner->delete();


        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }


    /**
     * Toggle banner status.
     */
    public function toggleStatus(Banner $banner)
    {
        $banner->update([
            'status' => !$banner->status,
        ]);


        return redirect()
            ->route('admin.banners.index')
            ->with(
                'success',
                'Banner status updated successfully.'
            );
    }
}