<?php

namespace Maris\Symfony\OSRM;

use Maris\Symfony\OSRM\DependencyInjection\OSRMExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class OSRMBundle extends AbstractBundle{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new OSRMExtension();
    }
}