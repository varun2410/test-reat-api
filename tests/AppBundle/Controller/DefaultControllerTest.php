<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('GetUserList', $crawler->text());
    }

    public function testGetUsers()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users');

        $data = json_decode($crawler->text());

        $this->assertInternalType('array', $data);
        $this->assertObjectHasAttribute('firstName', $data[0]);
    }
}
