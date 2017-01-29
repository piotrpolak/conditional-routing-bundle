<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition;

/**
 * Represents a routing block of YAML type.
 *
 * @author Piotr Polak <piotr@polak.ro>
 */
class YamlBundleRoutingDefinition extends AbstractBundleRoutingDefinition
{
    /**
     * YamlBundleRoutingDefinition constructor.
     * 
     * @param $bundleName
     */
    public function __construct($bundleName)
    {
        parent::__construct($bundleName, 'yaml');
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        return '@' . $this->getBundleName() . '/Resources/config/routing.yml';
    }
}
