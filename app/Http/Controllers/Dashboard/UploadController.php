<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{

    use Upload;

    public function index(Request $request)
    {
        if (isset($request->s) && !is_null($request->s)) {

            $items = File::where('title', 'LIKE', "%{$request->s}%")->orderBy('created_at', 'desc')->paginate(20);

        } else {
            $items = File::orderBy('created_at')->paginate(20);

        }

        $params = $request->all();

        return view('dashboard.upload.index', compact('items', 'params'));

    }

    public function create(Request $request)
    {

        $prev_url = $request->page;
        return view('dashboard.upload.create', compact('prev_url'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:255',
        ]);

        $item = new File();

        try {

            $item->title = $request->title;
            if (file_exists($request->photo)) {
                $upload = $this->upload($request->photo, 'upload');
                $item->photo = $upload['File'];
            }
            $item->save();

            return redirect()->route('upload.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ثبت شد');


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }


    public function edit($id, Request $request)
    {
        $item = File::find($id);
        $prev_url = $request->page;

        if (is_null($item)) {
            abort(404);
        }

        return view('dashboard.upload.edit', compact('item', 'prev_url'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:255',
        ]);

        $item = File::find($id);

        if (is_null($item)) {
            abort(404);
        }

        try {
            $item->title = $request->title;
            if (file_exists($request->photo)) {
                $upload = $this->upload($request->photo, 'feature');
                $item->photo = $upload['File'];
            }
            $item->save();

            return redirect()->route('upload.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ویرایش شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }

    public function destroy($id)
    {

        $item = File::find($id);
        $item->delete();

        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');


    }
}
