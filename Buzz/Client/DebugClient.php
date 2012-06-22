<?php

namespace Buzz\Bundle\ProfilerBundle\Buzz\Client;

use Buzz\Message;
use Buzz\Client\ClientInterface;

class DebugClient implements ClientInterface
{

    protected $client;
    protected $calls;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->calls  = array();
    }

    public function send(Message\RequestInterface $request, Message\MessageInterface $response)
    {
        $start = microtime(true);
        $this->client->send($request, $response);

        $end      = microtime(true);
        $duration = ($end - $start) * 1000;

        array_push(
            $this->calls,
            array(
                'request'  => $request,
                'response' => $response,
                'duration' => $duration,
            )
        );
    }

    public function getParentClass()
    {
        return get_class($this->client);
    }

    public function getCalls()
    {
        return $this->calls;
    }

}
