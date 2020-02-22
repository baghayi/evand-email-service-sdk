<?php

declare(strict_types=1);

namespace Test\Evand\Email;

use Evand\Email\Email;
use Baghayi\Value\Email as EmailAddress;
use Evand\Email\Recipient;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    const SUBJECT = 'good bye party Jafare';
    const MESSAGE = 'email body';
    const EMAIL = 'husen@google.com';
    private $recipient;

    public function setUp(): void
    {
        $this->recipient = new Recipient(new EmailAddress(self::EMAIL), 'husen');
    }

    /**
    * @test
    */
    public function email()
    {
        $this->assertTrue(class_exists(Email::class));
    }

    /**
    * @test
    */
    public function email_subject()
    {
        $email = new Email(self::SUBJECT, '', $this->recipient);
        $this->assertSame(self::SUBJECT, $email->subject);
    }

    /**
    * @test
    */
    public function email_message()
    {
        $email = new Email(self::SUBJECT, self::MESSAGE, $this->recipient);
        $this->assertSame(self::MESSAGE, $email->message);
    }

    /**
    * @test
    */
    public function email_recipient()
    {
        $recipient = new Recipient(new EmailAddress(self::EMAIL), 'husen');
        $email = new Email('', '', $recipient);
        $this->assertSame($recipient, $email->recipient);
    }
}
