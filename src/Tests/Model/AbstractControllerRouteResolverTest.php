<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\AbstractControllerRouteResolver;

class AbstractControllerRouteResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $resolver = new AbstractControllerRouteResolverTestable();
        $definitions = $resolver->resolveConditionalRoutingDefinitions();

        $this->assertGreaterThan(0, count($definitions));
        foreach ($definitions as $definition) {
            $this->assertInstanceOf('\Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\ControllerBundleRoutingDefinition', $definition);
        }
    }
}

class AbstractControllerRouteResolverTestable extends AbstractControllerRouteResolver
{
    /**
     * {@inheritdoc}
     */
    public function resolveBundleNames()
    {
        return array('MyTestBundle');
    }
}
