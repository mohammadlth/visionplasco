<?php

namespace App\Jobs;

use App\Services\Sms\SendSms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mobile = null;
    public $params = [];
    public $template = 0;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->mobile = $data[0];
        $this->params = $data[1];
        $this->template = $data[2];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sms = new SendSms();
        $sms->send($this->mobile, $this->params, $this->template);
    }
}
