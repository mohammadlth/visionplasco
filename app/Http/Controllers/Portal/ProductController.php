<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Plan;
use App\Models\Transaction;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

class ProductController extends Controller
{
    use Upload;

    public function index()
    {
        $products = Product::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);

        return view('portal.product.index', compact('products'));

    }

    public function store()
    {
        $categories = Category::where('parent_id', null)->where('status', 1)->with('children')->get();
        return view('portal.product.store', compact('categories'));

    }


    public function info($id)
    {
        $product = Product::where('id', $id)->where('user_id', Auth::id())->with('category')->first();

        if (is_null($product)) {
            abort(404);
        }

        $cities = City::where('parent_id', null)->with('child')->get();

        return view('portal.product.info', compact('product', 'cities'));

    }


    public function insert(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'category' => 'required|min:2',
            'type' => 'required|min:2|max:100',
            'region' => 'required|numeric|min:1',
            'city' => 'required|numeric|min:1',
            'inventory' => 'required|numeric|min:0',
            'min_inventory' => 'required|numeric|min:0',
            'min_price' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error'
            ]);
        }

        $category = Category::where('title', $request->category)->first();
        if (is_null($category)) {
            return response()->json([
                'success' => false,
                'message' => 'دسته بندی یافت نشد'
            ]);
        }

        $city = City::where('id', $request->city)->get();
        $region = City::where('id', $request->region)->get();

        if (is_null($city) || is_null($region)) {
            return response()->json([
                'success' => false,
                'message' => 'شهر یا استان یافت نشد'
            ]);
        }

        try {

            $item = new Product();
            $item->category_id = $category->id;
            $item->type = $request->type;
            $item->full_name = $category->title . ' ' . $request->type;
            $item->slug = str_replace(' ', '-', $category->title . ' ' . $request->type);
            $item->region_id = $request->region;
            $item->city_id = $request->city;
            $item->inventory = $request->inventory;
            $item->min_inventory = $request->min_inventory;
            $item->min_price = $request->min_price;
            $item->description = $request->description;
            $item->status = 'waiting';
            $item->user_id = Auth::id();
            $item->show = true;
            $item->save();

            if ($request->photos && count($request->photos) > 0) {
                foreach ($request->photos as $value) {
                    $this->upload($value, 'products', $item->id, false);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'اطلاعات با موفقیت ثبت شد'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'خطا در ثبت اطلاعات'
            ]);

        }


    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'type' => 'required|min:2|max:100',
            'region_id' => 'required|numeric|min:1',
            'city_id' => 'required|numeric|min:1',
            'inventory' => 'required|numeric|min:0',
            'min_inventory' => 'required|numeric|min:0',
            'min_price' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with('error_message', $validation->getMessageBag()->first());
        }

        $item = Product::where('id', $id)->where('user_id', Auth::id())->first();

        if (is_null($item)) {
            abort(404);
        }

        try {
            $item->type = $request->type;
            $item->region_id = $request->region_id;
            $item->city_id = $request->city_id;
            $item->inventory = $request->inventory;
            $item->min_inventory = $request->min_inventory;
            $item->min_price = $request->min_price;
            if ($item->description != $request->description || isset($request->photos)) {
                $item->status = 'waiting';
            }
            $item->description = $request->description;
            $item->save();

            if ($request->photos && count($request->photos) > 0) {
                foreach ($request->photos as $value) {
                    $this->upload($value, 'products', $item->id, false);
                }
            }


            return redirect()->route('portal.products')->with('success_message', 'محصول با موفقیت ویرایش شد');

        } catch (Exception $e) {
            return redirect()->back()->with('error_message', 'خطا در ثبت اطلاعات لطفا در فرصتی دیگر امتحان کنید');
        }


    }

    public function change_show($id, $show)
    {

        $item = Product::where('id', $id)->where('user_id', Auth::id())->first();

        if (is_null($item)) {
            abort(404);
        }

        try {

            if ($show == 1) {
                $item->show = 1;
                $item->save();
            }

            if ($show == 0) {
                $item->show = 0;
                $item->save();
            }

            return redirect()->back()->with('success_message', 'تغییر وضعیت محصول با موفقیت انجام شد');


        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'خطا در ثبت اطلاعات لطفا در فرصتی دیگر امتحان کنید');

        }
    }

    public function category(Request $request)
    {

        if (is_null($request->search) && strlen($request->search) <= 2) {
            return response()->json([
                'success' => false,
                'message' => 'Params is invalid'
            ]);
        }

        $categories = Category::where('title', $request->search)->orwhere('title', 'LIKE', '%' . $request->search)->orwhere('title', 'LIKE', $request->search . '%')->orwhere('title', 'LIKE', '%' . $request->search . '%')->orwhere('title', $request->search)->with('parent', 'children')->get();
        $items = $this->makeList($categories);


        return response()->json([
            'success' => true,
            'data' => $items
        ]);


    }

    public function makeList($items)
    {
        $array = [];

        foreach ($items as $value) {

            $next = $this->nextList($value);
            $past = $this->pastList($value);


            if (count($next) > 0) {
                foreach ($next as $val) {

                    array_push($array, [
                        'title' => $past . $val['title'],
                        'id' => $val['id']
                    ]);

                }
            } else {
                array_push($array, [
                    'title' => $past . $value->title,
                    'id' => $value->id
                ]);
            }

        }

        return $array;

    }

    public function nextList($item)
    {

        $array = [];
        if (count($item->children) > 0) {

            foreach ($item->children as $val) {
                $text = [
                    'title' => $item->title . ' > ' . $val->title,
                    'id' => $val->id,
                ];

                if (count($val->children) > 0) {

                    foreach ($val->children as $val1) {

                        $text1 = [
                            'title' => $text['title'] . ' > ' . $val1->title,
                            'id' => $val1->id,
                        ];

                        array_push($array, $text1);
                    }


                } else {
                    array_push($array, $text);
                }

            }
        } else {
            return $array;
        }

        return $array;

    }


    public function pastList($item)
    {

        $array = '';

        if (!is_null($item->parent)) {

            $text = '';

            if (!is_null($item->parent->parent) && !is_null($item->parent->parent->parent)) {
                $text .= $item->parent->parent->parent->title . ' > ';
            }

            if (!is_null($item->parent->parent)) {
                $text .= $item->parent->parent->title . ' > ';
            }

            $text .= $item->parent->title . ' > ';

            $array = $text;

        } else {
            return $array;
        }

        return $array;

    }


    public function delete_photo($id, $product_id)
    {
        $item = Product::where('id', $product_id)->where('user_id', Auth::id())->first();
        if (is_null($item)) {
            abort(404);
        }

        try {

            Photo::where('model_id', $product_id)->where('id', $id)->delete();
            return redirect()->back()->with('success_message', 'تصویر حذف شد');

        } catch (Exception $e) {
            return redirect()->back()->with('error_message', 'خطا در ثبت اطلاعات لطفا در فرصتی دیگر امتحان کنید');

        }
    }

    public function search()
    {

    }


}
