<?php

declare(strict_types=1);

namespace Evand\Email;

class Email
{
    public $subject;

    public function __construct(string $subject)
    {
        $this->subject = $subject;
    }
}
