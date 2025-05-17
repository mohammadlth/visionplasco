<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'rate' => ['required', 'in:1,2,3,4,5']
        ]);

        if (!Auth::check()){
            return redirect()->back()->with('error_message' , 'برای ثبت نظر وارد شوید یا ثبت نام کنید');
        }

        if ($request->user_id == Auth::id()){
            return redirect()->back()->with('error_message' , 'ثبت نظر برای خودتان امکان پذیر نمیباشد');
        }

        $user = Auth::user();
        $reference = User::find($request->user_id);

        $diff = Carbon::now()->diffInDays($user->created_at);

        if ($diff <= 3){
            return redirect()->back()->with('error_message' , 'امکان ثبت نظر برای کاربران تازه وارد وجود ندارد');
        }

        $exist = Comment::where('user_id'  , Auth::id())->where('refrense_id' , $request->user_id)->first();

        if (!is_null($exist)){
            return redirect()->back()->with('error_message' , 'شما قبلا نظر خود را ثبت کرده اید');
        }


        try {
            $item = new Comment();
            $item->user_id = Auth::id();
            $item->refrense_id = $request->user_id;
            $item->status = 'confirm';
            $item->rate = $request->rate;
            $item->text = $request->text;
            $item->save();

            $comments = (int)$reference->info->comments + 1;
            $rate = (int)(((int)$reference->info->score + $request->rate) / $comments);

            $reference->info->score = $rate;
            $reference->info->comments = $comments;
            $reference->info->save();

            return redirect()->back()->with('success_message' , 'نظر شما ثبت شد');


        }catch (Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message' , 'خطایی رخ داد لطفا در فرصتی دیگر امتحان کنید');
        }

    }

}
