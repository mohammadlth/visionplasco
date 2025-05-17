<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use App\Services\Sms\SendSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

class PortalController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->count();
        $requests = \App\Models\Request::where('status', 'confirm')->count();
        $chats = Chat::where('contact_id', Auth::id())->orderBy('created_at', 'desc')->take(4)->get();
        $requests_items = \App\Models\Request::where('status', 'confirm')->orderBy('created_at', 'desc')->take(4)->get();
        $requests_user = \App\Models\Request::where('user_id', Auth::id())->get();
        return view('portal.index', compact('products', 'requests', 'chats', 'requests_items', 'requests_user'));

    }

    public function change_level($type)
    {
        $access_item = ['buyer', 'seller'];

        if (!in_array($type, $access_item)) {
            return redirect()->back()->with('error_message', 'نوع حساب نامغتبر است');
        }

        try {

            $user = Auth::user();
            $user->account = $type;
            $user->save();

            return redirect()->back();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد لطفا در فرصتی دیگر امتحان کنید');
        }
    }

    public function category_detail(Request $request)
    {
        $category = Category::where('id', $request->id)->first();

        if (!is_null($category)) {

            $data = [
                'title' => $category->title,
                'placeholder' => $category->placeholder,
                'unit' => $category->unit,
            ];
            return response()->json([
                'success' => true,
                'message' => 'ok',
                'data' => $data
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Nok',
                'data' => []
            ]);
        }

    }

    public function upload(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'image' => 'required|max:10000|mimes:jpg,jpeg,JPG,JPEG,png,PNG'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ]);
        }

        $image = 'photos' . '/' . $request->image->store('products', 'public');

        return response()->json([
            'success' => true,
            'image' => $image
        ]);
    }

    public function phone_view(Request $request)
    {
        $contact_id = $request->contact_id;

        $user = User::where('id', $contact_id)->first();

        if (is_null($user)) {
            return response()->json([
                'success' => false,
                'message' => 'کاربر با این مشخصات یافت نشد'
            ]);
        }

        if ($user->ban) {
            return response()->json([
                'success' => false,
                'message' => 'امکان برقراری ارتباط با کاربر وجود ندارد'
            ]);
        }

        if ($user->info->show_phone_number == 0) {
            return response()->json([
                'success' => false,
                'message' => 'امکان برقراری ارتباط با کاربر وجود ندارد'
            ]);
        }


        DB::table('phone_views')->insert([
            'user_id' => Auth::id(),
            'contact_id' => $contact_id,
            'created_at' => Carbon::now()
        ]);

        $sms = new SendSms();
        $sms->send($user->mobile, ['mobile' => Auth::user()->mobile], config('smsir.templates.call_saller'));


        return response()->json([
            'success' => true,
            'mobile' => $user->mobile,
            'message' => 'ok'
        ]);

    }
}
