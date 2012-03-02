<?php

namespace Buzz\Bundle\ProfilerBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BuzzProfilerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DependencyInjection\Compiler\DecorateBuzzClientPass());
    }
}
