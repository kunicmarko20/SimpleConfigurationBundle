<?php

namespace KunicMarko\ColorPickerBundle\Tests\DependencyInjection\Compiler;

use KunicMarko\SimpleConfigurationBundle\DependencyInjection\Compiler\TwigCompilerPass;
use KunicMarko\SimpleConfigurationBundle\Tests\AbstractTest;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigCompilerPassTest extends AbstractTest
{
    /**
     * @var TwigCompilerPass
     */
    private $compilerPass;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->compilerPass = new TwigCompilerPass();
    }

    public function testTwigGlobals()
    {
        $containerBuilder = $this->createContainerBuilderMock();

        $containerBuilder
            ->expects($this->once())
            ->method('hasParameter')
            ->will($this->returnValue(
                [$parameter = 'twig.globals', true]
            ));

        $containerBuilder
            ->expects($this->once())
            ->method('getParameter')
            ->with($this->identicalTo($parameter))
            ->will($this->returnValue([]));

        $containerBuilder
            ->expects($this->once())
            ->method('setParameter')
            ->with(
                $this->identicalTo($parameter),
                $this->identicalTo(['simple_configuration' => '@simple_configuration.service.configuration'])
            );

        $this->compilerPass->process($containerBuilder);
    }

    /**
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasParameter', 'getParameter', 'setParameter'])
            ->getMock();
    }
}
