<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Identity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IdentityController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request->s) && !is_null($request->s)) {

            $user = User::where('mobile', 'LIKE', "%{$request->s}%")->orwhere('name', 'LIKE', "%{$request->s}%")->first();

            if (!is_null($user)) {
                $items = Identity::where('user_id', $user->id)->with('user')->orderBy('created_at', 'desc')->paginate(20);
            }

        } else {
            $items = Identity::with('user')->orderBy('created_at', 'desc')->paginate(20);
        }

        $params = $request->all();

        return view('dashboard.identity.index', compact('items', 'params'));

    }

    public function edit($id, Request $request)
    {
        $item = Identity::find($id);
        $prev_url = $request->page;

        if (is_null($item)) {
            abort(404);
        }

        return view('dashboard.identity.edit', compact('item', 'prev_url'));
    }

    public function update($id, Request $request)
    {
        $item = Identity::find($id);

        if (is_null($item)) {
            abort(404);
        }

        $user = $item->user;

        try {

            if ($request->status == 'confirm') {
                $user->confirm_identity = 1;
                $user->save();
            } else {
                $user->confirm_identity = 0;
                $user->save();
            }

            $item->status = $request->status;
            $item->admin_text = $request->text;
            $item->save();

            return redirect()->route('identities.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ثبت شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }


    }

    public function destroy($id)
    {
        $item = Identity::find($id);

        $user = $item->user;
        $user->confirm_identity = 0;
        $user->save();

        $item->delete();

        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');

    }

}
