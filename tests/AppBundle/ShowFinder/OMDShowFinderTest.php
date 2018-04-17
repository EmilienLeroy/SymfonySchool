<?php

namespace Tests\AppBundle\ShowFinder;

use AppBundle\Entity\Show;
use AppBundle\Entity\User;
use AppBundle\ShowFinder\OMDShowFinder;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class OMDShowFinderTest extends TestCase
{

    public function testfindByNameWithName()
    {
        $omdbJson = "{}";

        $results = $this
            ->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $results->method('getBody')->willReturn($omdbJson);

        $client = $this
            ->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $client ->method('__call')->with('get')->willReturn($results);
        /*
        TODO
        $token =$this->createMock(UsernamePasswordToken::class);
        $token->method('getUser')->willReturn(new User);

        $tokenStorage = $this->createMock(TokenStorage::class);
        $tokenStorage->method('getToken')->willReturn($token);

        $omdb = new OMDShowFinder($client,$tokenStorage,'');
        $res = $omdb->findByName(['name' =>'test']);
        $expected = new Show();


        $this->assertSame([$expected],$res);
        */


    }

    public function testfindByNameWithoutShow()
    {
        $client = $this
            ->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $results = $this
            ->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $tokenStorage = $this->createMock(TokenStorage::class);


        $results->method('getBody')->willReturn('{"Response" : "False"}');

        //$client->method('get')->willReturn($results);

        $client ->method('__call')->with('get')->willReturn($results);

        $omdb = new OMDShowFinder($client, $tokenStorage ,'');
        $result = $omdb->findByName(['name' =>'My search']);

        $this->assertSame([],$result);

    }
}