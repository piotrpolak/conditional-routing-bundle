<?php

namespace PiotrPolak\ConditionalRoutingBundle\Tests\Router;

use PiotrPolak\ConditionalRoutingBundle\Router\ConditionalRoutesLoader;
use Symfony\Component\Routing\RouteCollection;

class ConditionalRoutesLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyRoutesLoader()
    {
        $loader = new ConditionalRoutesLoader();
        $this->assertEquals('', $loader->getResolverKeys());
        $this->assertEquals(0, $loader->load('test')->count());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testMultipleCallsException()
    {
        $loader = new ConditionalRoutesLoader();
        $this->assertEquals('', $loader->getResolverKeys());
        $this->assertEquals(0, $loader->load('test')->count());
        $this->assertEquals(0, $loader->load('test')->count());
    }

    public function testSupports()
    {
        $loader = new ConditionalRoutesLoader();
        $this->assertTrue($loader->supports(null, 'conditional'));
        $this->assertFalse($loader->supports(null, 'another'));
    }

    public function testOneBundle()
    {
        $definition = $this->getMock('\PiotrPolak\ConditionalRoutingBundle\Model\RoutingDefinition\BundleRoutingDefinitionInterface');
        $definition->expects($this->any())->method('getBundleName')->willReturn('SampleBundle');
        $definition->expects($this->any())->method('getResource')->willReturn('@SampleBundle/Resources/config/routing.yml');
        $definition->expects($this->any())->method('getType')->willReturn('yaml');

        $routeResolver = $this->getMock('\PiotrPolak\ConditionalRoutingBundle\Model\RouteResolverInterface');
        $routeResolver->expects($this->atLeastOnce())
            ->method('resolveConditionalRoutingDefinitions')
            ->willReturn(array($definition));

        $loader = new ConditionalRoutesLoaderTestable();
        $loader->addRouteResolver($routeResolver);
        $this->assertCount(1, $loader->getRouteResolvers());

        $loader->setRouteResolvers($loader->getRouteResolvers());
        $this->assertCount(1, $loader->getRouteResolvers());

        $this->assertEquals('__SampleBundle', $loader->getResolverKeys());
        $this->assertEquals(0, $loader->load('test')->count());
    }

    public function testTwoBundles()
    {
        $definition = $this->getMock('\PiotrPolak\ConditionalRoutingBundle\Model\RoutingDefinition\BundleRoutingDefinitionInterface');
        $definition->expects($this->any())->method('getBundleName')->willReturn('SampleBundle');
        $definition->expects($this->any())->method('getResource')->willReturn('@SampleBundle/Resources/config/routing.yml');
        $definition->expects($this->any())->method('getType')->willReturn('yaml');

        $definition2 = $this->getMock('\PiotrPolak\ConditionalRoutingBundle\Model\RoutingDefinition\BundleRoutingDefinitionInterface');
        $definition2->expects($this->any())->method('getBundleName')->willReturn('AAASecondSampleBundle');
        $definition2->expects($this->any())->method('getResource')->willReturn('@SampleBundle/Resources/config/routing.yml');
        $definition2->expects($this->any())->method('getType')->willReturn('yaml');

        $routeResolver = $this->getMock('\PiotrPolak\ConditionalRoutingBundle\Model\RouteResolverInterface');
        $routeResolver->expects($this->atLeastOnce())
            ->method('resolveConditionalRoutingDefinitions')
            ->willReturn(array($definition, $definition2));

        $loader = new ConditionalRoutesLoaderTestable();
        $loader->addRouteResolver($routeResolver);
        $this->assertCount(1, $loader->getRouteResolvers());

        $loader->setRouteResolvers($loader->getRouteResolvers());
        $this->assertCount(1, $loader->getRouteResolvers());

        $this->assertEquals('__AAASecondSampleBundle__SampleBundle', $loader->getResolverKeys());
        $this->assertEquals(0, $loader->load('test')->count());
    }
}

class ConditionalRoutesLoaderTestable extends ConditionalRoutesLoader
{
    /**
     * {@inheritdoc}
     */
    public function import($resource, $type = null)
    {
        return new RouteCollection();
    }
}
