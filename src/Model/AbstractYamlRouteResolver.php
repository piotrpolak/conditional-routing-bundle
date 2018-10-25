<?php

namespace PiotrPolak\ConditionalRoutingBundle\Model;

use PiotrPolak\ConditionalRoutingBundle\Model\RoutingDefinition\YamlBundleRoutingDefinition;

/**
 * AbstractXmlRouteResolver provides a way to load routing of YAML type easier.
 *
 * The main logic should be placed in the AbstractRouteResolver::resolveBundleNames() method.
 *
 * @author Piotr Polak <piotr@polak.ro>
 */
abstract class AbstractYamlRouteResolver extends AbstractRouteResolver
{
    /**
     * {@inheritdoc}
     */
    protected function getRoutingDefinitionForBundleName($bundleName)
    {
        return new YamlBundleRoutingDefinition($bundleName);
    }
}
