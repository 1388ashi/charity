<?php

namespace Modules\Core\Helpers;

use Illuminate\Support\Facades\App;
use Modules\Order\Jobs\SmsSenderJob;
use Modules\Core\Classes\CoreSettings;
use Shetabit\Shopit\Modules\Sms\Sms;

class SmsSender
{
    public function __construct(public string $mobile)
    {
    }


    public function shopitVerification($token):array
    {
        $pattern = app(CoreSettings::class)->get('sms.patterns.verification_code');
        $data = [
            'code' => $token
        ];
        return $this->send($data,$pattern,false,false);
    }


    public function productUnavailableForAdmin($name,$balance):array
    {
        $pattern = app(CoreSettings::class)->get('sms.patterns.product_unavailable_admin');
        $data = [
            'token' => $name,
            'token2' => $balance
        ];
        return $this->send($data,$pattern,true,false);
    }
    public function productUnavailableForAdmin2($name,$balance):array
    {
        $pattern = app(CoreSettings::class)->get('sms.patterns.product_unavailable_admin');
        $data = [
            'token' => $name,
            'token2' => $balance
        ];
        return $this->send($data,$pattern,true,false);
    }
    public function productUnavailableForAdmin3($name,$balance):array
    {
        $pattern = app(CoreSettings::class)->get('sms.patterns.product_unavailable_admin');
        $data = [
            'token' => $name,
            'token2' => $balance
        ];
        return $this->send($data,$pattern,true,false);
    }

//    public function couponForSuccessOrder($amount,$code):array
//    {
//        $pattern = app(CoreSettings::class)->get('sms.patterns.coupon_for_success_order');
//        $data = [
//            'token' => $amount,
//            'token2' => $code
//        ];
//        return $this->send($data,$pattern,false,false);
//    }

    public function customerSuccessPaymentsGift($name,int $giftAmount, $balance):array
    {
        $pattern = app(\Modules\Core\Classes\CoreSettings::class)->get('sms.patterns.customer_success_payments_gift');
        $data = [
            'token' => $name,
            'token2' => number_format($giftAmount),
            'token3' => number_format($balance)
        ];
        return $this->send($data, $pattern, true);
    }

    private function send(array $data, string $pattern, bool $byJob, bool $executeManually = false):array
    {
        if (env('APP_ENV') == 'local') return ['status' => 200];

        if ($byJob) {
            SmsSenderJob::dispatch($pattern,$this->mobile,$data)->delay(30);
            return ['status' => 200];
        }

        if ($executeManually) {
            $data['template'] = $pattern;
            $data['receptor'] = $this->mobile;
            \Modules\Core\Helpers\Sms::execute_manually_to_kavenegar($data);
            return ['status' => 200];
        }
        /* @var $output array */
        $output = Sms::pattern($pattern)->data($data)->to([$this->mobile])->send();
        return $output;
    }



    public function changeOrderStatusToNew($orderId, $fullName):array
    {
        $pattern = app(\Modules\Core\Classes\CoreSettings::class)->get('sms.patterns.new_order');
        $data = [
            "token" => $orderId,
            "token2" => null,
            "token3" => null,
            "type" => null,
            "token10" => ($fullName ?? 'مشتری'),
            "token20" => null,
        ];
        return $this->send($data,$pattern,false,true);
    }

    public function changeOrderStatusToInProgress($orderId, $fromDate, $toDate):array
    {
        $pattern = app(\Modules\Core\Classes\CoreSettings::class)->get('sms.patterns.shopit-inprogress') ?? "shopit-inprogress";
        $data = [
            'code' => $orderId,
            'token2' => $fromDate,
            'token3' => $toDate
        ];
        return $this->send($data,$pattern,true,false);
    }

    public function changeOrderStatusToDelivered($orderId):array
    {
        $pattern = app(\Modules\Core\Classes\CoreSettings::class)->get('sms.patterns.shopit-delivered') ?? "shopit-delivered";
        $data = [
            'code' => $orderId,
        ];
        return $this->send($data,$pattern,true,false);
    }

    public function changeOrderStatusToCanceledOrCanceledByUser():array
    {
        $pattern = app(\Modules\Core\Classes\CoreSettings::class)->get('sms.patterns.cancel-order') ?? "cancel-order";
        $data = [
            'code' => ".",
        ];
        return $this->send($data,$pattern,true,false);
    }
    public function changeStatus($full_name, $orderId, $status):array
    {
        $pattern = app(\Modules\Core\Classes\CoreSettings::class)->get('sms.patterns.change_status');
        $data = [
            "token" => $orderId,
            "token2" => null,
            "token3" => null,
            "type" => null,
            "token10" => $full_name,
            "token20" => $status,
        ];
        return $this->send($data,$pattern,false,true);
    }
    public function depositWallet($amount):array
    {
        $pattern = app(CoreSettings::class)->get('sms.patterns.deposit_wallet');
        $data = [
            'token' => $amount
        ];
        return $this->send($data,$pattern,false,false);
    }
    public function productAvailable($link):array
    {
        $pattern = app(CoreSettings::class)->get('sms.patterns.product-available');
        $data = [
            'token' => $link
        ];
        return $this->send($data,$pattern,false);
    }
}
