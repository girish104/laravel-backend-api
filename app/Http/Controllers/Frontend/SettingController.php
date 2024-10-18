<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function setting(Request $request)
    {
        $setting = Setting::latest()->first();
        return view('admin.setting.config', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        Setting::create($request->all());
        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
