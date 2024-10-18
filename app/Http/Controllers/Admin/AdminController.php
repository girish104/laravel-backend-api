<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function authenticate(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            User::where('email', $request->email)->update(['updated_at' => now()]);
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function loginForm()
    {
        if (Auth::check())  return redirect()->route('admin.dash');
        return view('admin.setting.login');
    }

    public function dashboard()
    {
        return view('admin.index');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with(['status' => 'info', 'msg' => 'Logout..']);
    }
}
