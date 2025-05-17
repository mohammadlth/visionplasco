<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    use Upload;

    public function index(Request $request)
    {
        if (isset($request->s) && !is_null($request->s)) {
            
            $items = Category::where('title', 'LIKE', "%{$request->s}%")->orderBy('created_at', 'desc')->paginate(20);

        } else {
            $items = Category::where('parent_id', null)->orderBy('sort')->paginate(1);
        }

        $params = $request->all();

        return view('dashboard.category.index', compact('items', 'params'));

    }

    public function create(Request $request)
    {

        $prev_url = $request->page;
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('dashboard.category.create', compact('prev_url', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'slug' => 'required|string|min:2|max:255',
            'sort' => 'required|numeric',
        ]);

        $item = new Category();

        try {
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->parent_id = $request->parent_id;
            $item->sort = $request->sort;
            $item->status = $request->status;
            $item->short_text = $request->short_text;
            $item->text = $request->text;
            $item->placeholder = $request->placeholder;
            $item->unit = $request->unit;

            if (file_exists($request->photo)) {
                $upload = $this->upload($request->photo, 'categories');
                $item->photo = $upload['File'];
            }
            if (file_exists($request->sub)) {
                $upload = $this->upload($request->sub, 'categories-sub');
                $item->sub = $upload['File'];
            }


            $item->save();

            return redirect()->route('categories.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ثبت شد');


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }


    public function edit($id, Request $request)
    {
        $item = Category::find($id);
        $prev_url = $request->page;

        if (is_null($item)) {
            abort(404);
        }

        $categories = Category::orderBy('created_at', 'desc')->get();

        return view('dashboard.category.edit', compact('item', 'prev_url', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'slug' => 'required|string|min:2|max:255',
            'sort' => 'required|numeric',
        ]);

        $item = Category::find($id);

        if (is_null($item)) {
            abort(404);
        }

        try {
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->parent_id = $request->parent_id;
            $item->sort = $request->sort;
            $item->status = $request->status;
            $item->short_text = $request->short_text;
            $item->text = $request->text;
            $item->placeholder = $request->placeholder;
            $item->unit = $request->unit;
            if (file_exists($request->photo)) {
                $upload = $this->upload($request->photo, 'categories');
                $item->photo = $upload['File'];
            }

            if (file_exists($request->sub)) {
                $upload = $this->upload($request->sub, 'categories-sub');
                $item->sub = $upload['File'];
            }


            $item->save();

            return redirect()->route('categories.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ویرایش شد');


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }


    public function destroy($id)
    {
        $item = Category::find($id);

        $products = Product::where('category_id', $id)->count();

        if (count($item->children) > 0) {
            return redirect()->back()->with('error_message', 'دسته شامل زیر شاخه میباشد');
        }


        if ($products > 0) {
            return redirect()->back()->with('error_message', 'امکان حذف این دسته بندی وجود ندارد');
        }

        $item->delete();

        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');


    }

    public function pic_remove($id)
    {
        $item = Category::find($id);

        if (is_null($item)) {
            abort(404);
        }

        try {

            $item->photo = null;
            $item->save();
            return redirect()->back()->with('success_message', 'تصویر با موفقیت حذف شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');

        }


    }

}
