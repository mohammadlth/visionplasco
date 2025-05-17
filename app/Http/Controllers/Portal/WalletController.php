<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $invoice = Invoice::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(8);
        return view('portal.wallet.index', compact('invoice'));

    }


}
