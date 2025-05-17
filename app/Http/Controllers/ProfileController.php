<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::where('id', $id)->where('ban', false)->first();

        if (is_null($user)) {
            abort(404);
        }

        $products = Product::where('user_id' , $user->id)->where('status' , 'confirm')->where('show' , 1)->get();
        $comments = Comment::where('refrense_id'  , $user->id)->where('status' , 'confirm')->orderBy('created_at' , 'desc')->get();

        return view('profile.show', compact('user' , 'products' , 'comments'));
    }

}
