<?php

namespace App\Observers;

use App\Models\Balance;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    public function created(User $user)
    {
        /** make balance */

        $item = new Balance();
        $item->balance = 0;
        $item->user_id = $user->id;
        $item->save();


        /** insert info */
        DB::table('users_info')->insert([
            'user_id' => $user->id
        ]);

    }

    public function updated(User $user)
    {
        $change = $user->getChanges();
        if (isset($change['expire']) && $change['expire'] == true) {
            $products = Product::where('user_id', $user->id)->get();
            foreach ($products as $value) {
                $value->show = 0;
                $value->save();
            }

        }

        if (isset($change['expire']) && $change['expire'] == false) {
            $products = Product::where('user_id', $user->id)->get();
            foreach ($products as $value) {
                $value->show = 1;
                $value->save();
            }
        }

    }

}
