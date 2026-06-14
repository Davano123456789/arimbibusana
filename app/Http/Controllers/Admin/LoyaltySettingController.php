<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class LoyaltySettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('dashboard.loyalty.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'loyalty_status' => 'required|in:0,1',
            'loyalty_min_order' => 'required|numeric|min:0',
            'loyalty_points_given' => 'required|numeric|min:1',
            'loyalty_method' => 'required|in:multiplier,flat',
            'loyalty_point_value' => 'required|numeric|min:1',
        ]);

        $data = $request->only([
            'loyalty_status',
            'loyalty_min_order',
            'loyalty_points_given',
            'loyalty_method',
            'loyalty_point_value'
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan Loyalty Points berhasil diperbarui!');
    }
}
