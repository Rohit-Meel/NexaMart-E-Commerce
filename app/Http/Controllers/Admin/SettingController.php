<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')
            ->orderBy('id')
            ->get();

        return view('admin.settings.index', compact('settings'));
    }


    public function update(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'value' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $setting->update([
            'value' => $validated['value'] ?? null,
            'status' => $request->has('status'),
        ]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Setting updated successfully.');
    }
}