<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display all admins
     */
    public function index()
    {
        $admins = Admin::latest()->get();

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show create admin form
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store new admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'max:50'],
            'status' => ['required', 'boolean'],
        ]);

        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    /**
     * Show edit admin form
     */
    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update admin
     */
    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins', 'email')->ignore($admin->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'max:50'],
            'status' => ['required', 'boolean'],
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'] ?? null;
        $admin->role = $validated['role'];
        $admin->status = $validated['status'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    /**
     * Toggle admin status
     */
    public function toggleStatus(Admin $admin)
    {
        if (auth('admin')->id() === $admin->id) {
            return back()->with('error', 'You cannot disable your own account.');
        }

        $admin->status = !$admin->status;
        $admin->save();

        return back()->with(
            'success',
            $admin->status
                ? 'Admin enabled successfully.'
                : 'Admin disabled successfully.'
        );
    }

    /**
     * Delete admin
     */
    public function destroy(Admin $admin)
    {
        if (auth('admin')->id() === $admin->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $admin->delete();

        return back()->with('success', 'Admin deleted successfully.');
    }
}