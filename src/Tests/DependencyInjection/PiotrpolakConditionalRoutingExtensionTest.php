<?php

namespace PiotrPolak\ConditionalRoutingBundle\Tests\DependencyInjection;

use PiotrPolak\ConditionalRoutingBundle\DependencyInjection\PiotrPolakConditionalRoutingExtension;
use PiotrPolak\ConditionalRoutingBundle\Tests\BaseConditionalRoutingBundleTestCase;

class PiotrPolakConditionalRoutingExtensionTest extends BaseConditionalRoutingBundleTestCase
{
    public function testDefault()
    {
        $extension = new PiotrPolakConditionalRoutingExtension();
        $extension->load(array(), $this->getContainerBuilderMock());
    }
}
