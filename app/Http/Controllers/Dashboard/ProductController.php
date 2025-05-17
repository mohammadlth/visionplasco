<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chat;
use App\Models\City;
use App\Models\Product;
use App\Services\Sms\SendSms;
use App\Models\User;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use Upload;

    public function index(Request $request)
    {

        if (isset($request->s) && !is_null($request->s)) {


            $user = User::where('mobile', 'LIKE', "%{$request->s}%")->orwhere('name', 'LIKE', "%{$request->s}%")->first();

            if (!is_null($user)) {
                $items = Product::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(20);
            } elseif (str_contains($request->s, 'zgc-')) {
                $items = Product::where('category_id', (int)str_replace('zgc-', '', $request->s))->orderBy('created_at', 'desc')->paginate(20);
            } else {
                $items = Product::where('full_name', 'LIKE', "%{$request->s}%")->orderBy('created_at', 'desc')->paginate(20);
            }

        } else {
            $items = Product::orderBy('updated_at', 'desc')->paginate(20);
        }

        $params = $request->all();

        return view('dashboard.product.index', compact('items', 'params'));

    }

    public function edit($id, Request $request)
    {
        $item = Product::find($id);
        $prev_url = $request->page;

        if (is_null($item)) {
            abort(404);
        }

        $categories = Category::orderBy('created_at', 'desc')->get();

        $city = City::where('parent_id', '!=', null)->get();

        return view('dashboard.product.edit', compact('item', 'prev_url', 'categories', 'city'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|min:2|max:255',
            'slug' => 'required|string|min:2|max:255',
            'category_id' => 'required|numeric',
            'city_id' => 'required|numeric',
        ]);

        $item = Product::find($id);

        if (is_null($item)) {
            abort(404);
        }

        $city = City::find($request->city_id);

        if (is_null($city) || is_null($city->parent)) {
            return redirect()->back()->with('error_message', 'شهر یافت نشد');
        }


        try {

            $item->type = $request->type;
            $item->slug = $request->slug;
            $item->full_name = $request->full_name;
            $item->category_id = $request->category_id;
            $item->status = $request->status;
            $item->show = $request->show;
            $item->city_id = $city->id;
            $item->region_id = $city->parent->id;
            $item->inventory = $request->inventory;
            $item->min_inventory = $request->min_inventory;
            $item->min_price = $request->min_price;
            $item->description = $request->description;
            $item->description_reject = $request->description_reject;
            $item->sort = $request->sort;
            $item->show_footer = $request->show_footer;
            $item->save();

            if (isset($request->photos) && count($request->photos) > 0) {
                foreach ($request->photos as $value) {
                    $this->upload($value, 'products', $item->id);
                }
            }


            if (isset($item->getChanges()['status'])) {
                if ($request->status == 'reject') {
                    $sms = new SendSms();
                    $sms->send($item->user->mobile, ['name' => $item->user->name], config('smsir.templates.reject_product'));
                }
            }

            return redirect()->route('products.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ویرایش شد');


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }

    public function destroy($id)
    {

        $item = Product::find($id);

        if (is_null($item)) {
            abort(404);
        }

        Chat::where('refrense', 'zgp-' . $id)->delete();
        $item->delete();


        return redirect()->back()->with('success_message', 'اطلاعات با موفقیت حذف شد');

    }

    public function change_status($status, $id)
    {

        $item = Product::find($id);
        if (is_null($item)) {
            abort(404);
        }

        $item->status = $status;
        $item->save();

        return redirect()->back()->with('success_message', 'تغییر وضعیت باموفقیت انجام شد');

    }


}
