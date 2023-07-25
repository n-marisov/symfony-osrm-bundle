<?php

namespace Maris\Symfony\OSRM\Factory;

use Maris\Symfony\Direction\Factory\RouteFactory;

class OSRMRouteFactory extends RouteFactory
{
    public function __construct( OSRMLegFactory $factory )
    {
        parent::__construct( $factory );
    }


    /**
     * @inheritDoc
     */
    protected function extractId(array $array): int|null
    {
        return $array["id"] ?? null;
    }

    protected function extractArrayLegs(array $route): array
    {
        return $route["legs"] ?? [];
    }

    /**
     * @inheritDoc
     */
    protected function extractDistance( array $segment ): float
    {
        return $segment["distance"];
    }

    /**
     * @inheritDoc
     */
    protected function extractDuration( array $segment ): float
    {
        return $segment["duration"];
    }
}