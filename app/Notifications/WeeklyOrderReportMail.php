<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeeklyOrderReportMail extends Notification implements ShouldQueue
{
    use Queueable;
    private $employee;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $employee)
    {
        $this->employee = $employee;
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

        $total = 0;
        $mail_message = (new MailMessage)
        ->subject('Weekly Orders Report')
        ->line($this->employee->name."!".' Your auto generated weekly orders report is here.')
        ->line('Weekly Cost: '.$this->getTotalAmount(). " Rs.")
        ->line('Order Details:')
        ->line('');

        foreach($this->employee->orders as $key => $order){
            $mail_message->line('Order: ' . $key + 1);
            foreach($order->products as $cart_item){
                $mail_message->line('Product: '.$cart_item->name.', Quantity: '.$cart_item->pivot->quantity.', Price: '.$cart_item->pivot->price);
                $total += $cart_item->pivot->quantity * $cart_item->pivot->price;
            }
            $mail_message->line('Total: '. $total. " Rs.");
            $total = 0;
        }

        $mail_message->line('');
        return $mail_message ;
    }

    private function getTotalAmount(){
        $orders = $this->employee->orders;
        $total = 0;
        foreach ($orders as $order){
            foreach ($order->products as $cart_item){
                $total += $cart_item->pivot->quantity * $cart_item->pivot->price;
            }
        }
        return $total;
    }
}
