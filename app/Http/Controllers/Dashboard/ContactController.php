<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\SmsJob;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index(Request $request)
    {

        if (isset($request->s) && !is_null($request->s)) {

            $user = User::where('mobile', 'LIKE', "%{$request->s}%")->orwhere('name', 'LIKE', "%{$request->s}%")->first();

            if (!is_null($user)) {
                $items = Contact::where('user_id', $user->id)->orwhere('contact_id', $user->id)->orderBy('created_at', 'desc')->paginate(20);
            } else {
                $items = Contact::where('last_message', 'LIKE', "%{$request->s}%")->orderBy('created_at', 'desc')->paginate(20);
            }

        } else {
            $items = Contact::orderBy('created_at', 'desc')->paginate(20);
        }


        $params = $request->all();

        return view('dashboard.contact.index', compact('items', 'params'));
    }

    public function chats(Request $request, $id)
    {

        $item = Contact::find($id);

        if (is_null($item)) {
            abort(404);
        }

        $comments_self = Chat::where('sender_id', $item->user->id)->where('contact_id', $item->contact->id)->orderBy('created_at', 'desc')->take(500)->get();
        $comments_user = Chat::where('sender_id', $item->contact->id)->where('contact_id', $item->user->id)->orderBy('created_at', 'desc')->take(500)->get();
        $chats = $comments_self->merge($comments_user);

        return view('dashboard.contact.chat', compact('item', 'chats'));
    }

    public function warning_type($user_id, $type)
    {
        $user = User::find($user_id);

        if (is_null($user)) {
            abort(404);
        }

        $template = null;

        switch ($type) {
            case 0 :
                $template = config('smsir.templates.warning_moral');
                break;
            case 1 :
                $template = config('smsir.templates.warning_thief');
                break;
            case 2 :
                $template = config('smsir.templates.warning_ban');
                break;
        }

        SmsJob::dispatch([$user->mobile, ['name' => $user->name], $template])->onQueue('default');

        return redirect()->back()->with('success_message', 'پیامک با موفقیت ارسال شد');

    }

    public function delete($id)
    {
        $contact = Contact::find($id);

        if (is_null($contact)) {
            abort(404);
        }

        $contact_2 = Contact::where('contact_id', $contact->user_id)->where('user_id', $contact->user_id)->first();

        Chat::where('sender_id', $id)->where('contact_id', $id)->orderBy('created_at', 'desc')->delete();
        Chat::where('sender_id', $id)->where('contact_id', $id)->orderBy('created_at', 'desc')->delete();

        $contact->delete();
        if (!is_null($contact_2)) {
            $contact_2->delete();
        }

        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');

    }

}
