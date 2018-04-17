<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 17/04/2018
 * Time: 15:16
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET','/login');
        $this->assertContains('Login', $crawler->filter('h1')->text());

        $form = $crawler->selectButton('Save')->form();
        $crawler = $client->submit(
            $form,
            [
                'email' => 'miguel@doe.com',
                'password' => 'doe'
            ]
        );



        $this->assertContains('Login', $crawler->filter('h1')->text());

        //echo $client->getResponse()->setContent();
    }
}