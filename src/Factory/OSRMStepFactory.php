<?php

namespace Maris\Symfony\OSRM\Factory;

use Maris\Symfony\Direction\Factory\StepFactory;

class OSRMStepFactory extends StepFactory
{

    /**
     * @inheritDoc
     */
    protected function extractId(array $array): int|null
    {
        return $array["id"] ?? null;
    }

    /**
     * @inheritDoc
     */
    protected function extractDistance(array $segment): float
    {
        return $segment["distance"];
    }

    /**
     * @inheritDoc
     */
    protected function extractDuration(array $segment): float
    {
        return $segment["duration"];
    }

    protected function extractArrayGeometry( array $step ): array
    {
        return $step["geometry"]["coordinates"];
    }
}