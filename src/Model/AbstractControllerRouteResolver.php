<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\ControllerBundleRoutingDefinition;

/**
 * AbstractXmlRouteResolver provides a way to load routing of controller type easier.
 *
 * The main logic should be placed in the AbstractRouteResolver::resolveBundleNames() method.
 *
 * @author Piotr Polak <piotr@polak.ro>
 */
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