<?php

namespace Maris\Symfony\OSRM\Factory;

use Maris\Symfony\Direction\Factory\LegFactory;
use Maris\Symfony\Direction\Factory\StepFactory;

class OSRMLegFactory extends LegFactory
{
    public function __construct( OSRMStepFactory $factory )
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

    protected function extractArraySteps(array $leg): array
    {
        return $leg["steps"] ?? [];
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
}