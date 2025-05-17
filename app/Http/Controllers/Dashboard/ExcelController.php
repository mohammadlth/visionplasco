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


class ExcelController extends Controller
{
    public function users()
    {
        return Excel::download(new UserExport(), 'users.xlsx');
    }
}
