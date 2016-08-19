<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\AbstractRouteResolver;
use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\YamlBundleRoutingDefinition;

class AbstractRouteResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $bundleNames = array('SampleBundle', 'TestBundle');
        $yamlRouteResolver = new AbstractRouteResolverTestable();
        $yamlRouteResolver->setBundleNames($bundleNames);

        $definitions = $yamlRouteResolver->resolveConditionalRoutingDefinitions();

        $this->assertEquals(count($bundleNames), count($definitions));

        foreach ($definitions as $definition) {
            $search = array_search($definition->getBundleName(), $bundleNames);
            $this->assertNotFalse($search);
            unset($bundleNames[$search]);
        }
    }
}

class AbstractRouteResolverTestable extends AbstractRouteResolver
{
    /** @var array */
    private $bundleNames = array();

    /**
     * @inheritdoc
     */
    protected function getRoutingDefinitionForBundleName($bundleName)
    {
        // Just for testing, do not stick to the type!!!111
        return new YamlBundleRoutingDefinition($bundleName);
    }

    /**
     * @param array $bundleNames
     */
    public function setBundleNames($bundleNames)
    {
        $this->bundleNames = $bundleNames;
    }

    /**
     * @inheritdoc
     */
    public function resolveBundleNames()
    {
        return $this->bundleNames;
    }
}