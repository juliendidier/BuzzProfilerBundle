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

    public function getClients()
    {
        return $this->clients;
    }

}
