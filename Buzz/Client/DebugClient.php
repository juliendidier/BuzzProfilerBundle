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

    /**
     * intercepts method calls to the underlying client
     *
     * @param $fn the function
     * @param array $args the arguments
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function __call($fn, array $args = array())
    {
        if (method_exists($this->client, $fn)) {

            return call_user_func_array(array($this->client, $fn), $args);
        }

        throw new \InvalidArgumentException('Call to undefined method '.get_class($this).':'.$fn.'()');
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
