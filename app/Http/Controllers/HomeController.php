<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Plan;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', null)->where('status', 1)->orderBy('sort')->get();
        $new_products = Product::where('show', 1)->where('status', 'confirm')->orderBy('created_at', 'desc')->take(20)->get();
        $buyers = \App\Models\Request::where('status', 'confirm')->orderBy('created_at', 'desc')->take(30)->get();

        $banners = Banner::where('view_in', 'home')->orderBy('sort')->where('status', 1)->get();

        $features = Feature::where('status', 1)->orderBy('sort')->get();

        $slider = Banner::where('view_in', 'slider')->orderBy('created_at', 'desc')->where('status', 1)->first();

        $footer_products = Product::where('show', 1)->where('status', 'confirm')->where('show_footer', 1)->orderBy('created_at', 'desc')->take(20)->get();

        return view('index', compact('categories', 'new_products', 'buyers', 'banners', 'slider', 'features', 'footer_products'));

    }


    public function app()
    {
        return view('app');
    }

    public function search(Request $request)
    {

        if (!is_null($request->s) && strlen($request->s) <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'nok',
                'view' => null
            ]);
        }

        $category = Category::where('title', $request->s)->orwhere('title', 'LIKE', '%' . $request->s)->orwhere('title', 'LIKE', $request->s . '%')->orwhere('title', 'LIKE', '%' . $request->s . '%')->where('status', 1)->take(150)->get();
        $products = Product::where('full_name', $request->s)->orwhere('full_name', 'LIKE', '%' . $request->s)->orwhere('full_name', 'LIKE', $request->s . '%')->orwhere('full_name', 'LIKE', '%' . $request->s . '%')->where('show', 1)->where('status', 'confirm')->take(150)->get();

        $lists = [];

        foreach ($products as $value) {
            if ($value->category) {

                $explode = str_replace($value->category->title, '', $value->full_name);

                if ($explode != $request->s) {
                    $url = route('product.category', [$value->category->id, $value->category->slug, 's' => trim($explode)]);
                } else {
                    $url = route('product.category', [$value->category->id, $value->category->slug]);
                }

                array_push($lists, [
                    'title' => $value->full_name,
                    'url' => $url,
                ]);
            }
        }

        foreach ($category as $value) {
            array_push($lists, [
                'title' => $value->title,
                'url' => route('product.category', [$value->id, $value->slug]),
                'part_search' => null
            ]);
        }


        return response()->json([
            'success' => true,
            'message' => 'ok',
            'view' => view('components.search', compact('lists'))->render()
        ]);

    }

    public function about()
    {
        $item = DB::table('settings')->where('key', 'about_us')->first();
        return view('about', compact('item'));

    }

    public function contact()
    {
        $phones = DB::table('settings')->where('key', 'phones')->first();

        $phones = explode(',', $phones->value);


        $email = DB::table('settings')->where('key', 'email')->first();
        $address = DB::table('settings')->where('key', 'address')->first();
        $map = DB::table('settings')->where('key', 'map')->first();

        return view('contact', compact('phones', 'email', 'address', 'map'));

    }

    public function privacy()
    {
        $item = DB::table('settings')->where('key', 'terms')->first();

        return view('privacy', compact('item'));

    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect()->route('home');
    }

    public function city_list()
    {
        $cities = City::where('parent_id', null)->with('child')->orderBy('name')->select('name', 'id')->get()->toArray();

        return response()->json([
            'success' => true,
            'city' => $cities
        ]);

    }

    public function page($id)
    {

        $page = Page::where('id', $id)->where('status', 1)->first();

        if (is_null($page)) {
            abort(404);
        }

        return view('page', compact('page'));

    }

    public function transfer($refId)
    {
        return view('bank_app', compact('refId'));
    }

}
