<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\XmlBundleRoutingDefinition;

abstract class AbstractXmlRouteResolver extends AbstractRouteResolver
{
    /**
     * @inheritdoc
     */
    protected function getRoutingDefinitionForBundleName($bundleName)
    {
        return new XmlBundleRoutingDefinition($bundleName);
    }
}