<?php

namespace Piotrpolak\ConditionalRoutingBundle\Router;

use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\BundleRoutingDefinitionInterface;
use Piotrpolak\ConditionalRoutingBundle\Model\RouteResolverInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

class ConditionalRoutesLoader extends Loader
{
    /** @var RouteResolverInterface[] */
    private $routeResolvers = array();

    /** @var bool */
    private $isLoaded = false;

    /**
     * Registers a new route resolver.
     *
     * @param RouteResolverInterface $resolver
     */
    public function addRouteResolver(RouteResolverInterface $resolver)
    {
        $this->routeResolvers[] = $resolver;
    }

    /**
     * Returns all registered route resolvers.
     *
     * @return \Piotrpolak\ConditionalRoutingBundle\Model\RouteResolverInterface[]
     */
    public function getRouteResolvers()
    {
        return $this->routeResolvers;
    }

    /**
     * Sets route resolvers.
     *
     * @param \Piotrpolak\ConditionalRoutingBundle\Model\RouteResolverInterface[] $routeResolvers
     * @return $this
     */
    public function setRouteResolvers($routeResolvers)
    {
        $this->routeResolvers = $routeResolvers;

        return $this;
    }

    /**
     * Returns the string representing the unique combination of the currently enabled bundles.
     * It is used to generate different cache files when the combination changes.
     *
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
            $definitions = $routeResolver->resolveConditionalRoutingDefinitions();
            if (count($definitions) > 0) {
                foreach ($definitions as $definition) {
                    $importedRoutes = $this->import($definition->getResource(), $definition->getType());

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