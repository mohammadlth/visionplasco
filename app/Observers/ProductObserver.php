<?php

namespace App\Observers;

use App\Jobs\SmsJob;
use App\Models\Product;
use App\Models\User;

class ProductObserver
{

    public function created(Product $product){

        $user = User::where('is_admin' , true)->get();
        foreach ($user as $value){
            SmsJob::dispatch([$value->mobile, ['username' => $product->user->name], config('smsir.templates.store_product')])->onQueue('default');
        }

    }
    public function updated(Product $product)
    {
        $changes = $product->getChanges();

        if (isset($changes['status'])){
            SmsJob::dispatch([$product->user->mobile, ['name' => $product->full_name, 'status' => $this->status_fa($product->status)], config('smsir.templates.status_product')])->onQueue('default');
        }

    }

    public function status_fa($status)
    {
        if ($status == 'confirm') {
            return 'تایید شده';
        } elseif ($status == 'reject') {
            return 'رد شده';
        } elseif ($status == 'waiting') {
            return 'در حال بررسی';
        }
    }

}
