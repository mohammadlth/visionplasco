<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Jobs\ChatNotification;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\Product;
use App\Traits\Upload;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

class ChatController extends Controller
{
    use Upload;

    public function index()
    {

        $contacts = Contact::where('user_id', Auth::id())->where('block', false)->with('contact')->orderBy('updated_at', 'desc')->get();
        return view('portal.chat.index', compact('contacts'));

    }

    public function select(Request $request)
    {

        $chat = Contact::where('user_id', Auth::id())->where('contact_id', $request->contact_id)->with('contact')->first();

        if (is_null($chat)) {
            return response()->json([
                'success' => false,
                'message' => 'کاربر یافت نشد'
            ], 400);
        }

        $chat->message_not_read = 0;
        $chat->save();


        if ($chat->block) {
            return response()->json([
                'success' => false,
                'message' => 'امکان دسترسی به این گفتگو وجود ندارد'
            ], 400);
        }

        $comments_self = Chat::where('sender_id', Auth::id())->where('contact_id', $request->contact_id)->orderBy('created_at', 'asc')->take(200)->get();
        $comments_user = Chat::where('sender_id', $request->contact_id)->where('contact_id', Auth::id())->orderBy('created_at', 'asc')->take(200)->get();
        $comments = $comments_self->merge($comments_user)->groupBy('date');


        return response()->json([
            'success' => true,
            'view' => view('components.portal.chat.index', compact('comments', 'chat'))->render(),
            'message' => 'ok'
        ]);

    }

    public function store(Request $request)
    {


        $validation = Validator::make($request->all(), [
            'contact_id' => 'required',
            'message' => 'required|min:2|max:400',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ]);
        }

        try {
            $contact = Contact::where('user_id', $request->contact_id)->where('contact_id', Auth::id())->first();

            $item = new Chat();
            $item->message = $request->message;
            $item->sender_id = Auth::id();
            $item->contact_id = $request->contact_id;
            $item->date = Verta::now()->format('Y/m/d');
            $item->save();

            $contact->message_not_read = $contact->message_not_read + 1;
            $contact->last_message = $item->message;
            $contact->save();

            $diff = DB::table('verifies')->where('mobile', $contact->user->mobile)->where('type', 'chat_notification')->first();
            $period = 6000;
            if (!is_null($diff)) {
                $period = Carbon::now()->diffInSeconds(Carbon::make($diff->created_at));
            }

            $last_active = Carbon::now()->diffInSeconds(Carbon::make($contact->user->last_activity));

            if ($period >= 6000 && $last_active >= 300) {
                ChatNotification::dispatch([$contact->user->mobile, Auth::user()->name])->onQueue('default');

                DB::table('verifies')->insert([
                    'mobile' => $contact->user->mobile,
                    'created_at' => Carbon::now(),
                    'type' => 'chat_notification',
                    'code' => 0,
                ]);

            }

            return response()->json([
                'success' => true,
                'message' => 'ok',
                'view' => view('components.portal.chat.item', compact('item'))->render(),
            ]);

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در ثبت اطلاعات'
            ], 400);
        }

    }

    public function select_box(Request $request)
    {

        if (Auth::id() == $request->contact_id) {
            return response()->json([
                'success' => false,
                'message' => 'امکان چت با خودتان وجود ندارد'
            ], 400);
        }

        $chat = Contact::where('user_id', Auth::id())->where('contact_id', $request->contact_id)->with('contact')->first();

        if (isset($request->product_id) && !is_null($request->product_id)) {
            $product = Product::where('id', $request->product_id)->where('show', 1)->where('status', 'confirm')->first();
        } else {
            $product = null;
        }


        if (is_null($chat)) {
            $user = \App\Models\User::where('id', $request->contact_id)->where('ban', 0)->first();
            return response()->json([
                'success' => true,
                'view' => view('components.chat.empty', compact('user', 'product'))->render(),
                'message' => 'ok'
            ]);
        }

        $chat->message_not_read = 0;
        $chat->save();


        if ($chat->block) {
            return response()->json([
                'success' => false,
                'message' => 'امکان دسترسی به این گفتگو وجود ندارد'
            ], 400);
        }

        $comments_self = Chat::where('sender_id', Auth::id())->where('contact_id', $request->contact_id)->orderBy('created_at', 'asc')->take(200)->get();
        $comments_user = Chat::where('sender_id', $request->contact_id)->where('contact_id', Auth::id())->orderBy('created_at', 'asc')->take(200)->get();
        $comments = $comments_self->merge($comments_user)->groupBy('date');


        return response()->json([
            'success' => true,
            'view' => view('components.chat.index', compact('comments', 'chat', 'product'))->render(),
            'message' => 'ok'
        ]);
    }

    public function store_box(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'contact_id' => 'required',
            'message' => 'required|min:2|max:400',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->getMessageBag()->first()
            ]);
        }

        try {

            $contact = Contact::where('user_id', $request->contact_id)->where('contact_id', Auth::id())->first();

            if (is_null($contact)) {
                $req = $this->storeContact($request->contact_id);
                if ($req['success']) {
                    $contact = Contact::where('user_id', $request->contact_id)->where('contact_id', Auth::id())->first();
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $req['message']
                    ], 400);
                }
            }


            $item = new Chat();
            $item->message = $request->message;
            $item->sender_id = Auth::id();
            $item->contact_id = $request->contact_id;
            $item->refrense = !is_null($request->product_id) ? $request->product_id : null;
            $item->date = Verta::now()->format('Y/m/d');
            $item->save();

            $contact->message_not_read = $contact->message_not_read + 1;
            $contact->last_message = $item->message;
            $contact->save();

            $diff = DB::table('verifies')->where('mobile', $contact->user->mobile)->where('type', 'chat_notification')->first();

            $period = 6000;

            if (!is_null($diff)) {
                $period = Carbon::now()->diffInSeconds(Carbon::make($diff->created_at));
            }

            $last_active = Carbon::now()->diffInSeconds(Carbon::make($contact->user->last_activity));


            if ($period >= 6000 && $last_active >= 300) {

                ChatNotification::dispatch([$contact->user->mobile, Auth::user()->name])->onQueue('default');

                DB::table('verifies')->insert([
                    'mobile' => $contact->user->mobile,
                    'created_at' => Carbon::now(),
                    'type' => 'chat_notification',
                    'code' => 0,
                ]);

            }

            return response()->json([
                'success' => true,
                'message' => 'ok',
                'view' => view('components.portal.chat.item', compact('item'))->render(),
            ]);

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در ثبت اطلاعات'
            ], 400);
        }

    }

    public function storeContact($contact_id)
    {

        $user = \App\Models\User::find($contact_id);

        if (is_null($user)) {
            return [
                'success' => false,
                'message' => 'مخاطب یافت نشد'
            ];
        }

        if ($user->ban) {
            return [
                'success' => false,
                'message' => 'حساب کاربر بسته شده است'
            ];
        }

        try {

            $contact = new Contact();
            $contact->user_id = $contact_id;
            $contact->contact_id = Auth::id();
            $contact->block = false;
            $contact->message_not_read = 0;
            $contact->save();

            $contact = new Contact();
            $contact->user_id = Auth::id();
            $contact->contact_id = $contact_id;
            $contact->block = false;
            $contact->message_not_read = 0;
            $contact->save();

            return [
                'success' => true,
                'message' => 'ok',
                'contact' => $contact,
            ];

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [
                'success' => false,
                'message' => 'خطا پردارش اطلاعات'
            ];
        }

    }


}
