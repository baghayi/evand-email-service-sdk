<?php

declare(strict_types=1);

namespace Test\Evand\Email;

use Evand\Email\Recipient;
use PHPUnit\Framework\TestCase;

class RecipientTest extends TestCase
{
    /**
    * @test
    */
    public function recipient()
    {
        $this->assertTrue(class_exists(Recipient::class));
    }
}
