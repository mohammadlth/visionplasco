<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Product;
use App\Models\PhoneViews;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function remove_file($id)
    {
        $item = Photo::find($id);
        if (is_null($item)) {
            abort(404);
        }
        \Illuminate\Support\Facades\File::delete(public_path($item->path));

        $item->delete();

        return redirect()->back()->with('success_message', 'تصویر با موفقیت حذف شد');

    }

    public function mobiles(Request $request)
    {
        if (isset($request->s) && !is_null($request->s)) {

            $user = User::where('mobile', 'LIKE', "%{$request->s}%")->orwhere('name', 'LIKE', "%{$request->s}%")->first();

            if (!is_null($user)) {
                $items = PhoneViews::where('user_id', $user->id)->orderBy('created_at', 'desc')->with('user' , 'contact')->paginate(20);
            }

        } else {
            $items = PhoneViews::orderBy('created_at', 'desc')->with('user' , 'contact')->paginate(20);
        }

        $params = $request->all();

        return view('dashboard.mobiles.index', compact('items', 'params'));

    }
}
