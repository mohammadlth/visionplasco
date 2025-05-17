<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Product;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    use Upload;

    public function index(Request $request)
    {

        $items = Setting::orderBy('created_at', 'desc')->paginate(20);
        return view('dashboard.setting.index', compact('items'));

    }

    public function edit($id, Request $request)
    {

        $item = Setting::find($id);
        $prev_url = $request->page;

        if (is_null($item)) {
            abort(404);
        }

        return view('dashboard.setting.edit', compact('item', 'prev_url'));
    }

    public function update(Request $request, $id)
    {

        $item = Setting::find($id);

        if (is_null($item)) {
            abort(404);
        }

        try {

            if ($item->key == 'site_view') {
                $item->value = $request->view;
            }

            if ($item->key == 'expire_day') {
                $item->value = $request->day;
            }
            if ($item->key == 'about_us') {
                $item->value = $request->about_us;
            }
            if ($item->key == 'terms') {
                $item->value = $request->terms;
            }
            if ($item->key == 'phones') {
                $item->value = $request->phones;
            }
            if ($item->key == 'email') {
                $item->value = $request->email;
            }
            if ($item->key == 'address') {
                $item->value = $request->address;
            }
            if ($item->key == 'map') {
                $item->value = $request->map;
            }
            if ($item->key == 'footer_text') {
                $item->value = $request->footer_text;
            }
            if ($item->key == 'whatsapp') {
                $item->value = $request->whatsapp;
            }
            if ($item->key == 'telegram') {
                $item->value = $request->telegram;
            }
            if ($item->key == 'instagram') {
                $item->value = $request->instagram;
            }
            if ($item->key == 'twitter') {
                $item->value = $request->twitter;
            }

            $item->save();

            return redirect()->route('settings.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ویرایش شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }


    public function destroy($id)
    {
        $item = Banner::find($id);

        $item->delete();

        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');


    }
}
