<?php

namespace Modules\Auth\App\Http\Controllers\HelpUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Companion\App\Models\HelpUser;

class AuthController extends Controller
{
    public function showLoginForm($mobile = null,$code = null)
    {
        $code = request()->query('code');
        if (auth('help_user')->user())
        {
            return redirect()->to('/help-user?code=' . urlencode($code));
        }

        return view('auth::help-user.login',compact('mobile','code'));
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
        $code = $request->input('code');
        $user = HelpUser::firstOrCreate(['mobile' => $mobile],['mobile' => $mobile]);
        Auth::guard('help_user')->login($user);
        $request->session()->regenerate();
        
        return redirect()->intended('help-user?code=' . urlencode($code));   
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('help-user.login.form');
    }
}
