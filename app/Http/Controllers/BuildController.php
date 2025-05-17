<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Website;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Jobs\BuildSite;


class BuildController extends Controller
{
    public function step_2()
    {

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'لطفا ابتدا وارد سایت شوید یا ثبت نام کنید'
            ], 400);
        }

        $view = view('components.modal.site')->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'message' => 'ok'
        ]);
    }

    public function build(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'min:3', 'max:225'],
            'template_id' => ['required', 'numeric', 'exists:templates,id'],
            'subdomain' => ['required', 'min:3', 'max:10', 'regex:/^[a-zA-Z]+$/u', 'unique:websites,subdomain'],
        ]);


        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'لطفا ابتدا وارد سایت شوید یا ثبت نام کنید'
            ], 400);
        }


        $exist = Website::where('user_id', Auth::id())->where('trial', 1)->count();


        if ($exist > 0) {
            return response()->json([
                'success' => false,
                'message' => 'کاربر گرامی به دلیل هزینه نگهداری از سیستم،  ثبت وب سایت دمو بیش از یک اکانت پذیر نمیباشد '
            ], 400);
        }

        $template = Template::find($request->template_id);
        try {

            $password_panel = $this->randomPassword();
            $db_password = $this->randomPassword();

            $item = new Website();
            $item->title = $request->title;
            $item->subdomain = $request->subdomain;
            $item->url = 'http://' . $request->subdomain . '.3qq.ir';
            $item->user_id = Auth::id();
            $item->status = 0;
            $item->template_id = $request->template_id;
            $item->user_panel = Auth::user()->mobile;
            $item->password_panel = $password_panel;
            $item->db_name = 'qq_' . $request->subdomain;
            $item->db_password = $db_password;
            $item->expire_at = Carbon::now()->addDay($template->expire_day_trial);
            $item->save();

            BuildSite::dispatch($item)->onConnection('database');

            return response()->json([
                'success' => true,
                'view' => view('components.modal.build', compact('item'))->render(),
                'message' => 'ok',
                'timer' => mt_rand(180, 250),
                'website_id' => $item->id
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'view' => null,
                'message' => 'خطایی نامشخص لطفا در فرصتی دیگر امتحان کنید'
            ], 400);
        }

    }

    public function info(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'website_id' => ['required', 'numeric', 'exists:websites,id'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ], 400);
        }

        $website = Website::where('id', $request->website_id)->where('user_id', Auth::id())->first();


        if (is_null($website)) {
            return response()->json([
                'success' => false,
                'message' => 'وب سایتی یافت نشد'
            ], 400);
        }

        if ($website->confirm == 0) {
            return response()->json([
                'success' => false,
                'message' => 'با عرض پوزش ساخت سایت با مشکل مواجه شده است لطفا با پشتیبانی تماس حاصل فرمایید'
            ], 400);
        }


        return response()->json([
            'success' => true,
            'view' => view('components.modal.info', compact('website'))->render(),
            'message' => 'ok'
        ]);


    }

    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
