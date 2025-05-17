<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\Sms\SendSms;

class ForgotPasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function forget_password(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^(?:(?:(?:\\+?|00)(98))|(0))?((?:90|91|92|93|99)[0-9]{8})$/', 'exists:users,mobile']
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }

        $timer = 120;
        $request->mobile = (int)$request->mobile;
        $last = DB::table('verifies')->where('mobile', $request->mobile)->where('type', 'forget_password')->latest()->first();


        if (!is_null($last)) {
            $diff = Carbon::make(Carbon::now())->diffInSeconds($last->created_at);

            if ($diff <= $timer) {
                $timer = $timer - $diff;
            }

        }

        if ($timer == 120) {
            // verifies
            $code = mt_rand(11111, 99999);
            DB::table('verifies')->insert([
                'mobile' => $request->mobile,
                'code' => $code,
                'type' => 'forget_password',
                'created_at' => Carbon::now()
            ]);

            // send sms verify
            $sms = new SendSms();
            $send = $sms->send($request->mobile, ['code' => $code], config('smsir.templates.forget_password'));


            if (!$send) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در ارسال پیامک لطفا در فرصتی دیگر امتحان کنید'
                ], 400);
            }
        }
        $mobile = $request->mobile;

        return response()->json([
            'success' => true,
            'view' => view('components.auth.forget_password', compact('mobile'))->render(),
            'timer' => $timer,
            'mobile' => $request->mobile,
            'message' => 'ok'
        ]);
    }

    public function confirm(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^(?:(?:(?:\\+?|00)(98))|(0))?((?:90|91|92|93|99)[0-9]{8})$/', 'exists:users,mobile'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'code' => ['required', 'string', 'min:5'],
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }


        $last = DB::table('verifies')->where('mobile', $request->mobile)->where('type', 'forget_password')->where('code', $request->code)->first();

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


        $user = \App\Models\User::where('mobile', $request->mobile)->first();

        if (is_null($user)) {
            return response()->json([
                'success' => false,
                'message' => 'شماره موبایل در سیستم یافت نشد'
            ], 400);
        }

        try {

            $user->password = Hash::make($request->password);
            $user->save();

            Auth::loginUsingId($user->id);

            return response()->json([
                'success' => true,
                'message' => 'ok'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'خطا لطفا در فرصتی دیگر امتحان کنید'
            ], 400);

        }


    }

}
