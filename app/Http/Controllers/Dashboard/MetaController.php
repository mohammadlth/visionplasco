<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class MetaController extends Controller
{

    use Upload;

    protected $model;
    public $view = 'dashboard.meta.';
    public $route = 'meta';
    private $paginate = 15;


    public function __construct(Meta $model)
    {
        $this->model = $model;
    }

    public function index()
    {

        if (isset($_GET['search']) && $_GET['search']) {
            $items = $this->model->where('title', 'LIKE', '%' . $_GET['search'] . '%')->orwhere('title', 'LIKE', '%' . $_GET['search'])->orwhere('title', 'LIKE', $_GET['search'] . '%')->orderBy('created_at', 'desc')->paginate($this->paginate);

        } else {
            $items = $this->model->orderBy('created_at', 'desc')->paginate($this->paginate);

        }

        return View::make($this->view . 'index', compact('items'));
    }


    public function create(Request $request)
    {
        $prev_url = $request->page;
        return view($this->view . '.create', compact('prev_url'));
    }


    public function edit($id, Request $request)
    {
        $prev_url = $request->page;

        $item = $this->model->find($id);
        return view($this->view . '.edit', compact('item', 'prev_url'));


    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'path' => 'required',
            'description' => 'required',
            'og_title' => 'required',
            'og_type' => 'required',
            'og_description' => 'required',
        ]);


        $data = collect($request->all())->only(['path', 'title', 'description', 'og_title', 'og_type', 'og_description', 'og_image', 'structured_data', 'priority', 'changefreq', 'can_index'])->toArray();

        try {

            $item = new Meta($data);

            $item->save();

            return redirect()->route('meta.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ثبت شد');


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'path' => 'required',
            'description' => 'required',
            'og_title' => 'required',
            'og_type' => 'required',
            'og_description' => 'required',
        ]);

        $item = Meta::find($id);

        if (is_null($item)) {
            abort(404);
        }

        try {
            $data = collect($request->all())->only(['path', 'title', 'description', 'og_title', 'og_type', 'og_description', 'og_image', 'structured_data', 'priority', 'changefreq', 'can_index'])->toArray();

            $item->update($data);

            return redirect()->route('meta.index', ['page' => $request->prev_url])->with('success_message', 'اطلاعات با موفقیت ویرایش شد');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطایی رخ داد به پشتیبانی اطلاع رسانی کنید');
        }
    }

}
