<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests\Router;

use Piotrpolak\ConditionalRoutingBundle\Router\ConditionalRoutesLoader;

class ConditionalRoutesLoaderTestable extends ConditionalRoutesLoader
{
    /**
     * @inheritdoc
     */
    public function import($resource, $type = null)
    {
        return new \Symfony\Component\Routing\RouteCollection();
    }
}