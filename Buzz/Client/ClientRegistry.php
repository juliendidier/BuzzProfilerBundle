<?php

namespace Buzz\Bundle\ProfilerBundle\Buzz\Client;

use Buzz\Client\ClientInterface;

class ClientRegistry
{
    protected $clients = array();

    /**
     * Register client
     *
     * @param ClientInterface $client
     */
    public function register(ClientInterface $client)
    {
        $client = $this->decorate($client);

        array_push($this->clients, $client);

        return $client;
    }

    /**
     * Returns all registered clients
     *
     * @return array
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Decorate client
     *
     * @param ClientInterface $client
     * @param type $class
     * @return DebugClient decoratorClass
     */
    protected function decorate(ClientInterface $client, $class = null)
    {
        $decoratorClass = $class ?: 'Buzz\Bundle\ProfilerBundle\Buzz\Client\DebugClient';

        return new $decoratorClass($client);
    }
}
