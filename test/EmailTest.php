<?php

declare(strict_types=1);

namespace Test\Evand\Email;

use Evand\Email\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
    * @test
    */
    public function email()
    {
        $this->assertTrue(class_exists(Email::class));
    }
}
