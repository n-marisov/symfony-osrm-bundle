<?php

namespace Maris\Symfony\OSRM\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OSRMOptimizerService
{

    const URI = "https://router.project-osrm.org/table/v1/driving/";

    protected HttpClientInterface $client;


    /**
     * @param HttpClientInterface $client
     */
    public function __construct( HttpClientInterface $client )
    {
        $this->client = $client->withOptions([
            'base_uri' => self::URI
        ]);
    }

}