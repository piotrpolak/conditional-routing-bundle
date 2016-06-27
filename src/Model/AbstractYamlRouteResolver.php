<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\YamlBundleRoutingDefinition;

abstract class AbstractYamlRouteResolver implements RouteResolverInterface
{
    /**
     * @inheritdoc
     */
    public function resolveConditionalRoutingDefinitions()
    {
        $definitions = array();
        $bundleNames = $this->resolveBundleNames();
        foreach ($bundleNames as $bundleName) {
            $definitions[] = new YamlBundleRoutingDefinition($bundleName);
        }

        return $definitions;
    }

    /**
     * This method should return an array of extra bundle names whose routing should be conditionally loaded.
     * You should place your bundle-deciding logic here.
     *
     * @return string[]
     */
    public abstract function resolveBundleNames();
}