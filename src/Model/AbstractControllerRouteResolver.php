<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\ControllerBundleRoutingDefinition;

abstract class AbstractControllerRouteResolver extends AbstractRouteResolver
{
    /**
     * {@inheritdoc}
     */
    protected function getRoutingDefinitionForBundleName($bundleName)
    {
        return new ControllerBundleRoutingDefinition($bundleName);
    }
}