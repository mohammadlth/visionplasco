<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Website;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\BuildSite\Build;
use Illuminate\Support\Facades\Log;
use PHPUnit\TextUI\Exception;
use App\Services\Sms\SendSms;

class BuildSite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $item = $this->website;
        $template = $item->template;
        $user = $item->user;

        try {

            $build = new Build();
            $response = $build->make($item->subdomain, $item->db_name, $item->db_name, $item->db_password, $template->file_path, $template->db_path , $item->user_panel , $item->password_panel);

            if ($response['success']) {
                $item->status = 1;
                $item->confirm = 1;
            } else {
                $item->status = -1;
                $item->confirm = 0;
            }
            $item->save();

            // send sms
            $sms = new SendSms();
            $sms->send($user->mobile, ['username' => $item->user_panel, 'password' => $item->password_panel], config('smsir.templates.site_build'));

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            $item->status = -1;
            $item->confirm = 0;
            $item->save();
        }


    }
}
