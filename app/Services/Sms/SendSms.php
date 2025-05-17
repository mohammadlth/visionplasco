<?php

namespace App\Services\Sms;

use Cryptommer\Smsir\Smsir;
use Illuminate\Support\Facades\Log;

class SendSms
{
    public function send($mobile, $params, $template)
    {
        $parameters = [];

        foreach ($params as $key => $value) {
            array_push($parameters, new \Cryptommer\Smsir\Objects\Parameters($key, $value));
        }

        $send = smsir::Send();
        $sms = $send->Verify($mobile, $template, $parameters)->getStatus();


        if ((int)$sms != 1) {
            Log::info($sms);
            return false;
        } else {
            return true;
        }
    }


}
