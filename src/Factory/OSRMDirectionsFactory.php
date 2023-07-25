<?php

namespace Maris\Symfony\OSRM\Factory;

use Maris\Symfony\Direction\Factory\DirectionFactory;

class OSRMDirectionsFactory extends DirectionFactory
{
    public function __construct( OSRMRouteFactory $routeFactory, OSRMWaypointFactory $waypointFactory )
    {
        parent::__construct( $routeFactory, $waypointFactory );
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