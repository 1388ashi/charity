<?php

namespace Modules\Auth\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\App\Http\Requests\Admin\LoginRequest;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->guard('admin')->user())
        {
            return redirect('admin');
        }

        return view('auth::admin.login');
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = [
            'mobile' => $request->input('mobile'),
            'password' => $request->input('password')
        ];

        if (Auth::guard('admin')->attempt($credentials, (bool) $request->input('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('admin');
        }

        return back()->withErrors([
            'mobile' => 'اطلاعات وارد شده اشتباه است!',
        ]);
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }
}
