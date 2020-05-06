<?php

namespace App\Notifications\User;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DeliveryOrderConfirmation extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Order Confirmation')
            ->greeting('Salaam ' . $notifiable->full_name . ',')
            ->line('Thank you for using Share Iftar.')
            ->line('Your order has been sent to ' . $this->order->collectionPoint->name . '.')
            ->line('You have ordered ' . $this->getNumOfMeals() . ' to be delivered at the following address:');

        $this->addFormattedDeliveryAddress($message);

        $message->line(new HtmlString('If you have any issues or change your mind about the order, please email us on <a href="mailto:info@shareiftar.org">info@shareiftar.org</a>.'))
                ->salutation(new HtmlString('Kind Regards,<br>Share Iftar Team'));

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    protected function getNumOfMeals()
    {
        return $this->order->quantity == 1
            ? $this->order->quantity . ' meal'
            : $this->order->quantity . ' meals';
    }

    protected function addFormattedDeliveryAddress(MailMessage $message)
    {
        $order        = $this->order->toArray();
        $addressParts = ['address_line_1', 'address_line_2', 'city', 'county', 'post_code'];
        $address      = [];

        foreach ($addressParts as $addressPart) {
            if (array_key_exists($addressPart, $order) && $order[$addressPart]) {
                $address[] = $order[$addressPart];
            }
        }

        if (count($address)) {
            $message->line(new HtmlString(implode('<br>', $address)));
        }
    }
}
