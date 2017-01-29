<?php

namespace Piotrpolak\ConditionalRoutingBundle;

use Piotrpolak\ConditionalRoutingBundle\DependencyInjection\Compiler\RouteResolverCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PiotrpolakConditionalRoutingBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RouteResolverCompilerPass());
    }
}
