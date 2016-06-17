<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\Router;

use Piotrpolak\ConditionalRoutingBundle\Router\ConditionalRoutesLoader;

class ConditionalRoutesLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyRoutesLoader()
    {
        $loader = new ConditionalRoutesLoader();
        $this->assertEquals('', $loader->getResolverKeys());
        $this->assertEquals(0, $loader->load('test')->count());
    }

    public function testSupports()
    {
        $loader = new ConditionalRoutesLoader();
        $this->assertTrue($loader->supports(null, 'conditional'));
        $this->assertFalse($loader->supports(null, 'another'));
    }
}