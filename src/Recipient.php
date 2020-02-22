<?php

declare(strict_types=1);

namespace Evand\Email;

use Baghayi\Value\Email;

class Recipient
{
    public $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }
}
