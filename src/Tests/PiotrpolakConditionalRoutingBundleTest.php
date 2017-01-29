<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests;

use Piotrpolak\ConditionalRoutingBundle\DependencyInjection\Compiler\RouteResolverCompilerPass;
use Piotrpolak\ConditionalRoutingBundle\PiotrpolakConditionalRoutingBundle;

class PiotrpolakConditionalRoutingBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $containerBuilder = $this->getMock('\Symfony\Component\DependencyInjection\ContainerBuilder');
        $containerBuilder->expects($this->once())->method('addCompilerPass')->with(new RouteResolverCompilerPass());

        $bundle = new PiotrpolakConditionalRoutingBundle();
        $bundle->build($containerBuilder);
    }
}
