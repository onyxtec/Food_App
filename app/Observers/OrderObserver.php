<?php

namespace App\Observers;

use App\Models\Order;
use App\Notifications\OrderStatusUpdatedNotification;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->isDirty('status')) {
            $new_status = $order->status;
            $receiver = $order->user;
            $receiver->notify(new OrderStatusUpdatedNotification($order, $new_status));
        }
    }
}
