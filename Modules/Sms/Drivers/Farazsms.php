<?php


namespace Modules\Sms\Drivers;


use Illuminate\Support\Facades\Log;
use Modules\Sms\Exceptions\ApiException;
use Modules\Sms\Exceptions\HttpException;
use Modules\Sms\SmsInterface;

class Farazsms implements SmsInterface
{
    protected $drive = 'farazsms';

    protected $method;

    protected $username;

    protected $password;

    protected $from;

    protected $pattern_code;

    protected $to;

    protected $input_data;

    protected $url;

    protected $numbers;

    protected $data;

    protected $text;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected mixed $urlNormal;

    /**
     * farazsms constructor.
     */
    public function __construct()
    {
        $this->username = config('sms.drivers.'.$this->drive.'.username');
        $this->password = config('sms.drivers.'.$this->drive.'.password');
        $this->from     = config('sms.drivers.'.$this->drive.'.from');
        $this->url      = config('sms.drivers.'.$this->drive.'.urlPattern');
        $this->urlNormal = config('sms.drivers.'.$this->drive.'.urlNormal');
    }

    /**
     * @return bool|mixed|string
     */
    public function send()
    {
        if ($this->method == 'pattern')
            $res = $this->sendPattern();
        else
            $res = $this->message($this->text);
        return $res;
    }

    /**
     * @param $text
     * @return $this|mixed
     */
    public function text($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param null $pattern_code
     * @return $this|mixed
     */
    public function pattern($pattern_code = null)
    {
        $this->method = 'pattern';
        if ($pattern_code)
            $this->pattern_code = $pattern_code;
        return $this;
    }

    /**
     * @param array $data
     * @return $this|mixed
     */
    public function data(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param $from
     * @return $this|mixed
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param array $numbers
     * @return $this|mixed
     */
    public function to(array $numbers)
    {
        $this->numbers = $numbers;

        return $this;
    }

    public function execute($url, $data)
    {
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($handler, CURLOPT_HEADER  , true);  // we want headers
//        curl_setopt($handler, CURLOPT_NOBODY  , true);  // we don't need body
        $response = curl_exec($handler);
        $httpCode = curl_getinfo($handler, CURLINFO_HTTP_CODE);

        $curl_errno = curl_errno($handler);
        $curl_error = curl_error($handler);
        if ($curl_errno) {
            throw new HttpException($curl_error, $curl_errno);
        }

        if ($httpCode != 200 && is_null($response)) {
            throw new HttpException("Request have errors", $httpCode);
        }

        return ['response' => $response, 'http_code' => $httpCode];
    }

    /**
     * @return bool|mixed|string
     */
    public function sendPattern()
    {
        $numbers       = $this->numbers;
        $pattern_code  = $this->pattern_code;
        $username      = $this->username;
        $password      = $this->password;
        $from          = $this->from;
        $to            = $numbers;
        $input_data    = $this->data;
        $url = $this->url."?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";

        $response = $this->execute($url, $input_data);

        return [
            'status' => $response['http_code']
        ];
    }

    /**
     * @param $text
     * @return mixed
     */
    public function message($text)
    {

        $this->url   = config('sms.drivers.'.$this->drive.'.urlNormal');

        $rcpt_nm = $this->numbers;
        $param = array
        (
            'uname'=> $this->username ,
            'pass'=> $this->password,
            'from'=>$this->from,
            'message'=>$text,
            'to'=>json_encode($rcpt_nm),
            'op'=>'send'
        );

        $response = $this->execute($this->url, $param);

        return [
            'status' => $response['http_code']
        ];
    }

    public function credit(): int
    {
        $data = [
            'uname'=> $this->username ,
            'pass'=> $this->password,
            'op'=>'credit'
        ];
        $response = $this->execute($this->urlNormal, $data);

        return (int)floor((json_decode($response['response']))[1]);
    }
}
