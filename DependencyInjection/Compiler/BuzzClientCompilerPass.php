<?php

namespace Buzz\Bundle\ProfilerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class BuzzClientCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $ids = $container->findTaggedServiceIds('buzz.client');

        foreach ($ids as $id => $attributes) {
            $definition = $container->getDefinition($id);

            $container->register($id, $definition->getClass())
                ->setFactoryService('buzzprofiler.client_registry')
                ->setFactoryMethod('register')
                ->addArgument(new Reference($id.'_concrete'))
            ;

            $container->setDefinition($id.'_concrete', $definition);
        }
    }
}
