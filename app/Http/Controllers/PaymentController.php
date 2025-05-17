<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Invoice;
use App\Jobs\InvoiceFactor;
use App\Repositories\PaymentOnline;
use App\Traits\Mellat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    use Mellat;

    public function call($price, $text, $user)
    {
        return $this->SendRequest($this->order_id(), $price, $text, $user);
    }

    public function verify(Request $request)
    {

        // check params
        if (!isset($request['RefId']) || !isset($request['ResCode'])) {
            abort(403);
        }

        //params
        $res_code = (int)$request['ResCode'];
        $ref_id = $request['RefId'];
        $order_id = $request['SaleOrderId'];
        $card_holder_pan = $request['CardHolderPan'];

        if (isset($request['SaleReferenceId']) && !is_null($request['SaleReferenceId'])) {
            $sale_reference_id = $request['SaleReferenceId'];
        } else {
            $sale_reference_id = null;
        }

        // invoice payment
        $verify = Invoice::where('ref_id', $ref_id)->where('status', 0)->first();

        if (is_null($verify)) {
            abort(503);
        }

        // check payment
        if ($res_code == 0) {

            if (is_null($sale_reference_id)) {
                abort(403);
            }

            // check payment
            $response = $this->VerifyInvoice($verify, $sale_reference_id, $card_holder_pan);

            if ($response['Payment']) {

                //**** SUCCESS PAYMENT *****//
                return redirect()->route('portal.plan', ['id' => $verify->id])->with('payment_success', $response['Message'] . '#' . $response['StatusCode']);

            } else {

                Log::info('mellat payment callback status code : ' . $response['StatusCode']);
                return redirect()->route('portal.plan', ['id' => $verify->id])->with('payment_error', $response['Message'] . '#' . $response['StatusCode']);

            }

        } else {


            Log::info('mellat payment callback status code : ' . $res_code);

            // invoice not payment
            $verify->status = -1;
            $verify->sale_reference_id = $sale_reference_id;
            $verify->save();

            return redirect()->route('portal.plan', ['id' => $verify->id])->with('payment_error', 'پرداخت انجام نشد.' . '#' . $res_code);
        }


    }

    public function order_id()
    {

        $code = date('hismd');
        $code .= mt_rand(111, 999);

        $exist = Invoice::where('order_id', $code)->count();

        if ($exist == 0) {
            return $code;
        }

        $this->order_id();

    }

}
