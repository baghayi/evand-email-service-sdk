<?php

declare(strict_types=1);

namespace Test\Evand\Email;

use Evand\Email\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    const SUBJECT = 'good bye party Jafare';
    const MESSAGE = 'email body';

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
        $email = new Email(self::SUBJECT, '');
        $this->assertSame(self::SUBJECT, $email->subject);
    }

    /**
    * @test
    */
    public function email_message()
    {
        $email = new Email(self::SUBJECT, self::MESSAGE);
        $this->assertSame(self::MESSAGE, $email->message);
    }
}
