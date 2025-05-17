<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\Sms\SendSms;

class LoginController extends Controller
{

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function exist(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^(?:(?:(?:\\+?|00)(98))|(0))?((?:90|91|92|93|99)[0-9]{8})$/']
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }

        $mobile = (int)$request->mobile;

        $user = User::where('mobile', $request->mobile)->first();

        if (isset($request->modal)) {
            $view = view('components.modal.login', compact('mobile'))->render();
        } else {
            $view = view('components.auth.login', compact('mobile'))->render();
        }

        if (!is_null($user)) {
            return response()->json([
                'success' => true,
                'exist' => true,
                'view' => $view,
                'message' => 'ok'
            ]);
        }


        $timer = 120;

        $last = DB::table('verifies')->where('mobile', $request->mobile)->where('type', 'register')->latest()->first();


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
                'type' => 'register',
                'created_at' => Carbon::now()
            ]);

            // send sms verify
            $sms = new SendSms();
            $send = $sms->send($request->mobile, ['code' => $code], config('smsir.templates.register'));
            if (!$send) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در ارسال پیامک لطفا در فرصتی دیگر امتحان کنید'
                ], 400);
            }
        }


        if (isset($request->modal)) {
            $view = view('components.modal.verify', compact('mobile'))->render();
        } else {
            $view = view('components.auth.register', compact('mobile'))->render();
        }

        return response()->json([
            'success' => true,
            'exist' => false,
            'view' => $view,
            'timer' => $timer,
            'mobile' => $request->mobile,
            'message' => 'ok'
        ]);

    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^(?:(?:(?:\\+?|00)(98))|(0))?((?:90|91|92|93|99)[0-9]{8})$/'],
            'password' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }

        $credentials = $request->only('mobile', 'password');

        if (Auth::attempt($credentials)) {
            Auth::login(Auth::user());

            if (isset($request->modal)) {
                $view = view('components.modal.site')->render();
            } else {
                $view = null;
            }

            $sms = new SendSms();
            $sms->send(Auth::user()->mobile, ['ip' => $request->ip(), 'time' => verta()->format('Y/m/d H:i:s')], config('smsir.templates.login_log'));


            return response()->json([
                'success' => true,
                'view' => $view,
                'message' => 'ok'
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'رمز عبور اشتباه است'
            ], 400);
        }
    }


}
