<?php

namespace Maris\Symfony\OSRM\Factory;

use Maris\Symfony\Direction\Factory\DirectionFactory;
use Maris\Symfony\Geo\Service\PolylineEncoder;
use ReflectionException;

class OSRMDirectionsFactory extends DirectionFactory
{
    public function __construct( OSRMRouteFactory $routeFactory, OSRMWaypointFactory $waypointFactory )
    {
        parent::__construct( $routeFactory, $waypointFactory );
    }

    /**
     * @throws ReflectionException
     */
    public function setEncoder(PolylineEncoder $encoder ):self
    {
        $legFactory = (new \ReflectionClass($this->routeFactory))
            ->getProperty("factory")
            ->getValue($this->routeFactory);

        $stepFactory = (new \ReflectionClass($legFactory))
            ->getProperty("factory")->getValue($legFactory);

        (new \ReflectionClass($stepFactory))
            ->getProperty("encoder")->setValue( $stepFactory, $encoder );

        return $this;
    }


    protected function extractId(array $array): int|null
    {
        return $array["id"] ?? null;
    }

    protected function extractStatus(array $direction): string
    {
        return $direction["code"] ?? "parseError";
    }

    protected function extractMessage(array $direction): ?string
    {
        return $direction["message"] ?? null;
    }

    protected function extractArrayRoutes(array $direction): array
    {
        return $direction["routes"] ?? [];
    }

    protected function extractArrayWaypoints(array $direction): array
    {
        return $direction["waypoints"] ?? [];
    }
}