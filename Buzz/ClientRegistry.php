<?php

namespace Buzz\Bundle\ProfilerBundle\Buzz;

use Buzz\Client\ClientInterface;

class ClientRegistry
{

    protected $clients = array();

    public function register(ClientInterface $client)
    {
        array_push($this->clients, $client);
    }

    public function decorateAndRegister(ClientInterface $client, $class = null)
    {
        $decoratorClass = $class ?: 'Buzz\Bundle\ProfilerBundle\Buzz\DebugClient';

        $debugClient = new $decoratorClass($client);
        $this->register($debugClient);

        return $debugClient;
    }

    public function getClients()
    {
        return $this->clients;
    }

}
