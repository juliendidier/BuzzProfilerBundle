<?php

namespace Buzz\Bundle\ProfilerBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

use Buzz\Client;

use Buzz\Bundle\ProfilerBundle\Buzz\ClientRegistry;
use Buzz\Bundle\ProfilerBundle\Buzz\DebugClient;

class ClientDataCollector implements DataCollectorInterface
{

    protected $data;
    protected $registry;

    function __construct(ClientRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array();
        
        foreach ($this->registry->getClients() as $client) {
            if ($client instanceof DebugClient) {
                $this->data[] = array(
                    'debug'     => true,
                    'class'     => $client->getParentClass(),
                    'calls'     => $client->getCalls(),
                );                
            } else {
                $this->data[] = array(
                    'debug'     => false,
                    'class'     => get_class($client),
                );                
            }
        }
    }

    public function getNbCalls()
    {
        $nbCalls = 0;
        foreach ($this->data as $client) {
            if (key_exists('calls', $client)) {
                $nbCalls+= count($client['calls']);
            }
        }

        return $nbCalls;
    }
    
    public function getData()
    {
        return $this->data;
    }

    public function getName()
    {
        return 'client';
    }

}
