<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderPlacedMail extends Mailable implements ShouldQueue
{
    use SerializesModels, Dispatchable, Queueable;
    
    // public $afterCommit = true;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }


    public function build()
    {
        return $this->view('email.order_placed', [ 'order' => $this->order ]);
    }
}
