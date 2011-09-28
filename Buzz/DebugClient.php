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
        $this->client->send($request, $response);
        $logResponse = clone $response;
        
        array_push(
            $this->calls,
            array(
                'request'   => $logRequest,
                'response'  => $logResponse,
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
