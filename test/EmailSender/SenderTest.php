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
    const ACCESS_TOKEN = 'some_strong_random_string';

    private $sender;
    private $container = [];

    public function setUp(): void
    {
        $client = $this->configureGuzzle($this->container);
        $this->sender = new Sender($client, self::ACCESS_TOKEN);
    }

    public function tearDown(): void
    {
        $this->container = [];
    }

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
        $this->sender->send(new Email(self::SUBJECT, self::MSG, new Recipient(new EmailAddress(self::RECIPIENT_EMAIL), self::RECIPIENT_NAME)));

        $this->assertSame('POST', $this->container[0]['request']->getMethod());
        $this->assertSame(self::RESOURCE_URI, (string) $this->container[0]['request']->getUri());
        $request_body = $this->getRequestBody($this->container);
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
        $this->sender->send(new Email('', '', new Recipient(new EmailAddress(self::RECIPIENT_EMAIL), ''), self::TAG));
        $request_body = $this->getRequestBody($this->container);
        $this->assertSame(self::TAG, $request_body->tag);
    }

    /**
    * @test
    */
    public function authenticates()
    {
        $this->sender->send(new Email('', '', new Recipient(new EmailAddress(self::RECIPIENT_EMAIL), '')));
        $headers = $this->container[0]['request']->getHeaders();
        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertSame(sprintf('Handmade %s', self::ACCESS_TOKEN), $headers['Authorization'][0]);
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
