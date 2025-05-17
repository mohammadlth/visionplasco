<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    use Upload;

    public function index(Request $request)
    {
        if (isset($request->s) && !is_null($request->s)) {

            $items = Article::where('title', 'LIKE', "%{$request->s}%")->orderBy('created_at', 'desc')->paginate(20);

        } else {
            $items = Article::orderBy('sort')->paginate(20);

        }

        $params = $request->all();

        return view('dashboard.article.index', compact('items', 'params'));

    }

    public function create(Request $request)
    {

        $prev_url = $request->page;
        return view('dashboard.article.create', compact('prev_url'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:255',
        ]);

        $item = new Article();

        try {

            $item->title = $request->title;
            $item->slug = str_replace(' ', '-', $request->title);
            $item->status = $request->status;
            $item->text = $request->text;
            $item->sort = $request->sort;
            $item->short_text = $request->short_text;
            if (file_exists($request->photo)) {
                $upload = $this->upload($request->photo, 'article');
                $item->photo = $upload['File'];
            }
            $item->save();

            return redirect()->route('article.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ثبت شد');


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }


    public function edit($id, Request $request)
    {
        $item = Article::find($id);
        $prev_url = $request->page;

        if (is_null($item)) {
            abort(404);
        }

        return view('dashboard.article.edit', compact('item', 'prev_url'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:255',
        ]);

        $item = Article::find($id);

        if (is_null($item)) {
            abort(404);
        }

        try {
            $item->title = $request->title;
            $item->slug = str_replace(' ', '-', $request->title);
            $item->status = $request->status;
            $item->text = $request->text;
            $item->short_text = $request->short_text;
            $item->sort = $request->sort;
            if (file_exists($request->photo)) {
                $upload = $this->upload($request->photo, 'article');
                $item->photo = $upload['File'];
            }
            $item->save();

            return redirect()->route('article.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ویرایش شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }


    public function destroy($id)
    {

        $item = Article::find($id);
        $item->delete();

        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');


    }

    public function pic_remove($id)
    {
        $item = Article::find($id);

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
