<?php

namespace KunicMarko\SimpleConfigurationBundle\DependencyInjection\Compiler;

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
                    ['simple_configuration' => '@simple_configuration.service.configuration'],
                    $container->getParameter($parameter)
                )
            );
        }
    }
}
