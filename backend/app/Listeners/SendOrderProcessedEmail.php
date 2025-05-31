<?php

namespace App\Listeners;

use App\Events\OrderProcessed;
use App\Mail\OrderProcessedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderProcessedEmail implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(OrderProcessed $event): void
    {
        $adminEmail = 'admin@example.com';

        Mail::to($adminEmail)->send(new OrderProcessedMail($event->order));
    }
}
