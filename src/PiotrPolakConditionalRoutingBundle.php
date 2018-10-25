<?php

namespace PiotrPolak\ConditionalRoutingBundle;

use PiotrPolak\ConditionalRoutingBundle\DependencyInjection\Compiler\RouteResolverCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PiotrPolakConditionalRoutingBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RouteResolverCompilerPass());
    }
}
