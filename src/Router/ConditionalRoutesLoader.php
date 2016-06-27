<?php

namespace Piotrpolak\ConditionalRoutingBundle\Router;

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
    private $routeResolvers = [];

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
        $bundleNames = [];
        foreach ($this->routeResolvers as $routeResolver) {
            $bundleNames = array_merge($bundleNames, $this->routeResolver->resolveBundleNames());
        }

        if (0 === count($bundleNames)) {
            return '';
        }

        $bundleNames = array_filter($bundleNames);
        $bundleNames = array_unique($bundleNames);
        sort($bundleNames);

        return '__'.implode('__', $bundleNames);
    }

    /**
     * @inheritdoc
     */
    public function load($resource, $type = null)
    {
        $collection = new RouteCollection();

        foreach ($this->routeResolvers as $routeResolver) {
            $bundleNames = $routeResolver->resolveBundleNames();
            if (count($bundleNames) > 0) {
                foreach ($bundleNames as $bundleName) {

                    // TODO Make routing file configurable
                    // TODO Make type configurable
                    // TODO Check if bundle/resource exists
                    $resource = '@'.$bundleName.'Resources/config/routing.yml';
                    $importedRoutes = $this->import($resource, 'yaml');

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