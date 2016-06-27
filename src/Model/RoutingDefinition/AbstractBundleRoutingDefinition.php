<?php

namespace Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition;

abstract class AbstractBundleRoutingDefinition implements BundleRoutingDefinitionInterface
{
    /** @var string */
    protected $bundleName;

    /** @var string */
    protected $type;

    /**
     * DefaultBundleRoutingDefinition constructor.
     * @param $bundleName
     * @param string $type
     */
    public function __construct($bundleName, $type)
    {
        $this->bundleName = $bundleName;
        $this->type = $type;
    }

    /**
     * @inheritdoc
     */
    public function getBundleName()
    {
        return $this->bundleName;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->type;
    }
}