<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Movie;

class OMDBAPI
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function omdb(Movie $movie){

        $response = $this->client->request('GET', 'http://www.omdbapi.com/?t='.$movie->getName().'&apikey=b5127c28');
        return $response->toArray();
    }

}