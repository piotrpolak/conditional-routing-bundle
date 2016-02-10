<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model;

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