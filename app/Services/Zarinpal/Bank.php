<?php

namespace App\Services\Zarinpal;

use App\Jobs\InvoiceFactor;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;


class Bank
{

    protected $terminal_id;
    public $user_name;
    public $password;
    public $payerId;

    public function __construct()
    {
        $this->terminal_id = '820f8708-3338-44d9-ad08-8d5488c56572';
        $this->call_back_url = 'https://zagrin.ir/invoice-payment';
        $this->local_date = date('Ymd');
        $this->local_time = date('Gis');
        $this->payerId = 0;

    }

    public function SendRequest(Invoice $order, $amount)
    {

        $data = array("merchant_id" => $this->terminal_id,
            "amount" => $amount * 10,
            "callback_url" => $this->call_back_url,
            "description" => 'پرداخت از سایت',
            "metadata" => [],
        );
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($ch);


        if ($err) {

            return [
                'Success' => false,
                'Status' => null,
                'StatusCode' => $err
            ];

        } else {

            if (empty($result['errors'])) {


                if ($result['data']['code'] == 100) {


                    try {
                        $order->ref_id = $result['data']["authority"];
                        $order->save();

                        return [
                            'Success' => true,
                            'RefId' => 'https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"]
                        ];

                    } catch (\Exception $e) {
                        return [
                            'Success' => false,
                            'RefId' => 'خطا در ارتباط با درگاه بانک'
                        ];
                    }


                }

            } else {


                Log::error('zarinpal error with status code : ' . $result->return);

                return [
                    'Success' => false,
                    'Status' => $result['errors']['code'],
                    'StatusCode' => $result['errors']['message']
                ];

            }
        }

    }


    public function VerifyInvoice($authority, $amount)
    {

        $data = array("merchant_id" => "820f8708-3338-44d9-ad08-8d5488c56572", "authority" => $authority, "amount" => $amount * 10);
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, true);


        if ($err) {

            return [
                'success' => false,
                'message' => 'پرداخت انجام نشد'
            ];
        } else {

            if (!isset($result['data']['code'])) {


                return [
                    'success' => false,
                    'message' => 'پرداخت با شکست مواجه شد در صورت کسر مبلغ از حساب شما حداکثر تا 24 ساعت مبلغ به حساب شما عودت می شود'
                ];


            }


            if ($result['data']['code'] == 100) {
                return [
                    'success' => true,
                    'card_pan' => $result['data']['card_pan'],
                    'ref_id_bank' => $result['data']['ref_id'],
                    'message' => 'ok'
                ];


            } else {

                return [
                    'success' => false,
                    'message' => 'پرداخت با شکست مواجه شد در صورت کسر مبلغ از حساب شما حداکثر تا 24 ساعت مبلغ به حساب شما عودت می شود'
                ];

            }

        }
    }

}
