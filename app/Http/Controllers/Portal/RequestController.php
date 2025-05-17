<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{

    public function store()
    {
        $categories = Category::where('parent_id', null)->where('status', 1)->with('children')->get();
        $requests = \App\Models\Request::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('portal.request.store', compact('categories', 'requests'));

    }

    public function insert(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'category' => 'required|min:1',
            'type' => 'required|min:1|max:100',
            'inventory' => 'required|numeric|min:0',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ]);
        }

        $count = \App\Models\Request::where('user_id', Auth::id())->whereBetween('created_at', [Carbon::now()->subDays(3), Carbon::now()])->count();

        if ($count > 3) {
            return response()->json([
                'success' => false,
                'message' => 'شما مجاز به وارد کردن حداکثر 3 درخواست طی 24 ساعت آینده را دارید'
            ]);
        }

        $category = Category::where('title', $request->category)->first();

        if (is_null($category)) {
            return response()->json([
                'success' => false,
                'message' => 'دسته بندی یافت نشد'
            ]);
        }

        try {

            $item = new \App\Models\Request();
            $item->category_id = $category->id;
            $item->type = $request->type;
            $item->inventory = $request->inventory;
            $item->status = 'confirm';
            $item->user_id = Auth::id();
            $item->show = true;
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'اطلاعات با موفقیت ثبت شد'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'خطا در ثبت اطلاعات'
            ]);

        }


    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'type' => 'required|min:1|max:100',
            'inventory' => 'required|numeric|min:0',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with('error_message', 'لطفا تمامی فیلد ها را به درستی تکمیل کنید');
        }

        $requests = \App\Models\Request::where('user_id', Auth::id())->where('id', $id)->first();

        if (is_null($requests)) {
            return redirect()->back()->with('error_message', 'درخواستی یافت نشد');
        }

        try {

            $requests->type = $request->type;
            $requests->inventory = $request->inventory;
            $requests->save();

            return redirect()->back()->with('success_message', 'اطلاعات درخواست بروز شد');


        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'خطا در ثبت اطلاعات');
        }


    }

    public function delete($id)
    {

        $request = \App\Models\Request::where('id', $id)->where('user_id', Auth::id())->first();

        if (is_null($request)) {
            return redirect()->back()->with('error_message', 'چیزی پیدا نشد');
        }

        $request->delete();

        return redirect()->back()->with('success_message', 'درخواست با موفقیت حذف شد');

    }

    public function list(Request $request)
    {

        $categories = [];

        if (isset($request->s) && strlen($request->s) >= 2) {

            $category = Category::where('title', $request->s)->orwhere('title', 'LIKE', '%' . $request->s)->orwhere('title', 'LIKE', '%' . $request->s . '%')->orwhere('title', 'LIKE', $request->s . '%')->select('id')->get();

            foreach ($category as $value) {
                array_push($categories, $value->id);
            }


            $requests = \App\Models\Request::query();

            if (count($categories) > 0) {
                $requests = $requests->whereIn('category_id', $category);
            }


            if (isset($request->s)) {
                $requests = $requests->orwhere('type', 'LIKE', '%' . $request->s)->orwhere('type', 'LIKE', '%' . $request->s . '%')->orwhere('type', 'LIKE', $request->s . '%');
            }

            $requests = $requests->where('status', 'confirm')->orderBy('created_at', 'desc')->take(200)->get();


        } else {


            $requests = \App\Models\Request::where('status', 'confirm');
            $requests = $requests->orderBy('created_at', 'desc')->take(200)->get();

        }


        if ($request->method() == 'POST') {
            $items = $requests;
            return response()->json([
                'success' => true,
                'view' => view('components.portal.request.list', compact('items'))->render()
            ]);

        } else {
            $slider = Banner::where('view_in', 'buyer')->orderBy('sort')->where('status', 1)->get();
            return view('portal.request.list', compact('requests', 'slider'));
        }


    }

}
