<?php

declare(strict_types=1);

namespace Test\Evand\Email\EmailSender;

use Baghayi\Value\Email as EmailAddress;
use Evand\Email\Email;
use Evand\Email\EmailSender\Sender;
use Evand\Email\Recipient;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SenderTest extends TestCase
{
    const RECIPIENT_EMAIL = 'not_husen_and_hamidreza@evand.com';
    const RECIPIENT_NAME = 'husen';
    const SUBJECT = 'f**k bye';
    const MSG = 'Husen\'s last days in evand.';
    const RESOURCE_URI = 'https://kaftar.evand.com/api/send-email';
    const TAG = 'pofak';

    /**
    * @test
    */
    public function email_sender()
    {
        $this->assertTrue(class_exists(Sender::class));
    }

    /**
    * @test
    */
    public function send_an_email()
    {
        $container = [];
        $client = $this->configureGuzzle($container);
        $sender = new Sender($client);
        $sender->send(new Email(self::SUBJECT, self::MSG, new Recipient(new EmailAddress(self::RECIPIENT_EMAIL), self::RECIPIENT_NAME)));

        $this->assertNotEmpty($container);
        $this->assertSame('POST', $container[0]['request']->getMethod());
        $this->assertSame(self::RESOURCE_URI, (string) $container[0]['request']->getUri());
        $request_body = $this->getRequestBody($container);
        $this->assertNotEmpty($request_body);
        $this->assertSame(self::SUBJECT, $request_body->subject);
        $this->assertSame(self::MSG, $request_body->message);
        $this->assertSame(self::RECIPIENT_NAME, $request_body->recipient->name);
        $this->assertSame(self::RECIPIENT_EMAIL, $request_body->recipient->email);
    }

    /**
    * @test
    */
    public function could_tag_an_email()
    {
        $container = [];
        $client = $this->configureGuzzle($container);
        $sender = new Sender($client);
        $sender->send(new Email('', '', new Recipient(new EmailAddress(self::RECIPIENT_EMAIL), ''), self::TAG));
        $request_body = $this->getRequestBody($container);
        $this->assertSame(self::TAG, $request_body->tag);
    }

    private function configureGuzzle(array &$container): Client
    {
        $history = Middleware::history($container);
        $mock = new MockHandler([ new Response(200) ]);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);
        $client = new Client(['handler' => $handlerStack]);
        return $client;
    }

    private function getRequestBody(array $container)
    {
        $request_body = json_decode((string) $container[0]['request']->getBody());
        return $request_body;
    }
}
