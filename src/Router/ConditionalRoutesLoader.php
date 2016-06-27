<?php

namespace Piotrpolak\ConditionalRoutingBundle\Router;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\BundleRoutingDefinitionInterface;
use Piotrpolak\ConditionalRoutingBundle\Model\RouteResolverInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

/**
 * ConditionalRoutesLoader
 *
 * @todo Implement warm-up
 */
class ConditionalRoutesLoader extends Loader
{
    /** @var RouteResolverInterface[] */
    private $routeResolvers = array();

    /** @var bool */
    private $isLoaded = false;

    /**
     * @param RouteResolverInterface $resolver
     */
    public function addRouteResolver(RouteResolverInterface $resolver)
    {
        $this->routeResolvers[] = $resolver;
    }

    /**
     * @return \Piotrpolak\ConditionalRoutingBundle\Model\RouteResolverInterface[]
     */
    public function getRouteResolvers()
    {
        return $this->routeResolvers;
    }

    /**
     * @param $routeResolvers
     * @return $this
     */
    public function setRouteResolvers($routeResolvers)
    {
        $this->routeResolvers = $routeResolvers;

        return $this;
    }

    /**
     * @return string
     */
    public function getResolverKeys()
    {
        $bundleNames = array();
        foreach ($this->routeResolvers as $routeResolver) {
            $resolverBundleNames = array_map(function (BundleRoutingDefinitionInterface $bundleRoutingDefinition) {
                return $bundleRoutingDefinition->getBundleName();
            }, $routeResolver->resolveConditionalRoutingDefinitions());

            $bundleNames = array_merge($bundleNames, $resolverBundleNames);
        }

        if (0 === count($bundleNames)) {
            return '';
        }

        $bundleNames = array_filter($bundleNames);
        $bundleNames = array_unique($bundleNames);
        sort($bundleNames);

        return '__' . implode('__', $bundleNames);
    }

    /**
     * @inheritdoc
     */
    public function load($resource, $type = null)
    {
        if (true === $this->isLoaded) {
            throw new \RuntimeException('Do not add the "conditional" loader twice');
        }
        $this->isLoaded = true;

        $collection = new RouteCollection();

        foreach ($this->routeResolvers as $routeResolver) {
            $bundleRoutingDefinitions = $routeResolver->resolveConditionalRoutingDefinitions();
            if (count($bundleRoutingDefinitions) > 0) {
                foreach ($bundleRoutingDefinitions as $bundleRoutingDefinition) {
                    $importedRoutes = $this->import($bundleRoutingDefinition->getResource(), $bundleRoutingDefinition->getType());

                    $collection->addCollection($importedRoutes);
                }
            }
        }

        return $collection;
    }

    /**
     * @inheritdoc
     */
    public function supports($resource, $type = null)
    {
        return 'conditional' === $type;
    }
}