<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderUserPendingMail extends Mailable
{
    protected $order;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = trans('custome.mess_order_user_pending');

        return $this->from(config('custome.email_support'))
            ->markdown('admin.mail.order_pending_user', ['title' => $title, 'order' => $this->order]);
    }
}
