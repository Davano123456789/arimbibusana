<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('dashboard.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        if ($request->hasFile('qris_image')) {
            $request->validate([
                'qris_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            $path = $request->file('qris_image')->store('settings', 'public');
            $data['qris_image'] = $path;
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
