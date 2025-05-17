<?php

namespace App\Jobs;

use App\Services\Sms\SendSms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChatNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mobile = null;
    public $username = null;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->mobile = $data[0];
        $this->username = $data[1];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $sms = new SendSms();
        $sms->send($this->mobile, ['username' => $this->username], config('smsir.templates.chat_notification'));

    }
}
