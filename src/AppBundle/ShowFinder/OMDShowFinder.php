<?php


namespace AppBundle\ShowFinder;



use GuzzleHttp\Client;

class OMDShowFinder implements ShowFinderInterface
{
    private $client;
    private $key;

    public function __construct(Client $client, $key)
    {
        $this->client = $client;
        $this->key = $key;
    }

    public function findByName($query)
    {
        $result = $this->client->get('/?apikey='.$this->key.'&type=series&t='.$query['name']);
        return \GuzzleHttp\json_decode($result->getBody());
    }

    public function getName()
    {
        return 'Api_OMD';
    }
}