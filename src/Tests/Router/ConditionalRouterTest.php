<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\Router;

use Piotrpolak\ConditionalRoutingBundle\Router\ConditionalRouter;

class ConditionalRouterTest extends \PHPUnit_Framework_TestCase
{
    public function testOptionsNotOverwriteWrongLoader()
    {
        $containerInterface = $this->getMock('\Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('has')->with('conditional_router.routing_loader')->willReturn(false);
        $router = new ConditionalRouter($containerInterface, '');

        $this->assertEquals('ProjectUrlMatcher', $router->getOption('matcher_cache_class'));
        $this->assertEquals('ProjectUrlGenerator', $router->getOption('generator_cache_class'));

        $router->setOption('matcher_cache_class', 'ProjectUrlMatcher');
        $router->setOption('generator_cache_class', 'ProjectUrlGenerator');

        $this->assertEquals('ProjectUrlMatcher', $router->getOption('matcher_cache_class'));
        $this->assertEquals('ProjectUrlGenerator', $router->getOption('generator_cache_class'));
    }

    public function testOptionsOverwrite()
    {
        $suffix = '__NamespaceConditionalSampleBundle';
        $loader = $this->getMock('\Piotrpolak\ConditionalRoutingBundle\Router\ConditionalRoutesLoader');
        $loader->expects($this->any())->method('getResolverKeys')->willReturn($suffix);
        $containerInterface = $this->getMock('\Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('has')->with('conditional_router.routing_loader')->willReturn(true);
        $containerInterface->expects($this->any())->method('get')->with('conditional_router.routing_loader')->willReturn($loader);
        $router = new ConditionalRouter($containerInterface, '');

        $this->assertEquals('ProjectUrlMatcher' . $suffix, $router->getOption('matcher_cache_class'));
        $this->assertEquals('ProjectUrlGenerator' . $suffix, $router->getOption('generator_cache_class'));

        $router->setOption('matcher_cache_class', 'XXXProjectUrlMatcher');
        $router->setOption('generator_cache_class', 'XXXProjectUrlGenerator');

        $this->assertEquals('XXXProjectUrlMatcher' . $suffix, $router->getOption('matcher_cache_class'));
        $this->assertEquals('XXXProjectUrlGenerator' . $suffix, $router->getOption('generator_cache_class'));
    }
}
