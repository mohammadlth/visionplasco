<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Info;
use App\Models\Product;
use App\Models\User;
use App\Models\Permission;
use App\Traits\Upload;
use Carbon\Carbon;
use Google\Service\ServiceControl\Auth;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Mockery\Exception;
use App\Services\Sms\SendSms;


class UserController extends Controller
{
    use Upload;

    public function index(Request $request)
    {
        if (isset($request->s) && !is_null($request->s)) {

            $users = User::where('mobile', 'LIKE', "%{$request->s}%")->orwhere('name', 'LIKE', "%{$request->s}%")->orwhere('email', 'LIKE', "%{$request->s}%")->orderBy('created_at', 'desc')->paginate(20);

        } else {
            $users = User::orderBy('created_at', 'desc')->paginate(20);

        }

        $params = $request->all();

        return view('dashboard.users.index', compact('users', 'params'));

    }


    public function user_vip(Request $request)
    {
        if (isset($request->s) && !is_null($request->s)) {

            $users = User::where('mobile', 'LIKE', "%{$request->s}%")->orwhere('name', 'LIKE', "%{$request->s}%")->orwhere('email', 'LIKE', "%{$request->s}%")->where('vip_account', 1)->orderBy('created_at', 'desc')->paginate(20);

        } else {
            $users = User::where('vip_account', 1)->orderBy('created_at', 'desc')->paginate(20);

        }

        $params = $request->all();

        return view('dashboard.users.vip', compact('users', 'params'));

    }

    public function edit($id, Request $request)
    {
        $user = User::find($id);
        $prev_url = $request->page;

        if (is_null($user)) {
            abort(404);
        }

        $permission = Permission::all();


        return view('dashboard.users.edit', compact('user', 'prev_url', 'permission'));
    }


    public function create(Request $request)
    {
        $permission = Permission::all();

        $prev_url = $request->page;
        return view('dashboard.users.create', compact('prev_url', 'permission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mobile' => 'required|unique:users,mobile',
            'name' => 'required|min:2|max:255|string',
        ]);

        $item = new User();

        if (!is_null($request->vip_expire_at)) {
            $expire = Verta::parse($request->vip_expire_at)->datetime();
            $expire = Carbon::make($expire)->endOfDay();
        } else {
            $expire = null;
        }


        try {

            $item->name = $request->name;
            $item->mobile = (int)$request->mobile;
            $item->email = $request->email;
            $item->sex = $request->sex;
            $item->account = $request->account;
            $item->ban = $request->ban;
            $item->is_admin = $request->is_admin;
            $item->confirm_identity = $request->confirm_identity;
            $item->vip_account = $request->vip_account;
            $item->admin_permission = $request->admin_permission;
            $item->expired = $request->expired;
            $item->vip_expire_at = $expire ? $expire : null;
            $item->password = Hash::make($request->password);
            $item->save();

            $sms = new SendSms();
            $sms->send($request->mobile, ['name' => $request->name], config('smsir.templates.welcome_message'));

            return redirect()->route('users.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ثبت شد');

        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');

        }


    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mobile' => 'required',
            'name' => 'required|min:2|max:255|string',
        ]);

        $item = User::find($id);

        if (is_null($item)) {
            abort(404);
        }

        if (!is_null($request->vip_expire_at)) {
            $expire = Verta::parse($request->vip_expire_at)->datetime();
            $expire = Carbon::make($expire)->endOfDay();
        } else {
            $expire = null;
        }

        try {
            $item->name = $request->name;
            $item->mobile = $request->mobile;
            $item->email = $request->email;
            $item->sex = $request->sex;
            $item->account = $request->account;
            $item->ban = $request->ban;
            $item->is_admin = $request->is_admin;
            $item->confirm_identity = $request->confirm_identity;
            $item->vip_account = $request->vip_account;
            $item->admin_permission = $request->admin_permission;
            $item->expired = $request->expired;
            $item->vip_expire_at = $expire ? $expire : null;
            if ($request->password) {
                $item->password = Hash::make($request->password);
            }
            $item->save();

            return redirect()->route('users.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ویرایش شد');


        } catch (\Exception $e) {

            dd($e);
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }

    public function user_info($id, Request $request)
    {
        $user = User::find($id);
        $prev_url = $request->page;

        if (is_null($user) || is_null($user->info)) {
            abort(404);
        }

        $info = $user->info;

        return view('dashboard.users.info', compact('user', 'prev_url', 'info'));
    }


    public function user_info_update($id, Request $request)
    {
        $info = Info::find($id);
        if (is_null($info)) {
            abort(404);
        }

        try {

            $info->account_type = $request->account_type;
            $info->company_name = $request->company_name;
            $info->company_phone = $request->company_phone;
            $info->company_address = $request->company_address;
            $info->company_number = $request->company_number;
            $info->show_phone_number = $request->show_phone_number;
            $info->address = $request->address;
            $info->description = $request->description;
            $info->score = $request->score;
            $info->comments = $request->comments;
            if (file_exists($request->profile_pic)) {
                $upload = $this->upload($request->profile_pic, 'profiles');
                $info->profile_pic = $upload['File'];
            }
            $info->save();

            return redirect()->route('users.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ویرایش شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');

        }


    }

    public function destroy($id)
    {
        $user = User::find($id);

        Product::where('user_id', $id)->delete();
        \App\Models\Request::where('user_id', $id)->delete();
        Contact::where('user_id', $id)->orwhere('contact_id', $id)->delete();

        $user->delete();

        return redirect()->back()->with('success_message', 'اطلاعات کاربری با موفقیت حذف شد');


    }

    public function user_info_remove_pic($id)
    {
        $info = Info::find($id);

        if (is_null($info)) {
            abort(404);
        }

        try {

            $info->profile_pic = null;
            $info->save();
            return redirect()->back()->with('success_message', 'تصویر با موفقیت حذف شد');


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');

        }
    }

    public function user_login($id)
    {
        \Illuminate\Support\Facades\Auth::loginUsingId($id);

        return redirect()->route('panel');
    }


}
