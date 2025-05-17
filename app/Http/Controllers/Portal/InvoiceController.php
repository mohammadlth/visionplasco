<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Website;
use App\Models\Plan;
use App\Models\Balance;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\Zarinpal\Bank;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Transaction::where('user_id', Auth::id())->orderBy('created_at' , 'desc')->paginate(15);
        return view('panel.invoice.index', compact('invoices'));
    }

    public function payment_invoice($id)
    {

        $invoice = Transaction::where('user_id', Auth::id())->where('id', $id)->first();

        if (is_null($invoice)) {
            abort(403);
        }

        if ($invoice->status != 0) {
            return redirect()->back()->with('error_message', 'کاربر گرامی این فاکتور پرداخت شده یا منقضی شده است');
        }

        $user = Auth::user();
        $balance = Balance::where('user_id', $user->id)->where('ban', 0)->first();

        if (is_null($balance)) {
            return redirect()->back()->with('error_message', 'دارایی یافت نشد');
        }

        if ($balance->balance < $invoice->amount) {
            return redirect()->back()->with('error_message', 'موجودی شارژ حساب کافی نیست');
        }

        try {

            $balance->balance = $balance->balance - $invoice->amount;
            $balance->save();

            $invoice->status = 1;
            $invoice->save();

            return redirect()->back()->with('success_message', 'صورت حساب با موفقیت پرداخت شد');

        } catch (\Exception $e) {

            return redirect()->back()->with('error_message', ' خطایی رخ داد لطفا با پشتیبانی در ارتباط باشید ');

        }


    }

    public function payment(Request $request)
    {
        Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'min:50000'],
        ])->validate();

        try {
            $item = new Invoice();
            $item->user_id = Auth::id();
            $item->amount = $request->amount;
            $item->number = $this->number();
            $item->status = 0;
            $item->description = 'شارژ حساب';
            $item->save();

            $bank = new Bank();
            $req = $bank->SendRequest($item, $item->amount);

            if ($req['Success']) {
                return redirect()->to($req['RefId']);
            } else {
                return redirect()->back()->with('error_message', 'خطا در ارتباط  با درگاه بانک لطفا در فرصتی دیگر امتحان کنید');
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد لطفا در فرصتی دیگر امتحان کنید');
        }


    }

    public function number()
    {
        $code = mt_rand(111111, 999999);
        $exist = Invoice::where('number', $code)->count();

        if ($exist > 0) {
            $this->number();
        }

        return $code;

    }


}
