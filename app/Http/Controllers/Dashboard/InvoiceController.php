<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request->s) && !is_null($request->s)) {

            $items = Invoice::where('title', 'LIKE', "%{$request->s}%")->orderBy('created_at', 'desc')->paginate(20);

        } else {

            $items = Invoice::orderBy('created_at', 'desc')->paginate(20);

        }

        $params = $request->all();

        return view('dashboard.invoice.index', compact('items', 'params'));

    }
}
