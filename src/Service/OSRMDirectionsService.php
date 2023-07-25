<?php

namespace Maris\Symfony\OSRM\Service;

use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Direction\Interfaces\DirectionServiceInterface;
use Maris\Symfony\Geo\Entity\Location;
use Maris\Symfony\OSRM\Factory\OSRMDirectionsFactory;
use ReflectionException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OSRMDirectionsService implements DirectionServiceInterface
{

    const URI = "https://router.project-osrm.org/route/v1/driving/";

    protected HttpClientInterface $client;

    protected OSRMDirectionsFactory $factory;

    /**
     * @param HttpClientInterface $client
     * @param OSRMDirectionsFactory $factory
     */
    public function __construct( HttpClientInterface $client, OSRMDirectionsFactory $factory )
    {
        $this->client = $client->withOptions([
            'base_uri' => self::URI
        ]);
        $this->factory = $factory;
    }


    /***
     * Приводит массив координат к строке
     * @param array $coordinates
     * @return string
     */
    protected function coordinatesToLineString( array $coordinates ):string
    {
        return implode(";",
            array_map(fn(Location $l)=>"{$l->getLongitude()},{$l->getLatitude()}",$coordinates)
        );
    }

    /**
     * Наполняет массив настроек дефолтными значениями
     * @param array $options
     * @return void
     */
    protected function setDefaultOptions( array &$options ):void
    {
        $options = array_merge( $options, [
            "steps" => "true",
            "geometries" => "polyline6",
            "overview" => "false"
        ]);
    }

    /**
     * Сервис запроса маршрута.
     * @param array $coordinates
     * @param array $options
     * @return Direction
     * @throws ReflectionException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getDirection( array $coordinates, array $options = [] ): Direction
    {
        $this->setDefaultOptions($options);
        $uri = $this->coordinatesToLineString($coordinates)."?".http_build_query($options);
        $response = $this->client->request("GET",$uri);

        return $this->factory->create( $response->toArray()  );
    }



}