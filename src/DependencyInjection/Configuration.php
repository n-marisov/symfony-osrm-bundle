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
        $treeBuilder = new TreeBuilder('osrm');
        $treeBuilder->getRootNode()
            ->children()
                # В каком виде запрашивается геометрия
                ->enumNode("geometries")
                    ->values(["polyline","polyline6","geojson"])
                    ->defaultValue("polyline6")
                ->end()

                # Запрашивать альтернативные маршруты
                ->booleanNode("alternatives")->defaultValue(false)->end()
               // ->scalarNode('mapbox_api_token')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
