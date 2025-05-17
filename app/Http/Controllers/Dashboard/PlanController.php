<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Setting;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlanController extends Controller
{

    public function index(Request $request)
    {

        $items = Plan::orderBy('created_at', 'desc')->paginate(20);
        $params = $request->all();

        $setting = Setting::where('key', 'plan_offer')->first();

        return view('dashboard.plan.index', compact('items', 'params', 'setting'));

    }

    public function create(Request $request)
    {
        $prev_url = $request->page;
        return view('dashboard.plan.create', compact('prev_url'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'sort' => 'required|numeric',
            'price' => 'required|numeric',
            'label' => 'required',
        ]);

        $item = new Plan();

        try {
            $item->title = $request->title;
            $item->label = $request->label;
            $item->sort = $request->sort;
            $item->status = $request->status;
            $item->price = $request->price;
            $item->price_off = $request->price_off;
            $item->period_payment_day = $request->period_payment_day;
            $item->vip = $request->vip;
            $item->color = $request->color;
            $item->feature = json_encode($request->feature);
            $item->save();

            return redirect()->route('plans.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ثبت شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }

    }

    public function edit($id, Request $request)
    {
        $item = Plan::find($id);
        $prev_url = $request->page;

        if (is_null($item)) {
            abort(404);
        }

        return view('dashboard.plan.edit', compact('item', 'prev_url'));
    }

    public function update($id, Request $request)
    {

        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'sort' => 'required|numeric',
            'price' => 'required|numeric',
            'label' => 'required',
        ]);

        $item = Plan::find($id);

        if (is_null($item)) {
            abort(404);
        }

        try {

            $item->title = $request->title;
            $item->label = $request->label;
            $item->sort = $request->sort;
            $item->status = $request->status;
            $item->price = $request->price;
            $item->price_off = $request->price_off;
            $item->period_payment_day = $request->period_payment_day;
            $item->vip = $request->vip;
            $item->color = $request->color;
            $item->feature = $request->feature;
            $item->save();

            return redirect()->route('plans.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ثبت شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }


    }

    public function destroy($id)
    {
        $item = Plan::find($id);

        $item->delete();

        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');

    }

    public function offer_store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'description' => 'required|string',
        ]);


        $expire = Verta::parse($request->date)->datetime();
        $expire = Carbon::make($expire)->endOfDay();

        $data = [
            'date' => $expire,
            'description' => $request->description,
        ];

        try {

            $item = Setting::where('key', 'plan_offer')->first();
            $item->value = json_encode($data);
            $item->save();
            return redirect()->back()->with('success_message', 'اطلاعات با موفقیت ثبت شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }

    }

    public function offer_delete()
    {
        try {
            $item = Setting::where('key', 'plan_offer')->first();
            $item->value = null;
            $item->save();
            return redirect()->back()->with('success_message', 'اطلاعات با موفقیت تغییر یافت');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }

}
