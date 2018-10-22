<?php

namespace Piotrpolak\ConditionalRoutingBundle\Tests;

abstract class BaseConditionalRoutingBundleTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getContainerBuilderMock()
    {
        $classMethods = get_class_methods('\Symfony\Component\DependencyInjection\ContainerBuilder');
        unset($classMethods[array_search('merge', $classMethods)]);
        return $this->getMockBuilder('\Symfony\Component\DependencyInjection\ContainerBuilder')
            ->setMethods($classMethods)// FAKE to avoid errors on PHP7.0 and Symfony 3.0
            ->disableOriginalConstructor()
            ->getMock();
    }
}