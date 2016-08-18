<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\BundleRoutingDefinitionInterface;

abstract class AbstractRouteResolver implements RouteResolverInterface
{
    /**
     * @inheritdoc
     */
    public function resolveConditionalRoutingDefinitions()
    {
        $definitions = array();
        $bundleNames = $this->resolveBundleNames();
        foreach ($bundleNames as $bundleName) {
            $definitions[] = $this->getRoutingDefinitionForBundleName($bundleName);
        }

        return $definitions;
    }

    /**
     * Returns an instance of BundleRoutingDefinitionInterface for the given bundle name
     * @param $bundleName
     * @return BundleRoutingDefinitionInterface
     */
    protected abstract function getRoutingDefinitionForBundleName($bundleName);

    /**
     * This method should return an array of extra bundle names whose routing should be conditionally loaded.
     * You should place your bundle-deciding logic here.
     *
     * @return string[]
     */
    public abstract function resolveBundleNames();
}