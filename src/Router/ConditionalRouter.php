<?php

namespace Piotrpolak\ConditionalRoutingBundle\Router;

use Symfony\Component\Routing\Router;

/**
 * Appends generator_cache_class to dynamically generate different cached matchers and generators casses
 * for each combination of included bundles.
 */
class ConditionalRouter extends Router
{
    /**
     * @var array
     */
    private $optionsToAppend = ['matcher_cache_class', 'generator_cache_class'];

    /**
     * @inheritdoc
     */
    public function setOptions(array $options)
    {
        parent::setOptions($options);

        if ($this->loader instanceof ConditionalRoutesLoader) {
            $resolverKeys = $this->loader->getResolverKeys();

            foreach ($this->optionsToAppend as $optionToAppend) {
                $this->options[$optionToAppend] .= $resolverKeys;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function setOption($key, $value)
    {
        if ($this->loader instanceof ConditionalRoutesLoader) {
            if (in_array($key, $this->optionsToAppend)) {
                $value .= $this->loader->getResolverKeys();
            }
        }

        return parent::setOption($key, $value);
    }
}