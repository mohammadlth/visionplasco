<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->s) && !is_null($request->s)) {

            $user = User::where('mobile', 'LIKE', "%{$request->s}%")->orwhere('name', 'LIKE', "%{$request->s}%")->first();

            if (!is_null($user)) {
                $items = Chat::where('sender_id', $user->id)->orwhere('contact_id', $user->id)->with('user' , 'contact')->orderBy('created_at', 'desc')->paginate(100);
            } else {
                $items = Chat::where('message', 'LIKE', "%{$request->s}%")->with('user' , 'contact')->orderBy('created_at', 'desc')->paginate(100);
            }

        } else {
            $items = Chat::with('user' , 'contact')->orderBy('created_at', 'desc')->paginate(100);
        }

        $params = $request->all();

        return view('dashboard.chat.index', compact('items', 'params'));

    }

    public function delete($id){

        $chat = Chat::find($id);

        if (is_null($chat)){
            abort(404);
        }

        $chat->delete();

        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');

    }

}
