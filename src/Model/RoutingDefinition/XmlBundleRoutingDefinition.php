<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition;

class XmlBundleRoutingDefinition extends AbstractBundleRoutingDefinition
{
    /**
     * XmlBundleRoutingDefinition constructor.
     * 
     * @param $bundleName
     */
    public function __construct($bundleName)
    {
        parent::__construct($bundleName, 'xml');
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        return '@' . $this->getBundleName() . '/Resources/config/routing.xml';
    }
}