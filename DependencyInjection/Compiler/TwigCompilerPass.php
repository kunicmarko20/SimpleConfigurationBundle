<?php

namespace KunicMarko\ColorPickerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter($parameter = 'twig.globals')) {
            $container->setParameter(
                $parameter,
                array_merge(
                    ['configuration' => '@configuration_panel.service.configuration'],
                    $container->getParameter($parameter)
                )
            );
        }
    }
}
