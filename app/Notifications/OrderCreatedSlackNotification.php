<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Cart;

class OrderCreatedSlackNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable): SlackMessage
    {
        $cartItems = $this->order->products;
        $totalCost = \Cart::getTotal();

        $slackMessage = (new SlackMessage)->content('New order created');
        $attachments = [];

        $orderAttachment = (new SlackAttachment)->title('Order Details')->fields([
            'Employee Name' => $this->order->user->name,
            'Total Price' => $totalCost,
        ]);

        $attachments[] = $orderAttachment;

        foreach ($cartItems as $cartItem) {
            $productAttachment = (new SlackAttachment)->fields([
                'Product' => $cartItem->name,
                'Quantity' => $cartItem->pivot->quantity,
                'Price per unit' => $cartItem->price,
            ]);

            $attachments[] = $productAttachment;
        }

        $slackMessage->attachments = $attachments;

        return $slackMessage;
    }
}
