<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\XmlBundleRoutingDefinition;

/**
 * AbstractXmlRouteResolver provides a way to load routing of XML type easier.
 *
 * The main logic should be placed in the AbstractRouteResolver::resolveBundleNames() method.
 *
 * @author Piotr Polak <piotr@polak.ro>
 */
abstract class AbstractXmlRouteResolver extends AbstractRouteResolver
{
    /**
     * {@inheritdoc}
     */
    protected function getRoutingDefinitionForBundleName($bundleName)
    {
        return new XmlBundleRoutingDefinition($bundleName);
    }
}