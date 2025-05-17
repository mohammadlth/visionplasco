<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Product;
use App\Models\PhoneViews;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use Psy\Readline\Hoa\Event;


class EventController extends Controller
{
    public function index()
    {
        $items = DB::table('todos')->orderBy('updated_at', 'desc')->paginate(20);

        return view('dashboard.event.index', compact('items'));
    }

    public function show($id)
    {
        $item = DB::table('todos')->where('id', $id)->first();

        if (is_null($item)) {
            abort(404);
        }

        return view('dashboard.event.show', compact('item'));

    }
}
