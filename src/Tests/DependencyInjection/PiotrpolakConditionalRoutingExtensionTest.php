<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\DependencyInjection;

use Piotrpolak\ConditionalRoutingBundle\DependencyInjection\PiotrpolakConditionalRoutingExtension;
use Piotrpolak\ConditionalRoutingBundle\Tests\BaseConditionalRoutingBundleTestCase;

class PiotrpolakConditionalRoutingExtensionTest extends BaseConditionalRoutingBundleTestCase
{
    public function testDefault()
    {
        $extension = new PiotrpolakConditionalRoutingExtension();
        $extension->load(array(), $this->getContainerBuilderMock());
    }
}
