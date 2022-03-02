<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class SmsAPIHelper {

    private $hostUrl;
    private $senderID;

    const ORDER_PLACED = "order_placed";
    const ORDER_DELIVERED = "order_delivered";



    function __construct()
    {
        $this->apikey   = config('sms.sms_alert.key');
        $this->senderID = "STORIA";
        $this->hostUrl = "https://www.smsalert.co.in/api/";

    }

    public function send($mobileNo , $type, array $data)
    {
        $endpoint = "push.json";

        $this->setTemplate($type, $data);

        $response = Http::post($this->hostUrl . $endpoint, $this->payload($mobileNo) );

        if( ! $response->successful() ) {
            info('SMS ==> SMS not sent to ' . $mobileNo );

        }

        // dd($response->body());
    }

    public function setTemplate( $type, $data) : void
    {

        $template = config('sms.sms_alert.template.'. $type);

        if( ! $template ) {
            info('SMS ==> template not found');
            throw new \Exception('template not found');
        }

        foreach($data as $key => $value) {
            $data['['.$key.']'] = $value;
            unset($data[$key]);
        }

        $this->compiledTemplate = strtr($template, $data);

        // dd($this->compiledTemplate);
    }

    private function payload( $mobile)
    {
        return [
            'apikey' => $this->apikey,
            'sender' => $this->senderID,
            'mobileno' => $mobile,
            'text'   => $this->compiledTemplate
        ];
    }

}
