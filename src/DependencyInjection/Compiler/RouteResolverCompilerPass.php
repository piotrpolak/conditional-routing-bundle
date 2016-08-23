<?php

namespace Piotrpolak\ConditionalRoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Adds tagged conditional_loader.route_resolver service support.
 *
 * @author Piotr Polak <piotr@polak.ro>
 */
class RouteResolverCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('conditional_router.routing_loader')) {
            return;
        }

        $definition = $container->findDefinition('conditional_router.routing_loader');

        $taggedServicesIds = array_keys($container->findTaggedServiceIds('conditional_loader.route_resolver'));

        foreach ($taggedServicesIds as $id) {
            $definition->addMethodCall('addRouteResolver', array(new Reference($id)));
        }
    }
}