<?php

namespace KunicMarko\SimpleConfigurationBundle;

use KunicMarko\SimpleConfigurationBundle\DependencyInjection\Compiler\TwigCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SimpleConfigurationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container
            ->addCompilerPass(new TwigCompilerPass());
    }
}
