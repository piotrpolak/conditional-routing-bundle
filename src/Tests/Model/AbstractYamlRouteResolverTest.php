<?php

namespace PiotrPolak\ConditionalRoutingBundle\Tests\Model;

use PiotrPolak\ConditionalRoutingBundle\Model\AbstractYamlRouteResolver;

class AbstractYamlRouteResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $resolver = new AbstractYamlRouteResolverTestable();
        $definitions = $resolver->resolveConditionalRoutingDefinitions();

        $this->assertGreaterThan(0, count($definitions));
        foreach ($definitions as $definition) {
            $this->assertInstanceOf('\PiotrPolak\ConditionalRoutingBundle\Model\RoutingDefinition\YamlBundleRoutingDefinition', $definition);
        }
    }
}

class AbstractYamlRouteResolverTestable extends AbstractYamlRouteResolver
{
    /**
     * {@inheritdoc}
     */
    public function resolveBundleNames()
    {
        return array('MyTestBundle');
    }
}

