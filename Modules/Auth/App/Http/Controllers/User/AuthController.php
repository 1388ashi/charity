<?php

namespace Modules\Auth\App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\User\App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm($mobile = null)
    {
        if (auth()->guard('user')->user())
        {
            return redirect('user');
        }

        return view('auth::user.login',compact('mobile'));
    }
    // public function showSmsPage(Request $request)
    // {
    //     $pattern = app(CoreSettings::class)->get('sms.patterns.booth_login');
    //     $token = Helpers::randomNumbersCode(5);
    //     $output = Sms::pattern($pattern)  
    //     ->data([  
    //         'token' => $token,
    //     ])->to([$request->mobile])->send();  
    //     if ($output['status'] != 200){
    //         Log::debug('', [$output]);
    //     }

    //     if ($output['status'] == 200) {
    //         $smsToken = SmsToken::where('mobile', $request->mobile)->first();
    //         if ($smsToken) {
    //             $smsToken->update([
    //                 'token' => $token,
    //                 'expired_at' => Carbon::now()->addHours(24)
    //             ]);
    //         } else {
    //             SmsToken::create([
    //                 'mobile' => $request->mobile,
    //                 'token' => $token,
    //                 'expired_at' => Carbon::now()->addHours(24)
    //             ]);
    //         }
    //     }
        
    //     return view('auth::exhibitor.sms',['mobile' => $request->mobile]);
    // }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $mobile = $request->input('mobile');
        $user = User::where('mobile', $mobile)->first();
        
        if ($user) {
            Auth::guard('user')->login($user);

            $request->session()->regenerate();
            
            return redirect()->intended('user');
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

        return redirect()->route('user.login.form');
    }
}
