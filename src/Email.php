<?php

declare(strict_types=1);

namespace Evand\Email;

class Email
{
    public $subject;
    public $message;

    public function __construct(string $subject, string $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }
}
