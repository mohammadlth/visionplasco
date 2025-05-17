<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invoice;
use App\Models\Balance;
use Illuminate\Http\Request;
use App\Services\Zarinpal\Bank;
use App\Services\Sms\SendSms;


class InvoiceController extends Controller
{
    public function callback(Request $request)
    {

        $invoice = Invoice::where('ref_id', $request->Authority)->first();

        if (is_null($invoice)) {
            return redirect()->route('wallet')->with('error_message', 'صورت حسابی با این مشخصات یافت نشد');
        }

        if (strtoupper($request->Status) == 'NOK') {
            return redirect()->route('wallet')->with('error_message', 'تراکنش لغو شد');
        }


        try {

            $bank = new Bank();
            $req = $bank->VerifyInvoice($request->Authority, $invoice->amount);

            if ($req['success']) {

                // status
                $invoice->status = 1;
                $invoice->ref_id_bank = $req['ref_id_bank'];
                $invoice->card_pan = $req['card_pan'];
                $invoice->save();

                // balance
                $balance = Balance::where('user_id', $invoice->user_id)->first();
                $balance->balance = $balance->balance + $invoice->amount;
                $balance->save();


                if ($invoice->user) {

                    //sms
                    $sms = new SendSms();
                    $sms->send($invoice->user->mobile, ['price' => number_format($invoice->amount)], config('smsir.templates.invoice_payment'));

                }

                return redirect()->route('pay', $invoice->number);


            } else {
                return redirect()->route('wallet')->with('error_message', $req['message']);
            }

        } catch (Exception $e) {

        }

    }


}
