<?php

declare(strict_types=1);

namespace Evand\Email;

class Email
{
    public $subject;
    public $message;
    public $recipient;

    public function __construct(string $subject, string $message, Recipient $recipient)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->recipient = $recipient;
    }
}
