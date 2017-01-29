<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\Model\RoutingDefinition;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\YamlBundleRoutingDefinition;

class YamlBundleRoutingDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $definition = new YamlBundleRoutingDefinition('SampleBundle');
        $this->assertEquals('SampleBundle', $definition->getBundleName());
        $this->assertEquals('yaml', $definition->getType());
        $this->assertEquals('@SampleBundle/Resources/config/routing.yml', $definition->getResource());
    }
}
