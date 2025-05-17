<?php

namespace App\Traits;

use App\Jobs\InvoiceFactor;
use App\Models\Invoice;
use App\Models\Plan;
use App\Services\Sms\SendSms;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


trait Mellat
{

    protected $terminal_id;
    public $user_name;
    public $password;
    public $local_date;
    public $local_time;
    public $call_back_url;
    public $payerId;

    public function construct()
    {

        $this->terminal_id = 7524367;
        $this->user_name = 7524367;
        $this->password = 73116845;
        $this->call_back_url = url('mellat/verify');
        $this->local_date = date('Ymd');
        $this->local_time = date('Gis');
        $this->payerId = 0;

    }

    public function SendRequest($order_id, $amount, $text, $user)
    {
        $this->construct();

        $params = [
            'terminalId' => $this->terminal_id,
            'userName' => $this->user_name,
            'userPassword' => $this->password,
            'orderId' => $order_id,
            'amount' => $amount * 10,
            'localDate' => $this->local_date,
            'localTime' => $this->local_time,
            'additionalData' => null,
            'callBackUrl' => url('invoice-factor'),
            'payerId' => $this->payerId,
        ];

        $call = new \SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');

        $namespace = 'http://interfaces.core.sw.bps.com/';


        $result = $call->bpPayRequest($params, $namespace);


        $response = explode(',', $result->return);

        $ResCode = $response[0];


        if ($ResCode == "0") {

            $item = new Invoice();

            try {

                $item->user_id = $user->id;
                $item->status = 0;
                $item->order_id = $order_id;
                $item->amount = $amount * 10;
                $item->ref_id = $response[1];
                $item->description = $text;
                $item->save();

            } catch (\Exception $e) {

                Log::error($e->getMessage());

                // server error
                return [
                    'Success' => false,
                    'RefId' => null,
                    'StatusCode' => -1
                ];

            }


            // success
            return [
                'Success' => true,
                'RefId' => $response[1]
            ];

        } else {

            Log::error('mellat error with status code : ' . $result->return);

            // api error
            return [
                'Success' => false,
                'RefId' => null,
                'StatusCode' => $result->return
            ];

        }


    }


    public function VerifyInvoice($verify, $sale_reference_id, $card_holder_pan)
    {
        $this->construct();

        $params = [
            'terminalId' => $this->terminal_id,
            'userName' => $this->user_name,
            'userPassword' => $this->password,
            'orderId' => $verify->order_id,
            'saleOrderId' => $verify->order_id,
            'saleReferenceId' => $sale_reference_id
        ];


        $call = new \SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');

        $namespace = 'http://interfaces.core.sw.bps.com/';


        $result = $call->bpVerifyRequest($params, $namespace);

        $resultStr = $result->return;

        $result = @explode(',', $resultStr);

        if ((int)$result[0] == 0) {

            $result = $call->bpSettleRequest($params, $namespace);

            $resultStr = $result->return;

            $result = @explode(',', $resultStr);

            // payment success
            if ((int)$result[0] == 0) {

                // invoice set payment
                $verify->status = 1;
                $verify->sale_reference_id = $sale_reference_id;
                $verify->card_number = $card_holder_pan;
                $verify->save();


                $plan = Plan::where('title', $verify->description)->first();
                $user = $verify->user;

                $carbon = Carbon::make($user->vip_expire_at);
                $now = Carbon::now();

                if ($carbon < $now) {
                    $carbon = $now;
                }
                $carbon->addDays($plan->period_payment_day);

                $user->vip_account = 1;
                $user->vip_expire_at = $carbon;
                $user->expired = false;
                $user->save();


                // send sms verify
                $sms = new SendSms();
                $sms->send($user->mobile, ['plan' => $verify->description], config('smsir.templates.buy_plan'));


                return [
                    'Payment' => true,
                    'StatusCode' => $result[0],
                    'Message' => 'پرداخت با موفقیت انجام شد.'
                ];

            }

        }


        // invoice not payment ****** return amount

        $verify->status = -1;
        $verify->sale_reference_id = $sale_reference_id;
        $verify->save();

        $call->bpReversalRequest($params, $namespace);

        Log::warning('verify mellat payment with :' . 'invoice : ' . $verify->id . 'StatusCode : ' . $result[0] . 'canceled');

        return [
            'Payment' => false,
            'StatusCode' => $result[0],
            'Message' => 'پرداخت ناموفق - در صورت کسر مبلغ از حساب شما مبلغ پرداخت شده حداکثر طی 72 ساعت به حساب شما عودت خواهد شد.'
        ];


    }

}
