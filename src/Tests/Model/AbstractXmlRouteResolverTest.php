<?php

namespace PiotrPolak\ConditionalRoutingBundle\Tests\Model;

use PiotrPolak\ConditionalRoutingBundle\Model\AbstractXmlRouteResolver;

class AbstractXmlRouteResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $resolver = new AbstractXmlRouteResolverTestable();
        $definitions = $resolver->resolveConditionalRoutingDefinitions();

        $this->assertGreaterThan(0, count($definitions));
        foreach ($definitions as $definition) {
            $this->assertInstanceOf('\PiotrPolak\ConditionalRoutingBundle\Model\RoutingDefinition\XmlBundleRoutingDefinition', $definition);
        }
    }
}

class AbstractXmlRouteResolverTestable extends AbstractXmlRouteResolver
{
    /**
     * {@inheritdoc}
     */
    public function resolveBundleNames()
    {
        return array('MyTestBundle');
    }
}

