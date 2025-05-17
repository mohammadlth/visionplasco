<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\Sms\SendSms;

class RegisterController extends Controller
{

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function create(Request $request)
    {

        if (isset($request->modal)) {

            $validation = Validator::make($request->all(), [
                'code' => ['required', 'string', 'min:5'],
                'mobile' => ['required', 'string', 'max:255', 'regex:/^(?:(?:(?:\\+?|00)(98))|(0))?((?:90|91|92|93|99)[0-9]{8})$/', 'unique:users']
            ]);
        } else {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'type' => ['required', 'string', 'in:buyer,seller'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'code' => ['required', 'string', 'min:5'],
                'mobile' => ['required', 'string', 'max:255', 'regex:/^(?:(?:(?:\\+?|00)(98))|(0))?((?:90|91|92|93|99)[0-9]{8})$/', 'unique:users']

            ]);
        }


        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }

        $last = DB::table('verifies')->whereIn('mobile', [$request->mobile, (int)$request->mobile])->where('type', 'register')->where('code', $request->code)->first();

        if (is_null($last)) {
            return response()->json([
                'success' => false,
                'message' => 'کد ارسالی اشتباه است'
            ], 400);
        }

        $diff = Carbon::make(Carbon::now())->diffInSeconds($last->created_at);
        if ($diff > 800) {
            return response()->json([
                'success' => false,
                'message' => 'زمان احراز هویت پایان یافته است'
            ], 400);
        }


        $expire_vip = Setting::where('key', 'expire_day')->first();

        try {

            if (isset($request->modal)) {

                $password = mt_rand(111111, 999999);

                $user = User::create([
                    'name' => 'کاربر ' . 100 + User::count(),
                    'mobile' => (int)$request->mobile,
                    'account' => $request->type,
                    'vip_expire_at' => Carbon::now()->addDays((int)$expire_vip->value)->endOfDay(),
                    'password' => Hash::make($password),
                ]);


                $sms = new SendSms();
                $sms->send($request->mobile, ['mobile' => $request->mobile, 'password' => $password], config('smsir.templates.password_user'));

                $view = view('components.modal.site')->render();

            } else {

                $user = new User();
                $user->name = $request->name;
                $user->mobile = $request->mobile;
                $user->account = $request->type;
                $user->password = Hash::make($request->password);
                $user->vip_expire_at = Carbon::now()->addDays((int)$expire_vip->value)->endOfDay();
                $user->save();

                $view = null;
            }


            Auth::loginUsingId($user->id);

            return response()->json([
                'success' => true,
                'view' => $view,
                'message' => 'ثبت نام با موفقیت انجام شد'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'خطا در ثبت اطلاعات لطفا با پشتیبانی تماس حاصل فرمایید'
            ], 400);

        }


    }
}
