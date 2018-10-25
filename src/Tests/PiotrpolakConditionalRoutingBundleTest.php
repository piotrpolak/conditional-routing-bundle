<?php

namespace PiotrPolak\ConditionalRoutingBundle\Tests;

use PiotrPolak\ConditionalRoutingBundle\DependencyInjection\Compiler\RouteResolverCompilerPass;
use PiotrPolak\ConditionalRoutingBundle\PiotrPolakConditionalRoutingBundle;

class PiotrPolakConditionalRoutingBundleTest extends BaseConditionalRoutingBundleTestCase
{
    public function testDefault()
    {
        $containerBuilder = $this->getContainerBuilderMock();
        $containerBuilder->expects($this->once())->method('addCompilerPass')->with(new RouteResolverCompilerPass());

        $bundle = new PiotrPolakConditionalRoutingBundle();
        $bundle->build($containerBuilder);
    }
}
