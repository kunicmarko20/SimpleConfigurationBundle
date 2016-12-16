<?php

namespace KunicMarko\ConfigurationPanelBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('configuration_panel');
        $rootNode
            ->children()
                ->scalarNode('type')->isRequired()->end()
                ->scalarNode('upload_directory')->defaultValue('uploads')->end()
            ->end();

        return $treeBuilder;
    }
}

