<?php

namespace PiotrPolak\ConditionalRoutingBundle\Model;

use PiotrPolak\ConditionalRoutingBundle\Model\RoutingDefinition\BundleRoutingDefinitionInterface;

/**
 * RouteResolverInterface should be implemented by the component who decides which bundles to be included in routing.
 *
 * @author Piotr Polak <piotr@polak.ro>
 */
interface RouteResolverInterface
{
    /**
     * This method should return an array of extra BundleRoutingDefinitionInterface instances describing bundles
     * whose routing should be conditionally loaded.
     *
     * You should place your bundle-deciding logic here.
     *
     * @return BundleRoutingDefinitionInterface[]
     */
    public function resolveConditionalRoutingDefinitions();
}
