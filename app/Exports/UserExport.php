<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\User;


class UserExport implements FromView, WithTitle, ShouldQueue
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function view(): View
    {
        $items = User::orderBy('created_at', 'desc')->get();

        return view('dashboard.exports.user', [
            'items' => $items
        ]);


    }

    public function title(): string
    {
        return 'لیست صورت حساب ها';
    }


}
