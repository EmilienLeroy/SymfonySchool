<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 17/04/2018
 * Time: 15:38
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{

    public function testCreateSuccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/category/create');

        $this->assertContains('Create a new category', $crawler->filter('h1')->text());
        $name = time();
        $form = $crawler->selectButton('Save')->form();
        $crawler = $client->submit(
            $form,
            ['category[name]' => $name]
        );
        $crawler = $crawler->followRedirect();


        $link = $crawler->selectLink('Create category')->link();
        $crawler = $client->click($link);

        $this->assertContains('Create a new category', $crawler->filter('h1')->text());
    }
}