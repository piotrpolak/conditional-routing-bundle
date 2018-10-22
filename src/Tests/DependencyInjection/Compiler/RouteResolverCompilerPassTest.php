<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\DependencyInjection\Compiler;

use Piotrpolak\ConditionalRoutingBundle\DependencyInjection\Compiler\RouteResolverCompilerPass;
use Piotrpolak\ConditionalRoutingBundle\Tests\BaseConditionalRoutingBundleTestCase;

class RouteResolverCompilerPassTest extends BaseConditionalRoutingBundleTestCase
{
    public function testDefault()
    {
        $definition = $this->getMockBuilder('\Symfony\Component\DependencyInjection\Definition')
            ->setMethods(array ('addMethodCall'))
            ->getMock();

        $definition->expects($this->once())->method('addMethodCall');

        $containerBuilder = $this->getContainerBuilderMock();

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

        $compilerPass = new RouteResolverCompilerPass();
        $compilerPass->process($containerBuilder);
    }

    public function testNoDefinition()
    {
        $definition = $this->getMock('\Symfony\Component\DependencyInjection\Definition');
        $definition->expects($this->never())->method('addMethodCall');

        $containerBuilder = $this->getContainerBuilderMock();

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

        $compilerPass = new RouteResolverCompilerPass();
        $compilerPass->process($containerBuilder);
    }
}
