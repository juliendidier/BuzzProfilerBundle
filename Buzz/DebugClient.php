<?php

namespace Buzz\Bundle\ProfilerBundle\Buzz;

use Buzz\Message;
use Buzz\Client;

class DebugClient implements Client\ClientInterface
{

    protected $client;
    protected $calls = array();

    public function __construct(Client\ClientInterface $client)
    {
        $this->client = $client;
    }

    public function send(Message\Request $request, Message\Response $response)
    {
        $logRequest = clone $request;
        $start      = microtime(true);

        $this->client->send($request, $response);

        $end         = microtime(true);
        $duration    = ($end - $start) * 1000;
        $logResponse = clone $response;

        array_push(
            $this->calls,
            array(
                'request'  => $logRequest,
                'response' => $logResponse,
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
