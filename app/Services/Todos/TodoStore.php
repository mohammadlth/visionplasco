<?php

namespace App\Services\Todos;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TodoStore
{
    public function store($action, $params, $title)
    {
        DB::table('todos')->insert([
            'action' => $action,
            'params' => json_encode($params),
            'title' => $title,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return true;
    }
}
