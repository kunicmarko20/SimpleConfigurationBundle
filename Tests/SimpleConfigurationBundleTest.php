<?php

namespace KunicMarko\SimpleConfigurationBundle\Tests;

use KunicMarko\SimpleConfigurationBundle\DependencyInjection\Compiler\TwigCompilerPass;
use KunicMarko\SimpleConfigurationBundle\SimpleConfigurationBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SimpleConfigurationBundleTest extends AbstractTest
{
    /**
     * @var SimpleConfigurationBundle
     */
    private $bundle;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->bundle = new SimpleConfigurationBundle();
    }

    public function testBundle()
    {
        $this->assertInstanceOf(Bundle::class, $this->bundle);
    }

    public function testCompilerPasses()
    {
        $containerBuilder = $this->createContainerBuilderMock();

        $containerBuilder
            ->expects($this->at(0))
            ->method('addCompilerPass')
            ->with($this->isInstanceOf(TwigCompilerPass::class))
            ->will($this->returnSelf());

        $this->bundle->build($containerBuilder);
    }

    /**
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(['addCompilerPass'])
            ->getMock();
    }
}
