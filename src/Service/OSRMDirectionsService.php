<?php

namespace Maris\Symfony\OSRM\Service;

use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Direction\Interfaces\DirectionServiceInterface;
use Maris\Symfony\Geo\Entity\Location;
use Maris\Symfony\Geo\Entity\Polyline;
use Maris\Symfony\Geo\Service\PolylineEncoder;
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

    protected PolylineEncoder $encoder;

    protected string $geometries;
    protected bool $alternatives;

    /**
     * @param HttpClientInterface $client
     * @param OSRMDirectionsFactory $factory
     * @param PolylineEncoder $encoder
     * @param string $geometries
     * @param bool $alternatives
     */
    public function __construct( HttpClientInterface $client, OSRMDirectionsFactory $factory , PolylineEncoder $encoder, string $geometries = "polyline6", $alternatives = false)
    {
        $this->client = $client->withOptions([
            'base_uri' => self::URI
        ]);
        $this->encoder = $encoder;
        $this->factory = $factory;
        $this->geometries = $geometries;
        $this->alternatives = $alternatives;
    }


    /***
     * Приводит массив координат к строке
     * @param array $coordinates
     * @return string
     */
    protected function coordinatesToLineString( array $coordinates ):string
    {
        $precision = $this->encoder->getPrecision();

        if( $precision === 5 )
            return "polyline (".$this->encoder->encode( new Polyline( ...$coordinates ) ) .")";
        elseif ($precision === 6)
            "polyline6 (".$this->encoder->encode( new Polyline( ...$coordinates ) ) .")";

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
        $options = array_merge(
            [
                "alternatives" => ($this->alternatives)?"true":"false",
                "geometries" => $this->geometries,
            ],
            $options,
            [
                "steps" => "true",
                "overview" => "false"
            ]
        );
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

        $direction = $response->toArray();


        dump($direction);

        if( $options["geometries"] === "geojson")
            return $this->factory->create( $response->toArray()  );

        $factory = clone $this->factory;
        return $factory->setEncoder(new PolylineEncoder(match ( $options["geometries"] ?? null ){
            "polyline6" => 6,
            default     => 5,
        }))->create($direction);
    }



}