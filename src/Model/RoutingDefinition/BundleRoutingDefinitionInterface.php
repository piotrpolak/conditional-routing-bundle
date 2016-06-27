<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition;

interface BundleRoutingDefinitionInterface
{
    /**
     * @return string
     */
    public function getBundleName();

    /**
     * @return string
     */
    public function getResource();

    /**
     * @return string
     */
    public function getType();
}