<?php

namespace App\Http\Controllers;

use App\Models\Meta;

class SitemapController extends Controller
{
    public function index()
    {
        $items = Meta::all();


        return response()->view('sitemap.index', compact('items'))->withHeaders([
            'Content-Type' => 'text/xml'
        ]);

    }
}
