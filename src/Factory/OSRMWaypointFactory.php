<?php

namespace Maris\Symfony\OSRM\Factory;

class OSRMWaypointFactory extends \Maris\Symfony\Direction\Factory\WaypointFactory
{

    /**
     * @inheritDoc
     */
    protected function extractId(array $array): int|null
    {
        return $array["id"] ?? null;
    }

    protected function extractDistance(array $waypoint): float
    {
        return $waypoint["distance"];
    }

    protected function extractCoordinate(array $waypoint): array
    {
        return $waypoint["location"];
    }
}