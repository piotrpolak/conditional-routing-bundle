<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition;

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