<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(8);
        return view('panel.ticket.index', compact('tickets'));

    }

    public function info($id)
    {
        $ticket = Ticket::where('id', (int)$id)->where('user_id', Auth::id())->first();

        if (is_null($ticket)) {
            abort(404);
        }

        $ticket->read_user = 1;
        $ticket->save();

        $comments = TicketComment::where('ticket_id', $ticket->id)->get();

        return view('panel.ticket.info', compact('ticket', 'comments'));

    }

    public function comment_store(Request $request, $id)
    {
        Validator::make($request->all(), [
            'text' => ['required', 'string', 'min:10', 'max:500'],
        ])->validate();

        $ticket = Ticket::where('id', (int)$id)->where('user_id', Auth::id())->first();

        if (is_null($ticket)) {
            abort(404);
        }
        try {
            $comment = new TicketComment();
            $comment->user_id = Auth::id();
            $comment->ticket_id = $ticket->id;
            $comment->is_admin = 0;
            $comment->text = $request->text;
            $comment->save();

            $ticket->status = 0;
            $ticket->save();

            return redirect()->back()->with('success_message', 'پیام شما ارسال شد');


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد لطفا با پشتیبانی تماس حاصل فرمایید');
        }

    }

    public function create()
    {
        return view('panel.ticket.create');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'text' => ['required', 'string', 'min:10', 'max:500'],
            'departman' => ['required', 'string', 'in:technical,financial'],
        ])->validate();


        try {

            $ticket = new Ticket();
            $ticket->user_id = Auth::id();
            $ticket->departman = $request->departman;
            $ticket->status = 0;
            $ticket->title = $request->title;
            $ticket->text = $request->text;
            $ticket->read_user = 1;
            $ticket->save();

            return redirect()->route('tickets')->with('success_message', 'تیکت با موفقیت ثبت شد و پس از بررسی به آن پاسخ خواهیم داد');

        } catch (\Exception $e) {


            return redirect()->back()->with('error_message', 'خطایی رخ داد لطفا با پشتیبانی تماس حاصل فرمایید');
        }


    }

}
