<?php

namespace Piotrpolak\ConditionalRoutingBundle\DependencyInjection\Compiler;

class MethodHandlerCompilerPassTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $definition = $this->getMock('\Symfony\Component\DependencyInjection\Definition');
        $definition->expects($this->once())->method('addMethodCall');

        $containerBuilder = $this->getMock('\Symfony\Component\DependencyInjection\ContainerBuilder');

        $containerBuilder
            ->expects($this->once())
            ->method('has')
            ->with('conditional_router.routing_loader')
            ->willReturn(true);

        $containerBuilder
            ->expects($this->once())
            ->method('findDefinition')
            ->with('conditional_router.routing_loader')
            ->willReturn($definition);

        $containerBuilder
            ->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with('conditional_loader.route_resolver')
            ->willReturn(array('idValue' => null));

        $compilerPass = new MethodHandlerCompilerPass();
        $compilerPass->process($containerBuilder);
    }

    public function testNoDefinition()
    {
        $definition = $this->getMock('\Symfony\Component\DependencyInjection\Definition');
        $definition->expects($this->never())->method('addMethodCall');

        $containerBuilder = $this->getMock('\Symfony\Component\DependencyInjection\ContainerBuilder');

        $containerBuilder
            ->expects($this->once())
            ->method('has')
            ->with('conditional_router.routing_loader')
            ->willReturn(false);

        $containerBuilder
            ->expects($this->never())
            ->method('findDefinition')
            ->with('conditional_router.routing_loader')
            ->willReturn($definition);

        $containerBuilder
            ->expects($this->never())
            ->method('findTaggedServiceIds')
            ->with('conditional_loader.route_resolver')
            ->willReturn(array('idValue' => null));

        $compilerPass = new MethodHandlerCompilerPass();
        $compilerPass->process($containerBuilder);
    }
}