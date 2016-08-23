<?php

namespace Piotrpolak\ConditionalRoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Adds tagged conditional_router.routing_loader service support.
 *
 * @author Piotr Polak <piotr@polak.ro>
 */
class MethodHandlerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $key = 'conditional_router.routing_loader';

        if (!$container->has($key)) {
            return;
        }

        $definition = $container->findDefinition($key);

        $taggedServicesIds = array_keys($container->findTaggedServiceIds($key));

        foreach ($taggedServicesIds as $id) {
            $definition->addMethodCall('addRouteResolver', array(new Reference($id)));
        }
    }
}