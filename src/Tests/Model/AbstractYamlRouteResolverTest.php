<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\AbstractYamlRouteResolver;

class AbstractYamlRouteResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $resolver = new AbstractYamlRouteResolverTestable();
        $definitions = $resolver->resolveConditionalRoutingDefinitions();
        $this->assertGreaterThan(0, count($definitions));
        foreach ($definitions as $definition) {
            $this->assertInstanceOf('\Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\YamlBundleRoutingDefinition', $definition);
        }
    }
}

class AbstractYamlRouteResolverTestable extends AbstractYamlRouteResolver
{
    /**
     * @inheritdoc
     */
    public function resolveBundleNames()
    {
        return array('MyTestBundle');
    }
}
