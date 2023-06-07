<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Cart;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable)
    {
        return ['mail', 'slack'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $cart_items = $this->order->products;
        $totalCost = \Cart::getTotal();

        $mail_message = (new MailMessage)
        ->subject('Order Creation Email')
        ->line('Your order has been created.')
        ->line('Employee Name: ' . $this->order->user->name)
        ->line('Total Price: ' . $totalCost)
        ->line('Order Details:')
        ->line('');

        foreach ($cart_items as $cart_item) {
            $mail_message->line('Product: '.$cart_item->name.', Quantity: '.$cart_item->pivot->quantity.', Price: '.$cart_item->pivot->price);
        }

        $mail_message->line('');

        return $mail_message ;
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
