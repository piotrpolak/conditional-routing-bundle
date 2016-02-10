<?php

namespace Piotrpolak\ConditionalRoutingBundle\Router;

use Piotrpolak\ConditionalRoutingBundle\Model\RouteResolverInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouteCollection;

class ConditionalRoutesLoader extends Loader
{
    /** @var RouteResolverInterface */
    private $resolver;

    /** @var string */
    private $type;

    // TODO Implement warmup

    /**
     * ConditionalRoutesLoader constructor.
     *
     * @param RouteResolverInterface $resolver
     * @param string $type
     */
    public function __construct(RouteResolverInterface $resolver, $type = 'conditional')
    {
        $this->resolver = $resolver;
        $this->type = $type;
    }

    /**
     * @inheritdoc
     */
    public function load($resource, $type = null)
    {
        $collection = new RouteCollection();

        $bundleNames = $this->resolver->resolveBundleNames();
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


        return $collection;
    }

    /**
     * @inheritdoc
     */
    public function supports($resource, $type = null)
    {
        // TODO Make it configurable
        return $type === $this->type;
    }
}