<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mailable;
    private $user;

    public function __construct($mailable, $user)
    {
        $this->mailable = $mailable;
        $this->user = $user;
    }


    public function handle()
    {
        // $email = new EmailForQueuing();
        Mail::to($this->user['email'])->send($this->mailable);
    }
}
