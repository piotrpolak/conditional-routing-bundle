<?php

namespace Piotrpolak\ConditionalRoutingBundle\Router;

use Symfony\Component\Routing\Router;

class ConditionalRouter extends Router
{
    /** @var RouteResolverInterface */
    private $routeResolver;

    /**
     * @inheritdoc
     */
    public function getMatcher()
    {
        // Append generator_cache_class to dynamically generate different cached matchers for each combination
        $this->options['matcher_cache_class'] .= $this->getResolverKeys();

        return parent::getMatcher();
    }

    /**
     * @inheritdoc
     */
    public function getGenerator()
    {
        // Append generator_cache_class to dynamically generate different cached generators for each combination
        $this->options['generator_cache_class'] .= $this->getResolverKeys();

        return parent::getGenerator();
    }

    /**
     * @return string
     */
    protected function getResolverKeys()
    {
        return implode('', $this->routeResolver->resolveBundleNames());
    }
}