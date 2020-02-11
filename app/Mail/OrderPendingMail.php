<?php

namespace App\Mail;

use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPendingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $orders;

    /**
     * Create a new message instance.
     *
     * @param $orders
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = trans('custome.order_not_handle_week');

        return $this->from(config('custome.email_support'))
            ->markdown('admin.mail.order_pending', ['title' => $title, 'orders' => $this->orders]);
    }
}
