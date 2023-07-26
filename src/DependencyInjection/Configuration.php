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
            ->enumNode("profile")
                ->values(["driving"/**/,"car"/*автомобиль*/ , "bike" /*велосипед*/, "foot"/*пешком*/])
                ->defaultValue("polyline6")
            ->end()

                # В каком виде запрашивается геометрия
                ->enumNode("geometries")
                    ->values(["polyline","polyline6","geojson"])
                    ->defaultValue("polyline6")
                ->end()

                # Запрашивать альтернативные маршруты
                ->booleanNode("alternatives")->defaultValue(false)->end()

            ->end()
        ;

        return $treeBuilder;
    }
}
