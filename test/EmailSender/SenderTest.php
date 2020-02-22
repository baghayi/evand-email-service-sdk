<?php

declare(strict_types=1);

namespace Test\Evand\Email\EmailSender;

use Evand\Email\EmailSender\Sender;
use PHPUnit\Framework\TestCase;

class SenderTest extends TestCase
{
    /**
    * @test
    */
    public function email_sender()
    {
        $this->assertTrue(class_exists(Sender::class));
    }
}
