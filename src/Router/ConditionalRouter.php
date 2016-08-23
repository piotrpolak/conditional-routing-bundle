<?php

namespace Piotrpolak\ConditionalRoutingBundle\Router;

use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RequestContext;

/**
 * Appends generator_cache_class to dynamically generate different cached matchers and generators classes
 * for each combination of included bundles.
 */
class ConditionalRouter extends BaseRouter
{
    /** @var string[] */
    private $optionsToAppend = array('matcher_cache_class', 'generator_cache_class');

    /** @var ContainerInterface */
    private $aContainer;

    /**
     * ConditionalRouter constructor.
     * @param ContainerInterface $container
     * @param mixed $resource
     * @param array $options
     * @param RequestContext|null $context
     */
    public function __construct(ContainerInterface $container, $resource, array $options = array(), RequestContext $context = null)
    {
        // $this->loader is null at any moment, that is why we have to check whether there is conditional_router.routing_loader in the container
        $this->aContainer = $container;
        return parent::__construct($container, $resource, $options, $context);
    }

    /**
     * @inheritdoc
     */
    public function setOptions(array $options)
    {
        parent::setOptions($options);

        // $this->loader is null at this moment so we have to use the definition directly
        if ($this->aContainer->has('conditional_router.routing_loader')) {
            $resolverKeys = $this->aContainer->get('conditional_router.routing_loader')->getResolverKeys();

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
        // $this->loader is null at this moment so we have to use the definition directly
        if ($this->aContainer->has('conditional_router.routing_loader')) {
            $resolverKeys = $this->aContainer->get('conditional_router.routing_loader')->getResolverKeys();

            if (in_array($key, $this->optionsToAppend)) {
                $value .= $resolverKeys;
            }
        }

        return parent::setOption($key, $value);
    }
}