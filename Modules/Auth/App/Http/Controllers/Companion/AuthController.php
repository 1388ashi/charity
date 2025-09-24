<?php

namespace Modules\Auth\App\Http\Controllers\Companion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Companion\App\Models\Companion;

class AuthController extends Controller
{
    public function showLoginForm($mobile = null)
    {
        if (auth()->guard('companion')->user())
        {
            return redirect('companion');
        }

        return view('auth::companion.login',compact('mobile'));
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $mobile = $request->input('mobile');
        $companion = Companion::where('mobile', $mobile)->first();
        
        if ($companion) {
            Auth::guard('companion')->login($companion);

            $request->session()->regenerate();
            
            return redirect()->intended('companion');
        }

        return back()->withErrors([
            'mobile' => 'شماره موبایل معتبر نیست!',
        ]);
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('companion.login.form');
    }
}
