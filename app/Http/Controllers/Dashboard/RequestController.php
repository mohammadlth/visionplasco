<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chat;
use App\Models\City;
use App\Models\User;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RequestController extends Controller
{
    use Upload;

    public function index(Request $request)
    {

        if (isset($request->s) && !is_null($request->s)) {

            $user = User::where('mobile', 'LIKE', "%{$request->s}%")->orwhere('name', 'LIKE', "%{$request->s}%")->first();

            if (!is_null($user)) {
                $items = \App\Models\Request::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(20);
            } else {
                $items = \App\Models\Request::where('type', 'LIKE', "%{$request->s}%")->orderBy('created_at', 'desc')->paginate(20);
            }

        } else {
            $items = \App\Models\Request::orderBy('updated_at', 'desc')->paginate(20);
        }

        $params = $request->all();

        return view('dashboard.request.index', compact('items', 'params'));

    }

    public function edit($id, Request $request)
    {
        $item = \App\Models\Request::find($id);
        $prev_url = $request->page;

        if (is_null($item)) {
            abort(404);
        }
        $categories = Category::orderBy('created_at', 'desc')->get();

        return view('dashboard.request.edit', compact('item', 'prev_url', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|min:2|max:255',
            'category_id' => 'required|numeric',
        ]);

        $item = \App\Models\Request::find($id);

        if (is_null($item)) {
            abort(404);
        }

        try {

            $item->type = $request->type;
            $item->category_id = $request->category_id;
            $item->status = $request->status;
            $item->show = $request->show;
            $item->inventory = $request->inventory;
            $item->save();

            return redirect()->route('requests.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ویرایش شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }

    public function destroy($id)
    {

        $item = \App\Models\Request::find($id);

        if (is_null($item)) {
            abort(404);
        }

        Chat::where('refrense', 'zgp-' . $id)->delete();
        $item->delete();


        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');

    }


}
