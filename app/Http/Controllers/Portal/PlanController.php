<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Invoice;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Mellat;

class PlanController extends Controller
{

    use Mellat;


    public function index(Request $request)
    {
        $setting = Setting::where('key', 'plan_offer')->first();

        $leftTimer = 0;

        if (!is_null($setting->value)) {
            $data = json_decode($setting->value);
            $leftTimer = Carbon::now()->diffInSeconds(Carbon::make($data->date));
        }

        $expire = 0;

        if (!is_null($request->expire) && $request->expire == 1) {
            $expire = 1;
        }

        $invoice = null;
        if ($request->id) {

            $invoice = Invoice::where('id', $request->id)->where('user_id', Auth::id())->first();

            if (is_null($invoice)) {
                var_dump('access error');
            }

        }


        $plans = Plan::where('status', 1)->orderBy('sort', 'asc')->get();
        return view('portal.plan.index', compact('plans', 'setting', 'leftTimer', 'expire', 'invoice'));
    }


    public function payment(Request $request, $id)
    {
        $plan = Plan::where('id', $id)->where('status', 1)->orderBy('sort', 'asc')->first();

        if (is_null($plan)) {
            abort(404);
        }

        $bank = $this->SendRequest($this->order_id(), $plan->price_off > 0 ? $plan->price_off : $plan->price, $plan->title, Auth::user());

        $fast_redirect = true;

        return view('bank', compact('bank', 'plan', 'fast_redirect'));

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
