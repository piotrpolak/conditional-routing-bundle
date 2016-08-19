<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition;

interface BundleRoutingDefinitionInterface
{
    /**
     * Returns the full name of the bundle.
     *
     * @return string
     */
    public function getBundleName();

    /**
     * Returns a resource (path) to be loaded.
     *
     * @return string
     */
    public function getResource();

    /**
     * Returns the type of the resource to be loaded.
     * Usually yaml, xml or controller.
     *
     * @return string
     */
    public function getType();
}