<?php

namespace Buzz\Bundle\ProfilerBundle\Tests\Buzz\Client;

use Buzz\Bundle\ProfilerBundle\Buzz\Client\DebugClient;

class DebugClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $debugClient;
    private $request;
    private $response;

    public function setUp()
    {
        $this->client = \Mockery::mock('Buzz\Client\ClientInterface');
        $this->request = \Mockery::mock('Buzz\Message\RequestInterface');
        $this->response = \Mockery::mock('Buzz\Message\MessageInterface');
        $this->response->shouldReceive('getContent')->andReturn('test response content')->byDefault();

        $this->debugClient = new DebugClient($this->client);
    }

    public function test_that_send_collects_data_if_client_throws_ClientException()
    {
        $exceptionMessage = 'test exception message';
        $this->client->shouldReceive('send')->once()->with($this->request, $this->response)->andThrow('Buzz\Exception\ClientException', $exceptionMessage);
        $this->response->shouldReceive('setContent')->once()->with($exceptionMessage);

        $this->debugClient->send($this->request, $this->response);
        $calls = $this->debugClient->getCalls();
        $this->assertSame($this->request, $calls[0]['request']);
        $this->assertSame($this->response, $calls[0]['response']);
    }
}
