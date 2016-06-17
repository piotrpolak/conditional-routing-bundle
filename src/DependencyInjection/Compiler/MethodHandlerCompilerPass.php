<?php

namespace Piotrpolak\ConditionalRoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class MethodHandlerCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('conditional_loader')) {
            return;
        }

        $definition = $container->findDefinition('conditional_loader');

        $taggedServices = $container->findTaggedServiceIds('conditional_loader.route_resolver');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addMethodHandler', array(new Reference($id)));
        }
    }
}