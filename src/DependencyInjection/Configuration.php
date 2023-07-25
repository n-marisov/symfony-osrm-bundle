<?php

namespace Maris\Symfony\OSRM\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('direction');
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('mapbox_api_token')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
