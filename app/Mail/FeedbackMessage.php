<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackMessage extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $fullName;
    public ?string $phone;
    public ?string $email;
    public ?string $subjectLine;
    public ?string $messageText;
    public ?string $page;

    public function __construct(
        ?string $fullName = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $subjectLine = null,
        ?string $message = null,
        ?string $page = null,
    ) {
        $this->fullName = $fullName;
        $this->phone = $phone;
        $this->email = $email;
        $this->subjectLine = $subjectLine;
        $this->messageText = $message;
        $this->page = $page;
    }

    public function build()
    {
        $subject = $this->subjectLine ?: 'Сообщение с сайта — обратная связь';

        return $this
            ->subject($subject)
            ->view('emails.feedback')
            ->with([
                'fullName' => $this->fullName,
                'phone'    => $this->phone,
                'email'    => $this->email,
                'subject'  => $subject,
                'text'     => $this->messageText,
                'page'     => $this->page,
            ]);
    }
}

