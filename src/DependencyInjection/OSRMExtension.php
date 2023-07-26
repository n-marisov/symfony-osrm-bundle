<?php

namespace Maris\Symfony\OSRM\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class OSRMExtension extends Extension
{
    /**
     * Загружаем файл конфигурации
     * @inheritDoc
     */
    public function load( array $configs, ContainerBuilder $container )
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration( $configuration, $configs );

        $path = realpath( dirname(__DIR__).'/../Resources/config' );
        $loader = new YamlFileLoader( $container, new FileLocator( $path ) );
        $loader->load('services.yaml');

        $container->setParameter("osrm.request.geometries",$config["geometries"]);
        $container->setParameter("osrm.request.alternatives",$config["alternatives"]);
    }
}