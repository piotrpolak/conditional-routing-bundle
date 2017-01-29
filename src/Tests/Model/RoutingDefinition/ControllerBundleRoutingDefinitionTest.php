<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\Model\RoutingDefinition;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\ControllerBundleRoutingDefinition;

class ControllerBundleRoutingDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $definition = new ControllerBundleRoutingDefinition('SampleBundle');
        $this->assertEquals('SampleBundle', $definition->getBundleName());
        $this->assertEquals('controller', $definition->getType());
        $this->assertEquals('@SampleBundle/Controller/', $definition->getResource());
    }
}
