<?php

namespace Modules\Core\Helpers;

use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar\KavenegarApi;
use Log;

class Sms
{
    /**
     * @var KavenegarApi
     */
    protected KavenegarApi $api;

    /**
     * Sms constructor.
     * @param KavenegarApi $api
     */
    public function __construct(KavenegarApi $api)
    {
        $this->api = $api;
    }

    /**
     * Send SMS with Kavenegar Api.
     *
     * @param string $mobile
     * @param string $message
     * @return array
     */
    public function send(string $mobile, string $message): array
    {
        try {
            $sender = config('kavenegar.sender');
            $this->api->send($sender, $mobile, $message);

            $result = [
                'success' => true,
                'message' => 'Successfully'
            ];

        } catch(ApiException $e){
            $result = [
                'success' => false,
                'message' => 'Api Error:' . $e->errorMessage()
            ];
            //If webservice output not 200.
            Log::error('Send SMS Api Error: ' . $e->errorMessage());

        } catch(HttpException $e){

            $result = [
                'success' => false,
                'message' => 'Connection Error: ' . $e->errorMessage()
            ];
            //Problem with connection to webservice
            Log::error('Send SMS Connection Error: ' . $e->errorMessage());

        }

        return $result;

    }

    /**
     * Send Verify SMS with Kavenegar Api.
     *
     * @param string $mobile
     * @param string $token1
     * @param string $token2
     * @param string $token3
     * @param string $template
     * @return array
     */
    public function lookup(string $mobile, string $token1, $token2 = '', $token3 = '', $template = 'verify'): array
    {
        try {
            $this->api->VerifyLookup($mobile, $token1, $token2, $token3, $template);

            $result = [
                'success' => true,
                'message' => 'Successfully'
            ];

        } catch(ApiException $e){
            $result = [
                'success' => false,
                'message' => 'Api Error:' . $e->errorMessage()
            ];
            //If webservice output not 200.
            Log::error('Send SMS Api Error: ' . $e->errorMessage());

        } catch(HttpException $e){

            $result = [
                'success' => false,
                'message' => 'Connection Error: ' . $e->errorMessage()
            ];
            //Problem with connection to webservice
            Log::error('Send SMS Connection Error: ' . $e->errorMessage());

        }

        return $result;

    }
}
