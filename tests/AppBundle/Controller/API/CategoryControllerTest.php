<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 17/04/2018
 * Time: 16:04
 */

namespace Tests\AppBundle\Controller\API;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testListCategoriesAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET','api/categories');

        $client->request(
            'GET',
            '/api/categories',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X-USERNAME' => 'miguel@doe.com',
                'HTTP_X-PASSWORD' => 'doe'
            )
        );

    }
}