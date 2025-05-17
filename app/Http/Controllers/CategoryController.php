<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, $id, $slug)
    {

        if (isset($request->catId) && !is_null($request->catId)) {
            $category = Category::where('id', $request->catId)->first();
        } else {
            $category = Category::where('id', $id)->first();
        }

        if (is_null($category)) {
            abort(404);
        }

        if (isset($request->catId) && !is_null($request->catId)) {
            $cat_list = [$request->catId];
        } else {
            $cat_list = [$category->id];
        }

        $cat_id_list = $this->childLoad($category, $cat_list);

        $products = Product::query();

        // search
        if (isset($request->s) && !is_null($request->s) && $request->sort != 'new') {
            $products = $products->where('type', $request->s)->orWhere('type', 'LIKE', '%' . $request->s)->orWhere('type', 'LIKE', $request->s . '%')->orWhere('type', 'LIKE', '%' . $request->s . '%');
        }

        // category
        $products = $products->whereIn('category_id', $cat_id_list);

        // city
        if (isset($request->c) && !is_null($request->c)) {
            $products = $products->where('city_id', (int)$request->c);
        }

        // region
        if (isset($request->r) && !is_null($request->r)) {
            $products = $products->where('region_id', (int)$request->r);
        }

        // sort
        if (isset($request->sort) && $request->sort == 'new') {
            $products = $products->orderBy('created_at', 'desc');
        } else {
            $products = $products->orderBy('sort')->orderBy('created_at', 'asc');
        }

        $products = $products->where('show', 1)->where('status', 'confirm')->paginate(40);


        if (count($products) < 4 && $category->parent) {

            $category_se = $this->childLoad($category->parent, []);

            $similar = Product::whereIn('category_id', $category_se)->where('show', 1)->where('status', 'confirm')->take(20)->get();

        } else {
            $similar = [];
        }


        if ($request->method() == 'POST' && $request->lazy == false) {

            return response()->json([
                'success' => true,
                'view' => view('components.product.list', compact('products' , 'similar'))->render()
            ]);
        }

        $params = $request->all();

        $lastPage = $products->lastPage();


        if ($request->method() == 'POST' && $request->lazy == true) {

            return response()->json([
                'success' => true,
                'view' => view('components.product.items', compact('products' , 'similar'))->render(),
                'load' => true
            ]);

        }

        $categories = Category::where('parent_id', null)->get();

        $banners = Banner::where('page_category_id', $category->id)->get();



        return view('products.index', compact('category', 'products', 'params', 'lastPage', 'categories', 'banners', 'similar'));

    }


    public function all_product(Request $request)
    {
        $categories = Category::where('parent_id', null)->get();



        $products = Product::query();

        // city
        if (isset($request->c) && !is_null($request->c)) {
            $products = $products->where('city_id', (int)$request->c);
        }

        // region
        if (isset($request->r) && !is_null($request->r)) {
            $products = $products->where('region_id', (int)$request->r);
        }




        // sort
        if (isset($request->sort) && $request->sort == 'new') {
            $products = $products->orderBy('created_at', 'desc');
        } else {
            $products = $products->orderBy('sort')->orderBy('created_at', 'asc');
        }

        $products = $products->where('show', 1)->where('status', 'confirm')->paginate(40);


        $similar = [];

        if ($request->method() == 'POST') {

            return response()->json([
                'success' => true,
                'view' => view('components.product.list', compact('products' , 'similar'))->render()
            ]);
        }

        return view('products.all', compact('categories', 'products' , 'similar'));

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
