<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\OrderCreatedNotification;
use Exception;
use Illuminate\Support\Facades\Log;

class SendOrderCreatedNotification
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
        $order = $event->order;
        $user = $order->user;
        try {
            $user->notify(new OrderCreatedNotification($order));
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
