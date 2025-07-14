<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\OrderCreated as NotificationsOrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        Notification::send([$event->order->client], new NotificationsOrderCreated($event->order));
    }
}
