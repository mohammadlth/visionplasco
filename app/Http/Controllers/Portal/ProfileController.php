<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Identity;
use App\Models\Website;
use App\Services\Sms\SendSms;
use App\Traits\Upload;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

class ProfileController extends Controller
{
    use Upload;

    public function index()
    {

        $user = Auth::user();
        return view('portal.profile.info', compact('user'));

    }

    public function profile_update(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'numeric'],
            'account_type' => ['required', 'in:company,personal'],
        ])->validate();

        $user = Auth::user();
        $info = Auth::user()->info;

        try {
            $user->name = $request->name;
            $user->sex = $request->sex;
            $user->save();

            $info->account_type = $request->account_type;
            $info->company_name = $request->company_name;
            $info->company_number = $request->company_number;
            $info->company_phone = $request->company_phone;
            $info->company_address = $request->company_address;
            $info->save();

            return redirect()->back()->with('success_message', 'بروز رسانی اطلاعات با موفقیت انجام شد');

        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'خطا در ویرایش اطلاعات');

        }


    }

    public function profile_info(Request $request)
    {
        Validator::make($request->all(), [
            'address' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:800'],
        ])->validate();

        $info = Auth::user()->info;

        try {
            $info->description = $request->description;
            $info->address = $request->address;
            $info->save();

            return redirect()->back()->with('success_message', 'بروز رسانی اطلاعات با موفقیت انجام شد');

        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'خطا در ویرایش اطلاعات');

        }


    }

    public function update_pic(Request $request)
    {
        $user = Auth::user()->info;

        try {

            $user->profile_pic = $request->image;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'ok'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطایی رخ داد لطفا در فرصتس دیگر امتحان کنید'
            ]);
        }

    }

    public function update_mobile(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'mobile' => ['required', 'string', 'max:255', 'regex:/^(?:(?:(?:\\+?|00)(98))|(0))?((?:90|91|92|93|99)[0-9]{8})$/', 'unique:users,mobile']
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }


        $item = DB::table('verifies')->where('mobile', $request->mobile)->where('type', 'change_mobile')->orderBy('created_at', 'desc')->first();

        if (!is_null($item)) {
            $now = Carbon::now();
            $diff = $now->diffInSeconds(Carbon::make($item->created_at));

            if ($diff <= 120) {
                return response()->json([
                    'success' => false,
                    'message' => 'لطفا تا ارسال مجدد کد منتظر بمانید'
                ], 400);
            }

        }

        $code = mt_rand(11111, 99999);

        $sms = new SendSms();
        $send = $sms->send($request->mobile, ['code' => $code], config('smsir.templates.change_mobile'));

        if ($send) {
            DB::table('verifies')->insert([
                'mobile' => $request->mobile,
                'code' => $code,
                'type' => 'change_mobile',
                'created_at' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'کد تایید به شماره موبایل جدید شما ارسال شد'
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'خطا در ارسال پیامک لطفا در فرصتی دیگر امتحان'
            ], 400);
        }

    }

    public function mobile_visibility($show)
    {

        try {
            if ($show == 0) {
                DB::table('users_info')->where('user_id', Auth::id())->update([
                    'show_phone_number' => 0
                ]);
            }

            if ($show == 1) {
                DB::table('users_info')->where('user_id', Auth::id())->update([
                    'show_phone_number' => 1
                ]);
            }

            return redirect()->back()->with('success_message', 'بروز رسانی اطلاعات با موفقیت انجام شد');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'خطا در ویرایش اطلاعات');
        }
    }

    public function update_mobile_check(Request $request)
    {

        Validator::make($request->all(), [
            'mobile' => ['required', 'string', 'max:255', 'regex:/^(?:(?:(?:\\+?|00)(98))|(0))?((?:90|91|92|93|99)[0-9]{8})$/'],
            'code' => ['required', 'numeric'],
        ])->validate();

        $verify = DB::table('verifies')->where('mobile', $request->mobile)->where('code', $request->code)->first();

        if (is_null($verify)) {
            return redirect()->back()->with('error_message', 'اطلاعات مطابقت ندارد');
        }

        $diff = Carbon::now()->diffInSeconds(Carbon::make($verify->created_at));

        if ($diff > 600) {
            return redirect()->back()->with('error_message', 'زمان احراز هویت پایان یافته است');
        }


        try {

            $user = Auth::user();
            $user->mobile = $verify->mobile;
            $user->save();
            return redirect()->back()->with('success_message', 'شماره موبایل با موفقیت بروزرسانی شد');


        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'خطا در بروز رسانی اطلاعات');
        }


    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'min:4', 'max:255'],
            'sex' => ['required', 'numeric'],
            'email' => ['nullable', 'email', 'unique:email,users,' . Auth::id()],
            'password' => ['nullable', 'min:6'],
        ])->validate();

        if (!is_null($request->password)) {
            if ($request->password != $request->password_confirmation) {
                return redirect()->back()->with('error_message', 'تایید رمز عبور مطابقت ندارد');
            }
        }

        try {

            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->sex = (int)$request->sex;
            if (!is_null($request->password)) {
                $user->password = $request->password;
            }
            $user->save();

            return redirect()->back()->with('success_message', 'اطلاعات حساب شما بروز شد');

        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'خطایی رخ داد لطفا فیلد ها را بررسی کنید');
        }
    }

    public function profile_photo_delete($id)
    {
        $this->deleteFile($id, 'accounts');

        return redirect()->back();
    }

    public function profile_photo(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'image' => ['required', 'min:4', 'max:255'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }

        try {
            $this->upload($request->image, 'accounts', Auth::id(), false);

            return response()->json([
                'success' => true,
                'message' => 'ok'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'خطا در ثبت اطلاعات'
            ], 400);

        }

    }

    public function profile_certificate_delete($id)
    {
        $this->deleteFile($id, 'certificate');

        return redirect()->back();
    }

    public function profile_certificate(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'image' => ['required', 'min:4', 'max:255'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }

        try {
            $this->upload($request->image, 'certificate', Auth::id(), false);

            return response()->json([
                'success' => true,
                'message' => 'ok'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'خطا در ثبت اطلاعات'
            ], 400);

        }

    }

    public function verification()
    {

        $identity = Identity::where('user_id', Auth::id())->first();
        return view('portal.verification.index', compact('identity'));
    }

    public function verification_upload(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'image' => ['required', 'string', 'max:255']
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }

        $identity = Identity::where('user_id', Auth::id())->first();

        if (!is_null($identity)) {

            $identity->national_card = $request->image;
            $identity->status = 'waiting';
            $identity->save();

        } else {

            try {

                $item = new Identity();
                $item->user_id = Auth::id();
                $item->status = 'waiting';
                $item->national_card = $request->image;
                $item->save();

            } catch (Exception $e) {

                return response()->json([
                    'success' => false,
                    'message' => 'اطلاعات با موفقیت ثبت نشد لطفا در فرصتی دیگر امتحان کنید'
                ], 400);

            }

        }

        return response()->json([
            'success' => true,
            'message' => 'Ok'
        ]);


    }


}
