<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\YamlBundleRoutingDefinition;

abstract class AbstractYamlRouteResolver extends AbstractRouteResolver
{
    /**
     * @inheritdoc
     */
    protected function getRoutingDefinitionForBundleName($bundleName)
    {
        return new YamlBundleRoutingDefinition($bundleName);
    }
}