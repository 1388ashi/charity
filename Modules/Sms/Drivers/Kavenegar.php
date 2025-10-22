<?php


namespace Modules\Sms\Drivers;

use Modules\Core\Classes\CoreSettings;
use Modules\Sms\Exceptions\ApiException;
use Modules\Sms\Exceptions\BaseRuntimeException;
use Modules\Sms\Exceptions\HttpException;
use Modules\Sms\SmsInterface;

class Kavenegar implements SmsInterface
{
    const APIPATH = "%s://api.kavenegar.com/v1/%s/%s/%s.json/";
    const VERSION = "1.2.2";

    protected string $drive = 'kavenegar';

    protected string $apiKey;

    protected bool $insecure;

    protected string $pattern_code;

    protected string $method;

    protected string $sender;

    protected mixed $numbers;

    protected mixed $data;

    protected string $text;

    protected string $token;

    protected string $token2 = '';

    protected string $token3 = '';

    public function __construct($insecure = false)
    {
        $this->apiKey = config('sms.drivers.'.$this->drive.'.api_key');
        $this->sender = config('sms.drivers.'.$this->drive.'.from');
        $this->insecure = $insecure;

        if (!extension_loaded('curl')) {
            throw new BaseRuntimeException('cURL library is not loaded', 500);
        }
        if (is_null($this->apiKey)) {
            throw new ApiException('apiKey is empty');
        }
    }

    protected function get_path($method, $base = 'sms'): string
    {
        return sprintf(self::APIPATH, $this->insecure == true ? "http" : "https", $this->apiKey, $base, $method);
    }

    protected function execute($url, $data = null)
    {
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'charset: utf-8'
        );

        $fields_string = "";
        if (!is_null($data)) {
            $fields_string = http_build_query($data);
        }
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);

        $response = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        $curl_errno = curl_errno($handle);
        $curl_error = curl_error($handle);
        if ($curl_errno) {
            throw new HttpException($curl_error, $curl_errno);
        }
        $json_response = json_decode($response);
        if ($code != 200 && is_null($json_response)) {
            throw new HttpException("Request have errors", $code);
        } else {
            $json_return = $json_response->return;
            if ($json_return->status != 200) {
                throw new ApiException($json_return->message, $json_return->status);
            }
            return [
                'status' => $code
            ];
        }

    }

    public function send()
    {
        if ($this->method == 'pattern')
            $res = $this->sendPattern();
        else
            $res = $this->message($this->text);
        return $res;
    }

    public function text($text)
    {
        $this->text = $text;

        return $this;
    }

    public function pattern($pattern_code = null)
    {
        $this->method = 'pattern';
        if ($pattern_code)
            $this->pattern_code = $pattern_code;
        return $this;
    }

    public function data(array $data)
    {
//      "token","token2","token3"
        $this->data = $data;

        return $this;
    }

    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    public function to(array $numbers)
    {
        $this->numbers = $numbers;

        return $this;
    }

    public function sendPattern()
    {
        $path = $this->get_path("lookup", "verify");
        $receptor = $this->numbers;
        if (is_array($receptor)) {
            $receptor = implode(",", $receptor);
        }
        $params = array(
            "receptor" => $receptor,
            "template" => $this->pattern_code,
        );
        $data = array_values($this->data);
        $tokens = [];

        for ($i = 1; $i <= 3; $i++) {

            if (isset($data[$i - 1])) {
                if (str_contains($data[$i - 1]," ")){
                    $tokens['token20'] = $data[$i - 1];
                }
                if (!str_contains($data[$i - 1]," ")){
                    $tokens['token' . ($i == 1 ? '' : $i)] = $data[$i - 1];
                }
            }
        }

        $params = array_merge($params, $tokens);

        return $this->execute($path, $params);
    }

    public function message($text)
    {
        $receptor = $this->numbers;
        if (is_array($receptor)) {
            $receptor = implode(",", $receptor);
        }
        $path = $this->get_path("send");
        $params = array(
            "receptor" => $receptor,
            "sender" => $this->sender,
            "message" => $text,
            "date" => '', #زمان ارسال پیام
            "type" => 'sms',
        );
        return $this->execute($path, $params);
    }
}
