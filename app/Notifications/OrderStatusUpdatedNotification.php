<?php

namespace App\Notifications;

use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $order, $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($order, $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statuses = Config::get('orderstatus.order_statuses');

        $mail_message = (new MailMessage)
        ->subject('Order Status Updation Email')
        ->line('Your order has been '.$statuses[$this->status])
        ->line('Employee Name: ' . $this->order->user->name)
        ->line('Total Price: ' . $this->getTotalAmount())
        ->line('Order Details:')
        ->line('');

        foreach ($this->order->products as $cart_item) {
            $mail_message->line('Product: '.$cart_item->name.', Quantity: '.$cart_item->pivot->quantity.', Price: '.$cart_item->pivot->price.', SubTotal: '.$cart_item->pivot->price * $cart_item->pivot->quantity);
        }

        $mail_message->line('');

        return $mail_message ;

    }

    private function getTotalAmount(){
        $total = 0;
        foreach ($this->order->products as $product){
            $total += $product->pivot->quantity * $product->pivot->price;
        }
        return $total;
    }
}
