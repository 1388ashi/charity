<?php

namespace Modules\Auth\Listeners;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Events\SmsVerify;
use Modules\Core\Classes\CoreSettings;
use Modules\Core\Helpers\Helpers;
use Modules\Sms\Sms;
use Modules\User\App\Models\SmsToken;

class SendSmsToken
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param SmsVerify $event
     * @return Sms
     */
    public function handle(SmsVerify $event): array
    {
        $digits = 5;
        $token = Helpers::randomNumbersCode($digits);

        if (App::environment('production')) {
            $digits = app(CoreSettings::class)->get('sms.digits', 5);

            $pattern = app(CoreSettings::class)->get('sms.patterns.user_login');
            $mobile = $event->mobile;

            $output = Sms::pattern($pattern)->data([
                'code' => $token
            ])->to([$mobile])->send();

            if ($output['status'] != 200){
                Log::debug('', [$output]);
            }

            if ($output['status'] == 200) {
                //store into database
                $smsToken = SmsToken::where('mobile', $event->mobile)->first();
                if ($smsToken) {
                    $smsToken->update([
                        'token' => $token,
                        'expired_at' => Carbon::now()->addHours(24)
                    ]);
                } else {
                    SmsToken::create([
                        'mobile' => $event->mobile,
                        'token' => $token,
                        'expired_at' => Carbon::now()->addHours(24)
                    ]);
                }
            }
        }else{
            $output = array();
            $output['status'] = 200;
            //store into database
            $smsToken = SmsToken::where('mobile', $event->mobile)->first();
            if ($smsToken) {
                $smsToken->update([
                    'token' => 12345,
                    'expired_at' => Carbon::now()->addHours(24)
                ]);
            } else {
                SmsToken::create([
                    'mobile' => $event->mobile,
                    'token' => 12345,
                    'expired_at' => Carbon::now()->addHours(24)
                ]);
            }

        }


        return $output;
    }
}
