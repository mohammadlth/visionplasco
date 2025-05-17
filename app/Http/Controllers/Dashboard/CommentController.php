<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request->s) && !is_null($request->s)) {

            $user = User::where('mobile', 'LIKE', "%{$request->s}%")->orwhere('name', 'LIKE', "%{$request->s}%")->first();

            if (!is_null($user)) {
                $items = Comment::where('user_id', $user->id)->orwhere('refrense_id', $user->id)->with('user' , 'reference')->orderBy('created_at', 'desc')->paginate(20);
            } else {
                $items = Comment::where('text', 'LIKE', "%{$request->s}%")->with('user' , 'reference')->orderBy('created_at', 'desc')->paginate(20);
            }

        } else {
            $items = Comment::with('user' , 'reference')->orderBy('created_at', 'desc')->paginate(20);
        }

        $params = $request->all();

        return view('dashboard.comment.index', compact('items', 'params'));

    }

    public function destroy($id)
    {
        $item = Comment::find($id);

        $item->delete();

        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');


    }

}
