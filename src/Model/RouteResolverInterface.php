<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model;

/**
 * RouteResolverInterface should be implemented by the component who decides which bundles to be included in routing.
 */
interface RouteResolverInterface
{
    /**
     * This method should return an array of extra bundle names whose routing should be conditionally loaded.
     * You should place your bundle-deciding logic here.
     *
     * @return string[]
     */
    public function resolveBundleNames();
}