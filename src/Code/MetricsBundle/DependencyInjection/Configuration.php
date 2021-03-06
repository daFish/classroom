<?php

namespace Code\MetricsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     *
     * @throws \RuntimeException When using the deprecated 'charset' setting
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('code_metrics');

        $rootNode
            ->children()
                ->arrayNode('pdepend')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('executable')->defaultValue('%kernel.root_dir%/../bin/pdepend')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
