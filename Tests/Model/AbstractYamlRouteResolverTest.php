<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\AbstractYamlRouteResolver;

class AbstractYamlRouteResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $bundleNames = array('SampleBundle', 'TestBundle');
        $yamlRouteResolver = new YamlRouteResolverTestable();
        $yamlRouteResolver->setBundleNames($bundleNames);

        $definitions = $yamlRouteResolver->resolveConditionalRoutingDefinitions();

        $this->assertEquals(count($bundleNames), count($definitions));

        foreach ($definitions as $definition) {
            $this->assertInstanceOf('\\Piotrpolak\\ConditionalRoutingBundle\\Model\\RoutingDefinition\\YamlBundleRoutingDefinition', $definition);
            $search = array_search($definition->getBundleName(), $bundleNames);
            $this->assertNotFalse($search);
            unset($bundleNames[$search]);
        }
    }
}

class YamlRouteResolverTestable extends AbstractYamlRouteResolver
{
    /** @var array */
    private $bundleNames = [];

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