<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Http\Request;

class BuyController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if (isset($request->catId) && !is_null($request->catId)) {
            $category = Category::where('id', $request->catId)->first();
        } elseif ($id != null) {
            $category = Category::where('id', $id)->first();
        } else {
            $category = null;
        }


        if (isset($request->catId) && !is_null($request->catId)) {
            $cat_list = [$request->catId];
        } elseif (!is_null($category)) {
            $cat_list = [$category->id];
        } else {
            $cat_list = [];
        }

        if (!is_null($category)) {
            $cat_id_list = $this->childLoad($category, $cat_list);
        } else {
            $cat_id_list = [];
        }

        $requests = \App\Models\Request::query();

        // search
        if (isset($request->s) && !is_null($request->s)) {
            $requests = $requests->where('type', $request->s)->orWhere('type', 'LIKE', '%' . $request->s)->orWhere('type', 'LIKE', $request->s . '%')->orWhere('type', 'LIKE', '%' . $request->s . '%');
        }

        if (count($cat_id_list) > 0) {
            // category
            $requests = $requests->whereIn('category_id', $cat_id_list);
        }

        // sort
        $requests = $requests->orderBy('created_at', 'desc');

        $requests = $requests->where('show', 1)->where('status', 'confirm')->paginate(20);


        if ($request->method() == 'POST' && $request->lazy == false) {

            return response()->json([
                'success' => true,
                'view' => view('components.buyer.list', compact('requests'))->render()
            ]);
        }

        $params = $request->all();

        $lastPage = $requests->lastPage();


        if ($request->method() == 'POST' && $request->lazy == true) {

            return response()->json([
                'success' => true,
                'view' => view('components.buyer.list', compact('requests'))->render(),
                'load' => true
            ]);

        }

        $categories = Category::where('parent_id', null)->get();

        return view('buyer.index', compact('category', 'requests', 'params', 'lastPage', 'categories'));

    }


    public function all_product()
    {
        $categories = Category::where('parent_id', null)->get();
        $products = Product::where('show', 1)->where('status', 'confirm')->orderBy('created_at', 'desc')->paginate(40);

        return view('products.all', compact('categories', 'products'));

    }

    public function childLoad(Category $category, $cat_list)
    {
        if (count($category->children) > 0) {

            foreach ($category->children as $value) {
                array_push($cat_list, $value->id);

                if (count($value->children) > 0) {
                    $cat_list = $this->childLoad($value, $cat_list);
                }
            }

        }

        return $cat_list;
    }

    public function show($id, $slug)
    {
        $product = Product::where('id', $id)->where('slug', $slug)->where('show', 1)->where('status', 'confirm')->first();

        if (is_null($product)) {
            abort(404);
        }

        if ($product->user && $product->user->ban) {
            abort(403);
        }

        $similar = Product::where('status', 'confirm')->where('show', 1)->where('category_id', $product->category_id)->inRandomOrder()->take(10)->get();

        $comments = Comment::where('refrense_id', $product->user->id)->where('status', 'confirm')->orderBy('created_at', 'desc')->get();

        $banners = Banner::where('view_in', 'product')->orderBy('sort')->where('status', 1)->get();

        return view('products.show', compact('product', 'similar', 'comments', 'banners'));

    }
}
