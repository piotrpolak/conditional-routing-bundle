<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests;

use Piotrpolak\ConditionalRoutingBundle\DependencyInjection\Compiler\RouteResolverCompilerPass;
use Piotrpolak\ConditionalRoutingBundle\PiotrpolakConditionalRoutingBundle;

class PiotrpolakConditionalRoutingBundleTest extends BaseConditionalRoutingBundleTestCase
{
    public function testDefault()
    {
        $containerBuilder = $this->getContainerBuilderMock();
        $containerBuilder->expects($this->once())->method('addCompilerPass')->with(new RouteResolverCompilerPass());

        $bundle = new PiotrpolakConditionalRoutingBundle();
        $bundle->build($containerBuilder);
    }
}
