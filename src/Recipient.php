<?php

declare(strict_types=1);

namespace Evand\Email;

use Baghayi\Value\Email;

class Recipient
{
    public $email;
    public $name;

    public function __construct(Email $email, string $name)
    {
        $this->email = $email;
        $this->name = $name;
    }
}
