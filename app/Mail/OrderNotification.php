<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $heading;
    public ?string $messageText;

    public function __construct(Order $order, string $subjectLine, string $heading, ?string $messageText = null)
    {
        $this->order = $order->fresh(["items"]);
        $this->subject($subjectLine);
        $this->heading = $heading;
        $this->messageText = $messageText;
    }

    public function build()
    {
        return $this->view('emails.order_notification')
            ->with([
                'order' => $this->order,
                'heading' => $this->heading,
                'messageText' => $this->messageText,
                'orderUrl' => rtrim((string) config('app.url', ''), '/') . '/order/' . $this->order->uuid,
            ]);
    }
}

