<?php

namespace Maris\Symfony\OSRM\Factory;

use Maris\Symfony\Direction\Factory\StepFactory;
use Maris\Symfony\Geo\Entity\Polyline;
use Maris\Symfony\Geo\Service\PolylineEncoder;
use ReflectionException;

class OSRMStepFactory extends StepFactory
{
    /**
     *
     * @var PolylineEncoder
     */
    protected PolylineEncoder $encoder;

    /**
     * @param PolylineEncoder $encoder
     * @throws ReflectionException
     */
    public function __construct( PolylineEncoder $encoder )
    {
        parent::__construct();
        $this->encoder = $encoder;
    }

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

    protected function createGeometry(array|string $geometry): Polyline
    {
        return (is_string($geometry))
            ? $this->encoder->decode( $geometry )
            : parent::createGeometry( $geometry );
    }
}