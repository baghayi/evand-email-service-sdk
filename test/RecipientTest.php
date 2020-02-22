<?php

declare(strict_types=1);

namespace Test\Evand\Email;

use Baghayi\Value\Email;
use Evand\Email\Recipient;
use PHPUnit\Framework\TestCase;

class RecipientTest extends TestCase
{
    const EMAIL = 'husen@gmail.com';

    /**
    * @test
    */
    public function recipient()
    {
        $this->assertTrue(class_exists(Recipient::class));
    }

    /**
    * @test
    */
    public function recipient_email()
    {
        $recipient = new Recipient(new Email(self::EMAIL), '');
        $this->assertInstanceof(Email::class, $recipient->email);
        $this->assertSame(self::EMAIL, (string) $recipient->email);
    }

    /**
    * @test
    */
    public function recipient_name()
    {
        $recipient = new Recipient(new Email(self::EMAIL), 'shahdana');
        $this->assertSame('shahdana', $recipient->name);
    }
}
