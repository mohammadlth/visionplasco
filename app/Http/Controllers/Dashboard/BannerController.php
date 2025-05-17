<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    use Upload;

    public function index(Request $request)
    {

        $items = Banner::orderBy('created_at', 'desc')->paginate(20);
        return view('dashboard.banner.index', compact('items'));

    }

    public function create(Request $request)
    {

        $prev_url = $request->page;
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('dashboard.banner.create', compact('prev_url', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'photo' => 'required',
            'sort' => 'required|numeric',
        ]);

        $item = new Banner();

        try {
            $item->title = $request->title;
            $item->link = $request->link;
            $item->view_in = $request->view_in;
            $item->page_category_id = $request->page_category_id;
            $item->sort = $request->sort;
            $item->status = $request->status;
            $item->short_text = $request->short_text;
            if (file_exists($request->photo)) {
                $upload = $this->upload($request->photo, 'banners');
                $item->photo = $upload['File'];
            }
            $item->save();

            return redirect()->route('banners.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ثبت شد');


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }


    public function edit($id, Request $request)
    {
        $item = Banner::find($id);
        $prev_url = $request->page;

        if (is_null($item)) {
            abort(404);
        }

        $categories = Category::orderBy('created_at', 'desc')->get();

        return view('dashboard.banner.edit', compact('item', 'prev_url' , 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'sort' => 'required|numeric',
        ]);

        $item = Banner::find($id);

        if (is_null($item)) {
            abort(404);
        }

        try {
            $item->title = $request->title;
            $item->link = $request->link;
            $item->view_in = $request->view_in;
            $item->page_category_id = $request->page_category_id;
            $item->sort = $request->sort;
            $item->status = $request->status;
            $item->short_text = $request->short_text;
            if (file_exists($request->photo)) {
                $upload = $this->upload($request->photo, 'banners');
                $item->photo = $upload['File'];
            }
            $item->save();

            return redirect()->route('banners.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ویرایش شد');

        } catch (\Exception $e) {
            dd($e);
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
