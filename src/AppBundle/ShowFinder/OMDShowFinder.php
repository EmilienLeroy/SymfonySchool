<?php


namespace AppBundle\ShowFinder;


use GuzzleHttp\Client;

class OMDShowFinder implements ShowFinderInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function findByName($query)
    {
        $result = $this->client->get('/?apikey=cc84b86e&type=series&t="walking"');
        dump(\GuzzleHttp\json_decode($result->getBody()));die;
    }

    public function getName()
    {
        return 'Api OMD';
    }
}