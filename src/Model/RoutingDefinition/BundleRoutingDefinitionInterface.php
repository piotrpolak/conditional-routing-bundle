<?php

namespace PiotrPolak\ConditionalRoutingBundle\Model\RoutingDefinition;

/**
 * Represents a routing block having a bundle name, type and the resolved resource (path).
 *
 * @author Piotr Polak <piotr@polak.ro>
 */
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
