<?php

namespace App\Console\Commands;

use App\Jobs\SmsJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\Todos\TodoStore;


class VipAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vip:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check vip account and send sms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $user_expire_soon = User::where('ban', 0)->whereBetween('vip_expire_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(1)->startOfDay()])->get();

        foreach ($user_expire_soon as $value) {
            SmsJob::dispatch([$value->mobile, ['name' => $value->name], config('smsir.templates.vip_expire')])->onQueue('default');
        }

        $user_expire = User::where('ban', 0)->whereBetween('vip_expire_at', [Carbon::now()->subDays(10)->startOfDay(), Carbon::now()->subDays(1)->endOfDay()])->get();

        $todo = new TodoStore();

        foreach ($user_expire as $value) {

            $value->vip_account = 0;
            $value->expired = true;
            $value->save();
            $todo->store('expire_account', [
                'user_id' => $value->id,
                'name' => $value->name,
                'mobile' => $value->mobile,
                'vip_expire_at' => $value->vip_expire_at,
            ], 'اکانت اکسپایر شده ');
        }

    }
}
