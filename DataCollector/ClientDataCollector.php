<?php

namespace Buzz\Bundle\ProfilerBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

use Buzz\Bundle\ProfilerBundle\Buzz\Client\ClientRegistry;
use Buzz\Bundle\ProfilerBundle\Buzz\Client\DebugClient;

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
            if (!$client instanceof DebugClient) {
                throw new \Exception('You must collect only clients decorated by DebugClient class');
            }

            $this->data[] = array(
                'debug' => true,
                'class' => $client->getParentClass(),
                'calls' => $client->getCalls(),
            );
        }
    }

    public function getNbCalls()
    {
        $nbCalls = 0;

        foreach ($this->data as $client) {
            if (isset($client['calls']) && is_array($client['calls'])) {
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
        return 'buzz_client';
    }
}
