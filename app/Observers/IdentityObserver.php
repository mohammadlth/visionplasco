<?php

namespace App\Observers;

use App\Jobs\SmsJob;
use App\Models\Identity;
use App\Models\User;

class IdentityObserver
{
    public function created(Identity $identity): void
    {
        $user = User::where('is_admin', true)->get();
        foreach ($user as $value) {
            SmsJob::dispatch([$value->mobile, ['username' => $identity->user->name], config('smsir.templates.admin_identity_status')])->onQueue('default');
        }
    }

    public function updated(Identity $identity): void
    {
        $changes = $identity->getChanges();

        if (isset($changes['status'])) {
            SmsJob::dispatch([$identity->user->mobile, ['status' => $this->status_fa($identity->status)], config('smsir.templates.identity_status')])->onQueue('default');
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
