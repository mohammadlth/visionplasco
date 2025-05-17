<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Management;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('status', 1)->orderBy('created_at', 'Desc')->paginate(40);
        return view('articles.index', compact('articles'));
    }

    public function show($slug)
    {

        $article = Article::where('slug', $slug)->first();
        if (is_null($article)) {
            abort(404);
        }


        return view('articles.single', compact('article'));


    }
}
