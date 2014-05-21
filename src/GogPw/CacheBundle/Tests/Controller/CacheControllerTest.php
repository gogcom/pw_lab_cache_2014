<?php

namespace GogPw\CacheBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CacheControllerTest extends WebTestCase
{
    public function testNocache()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/nocache');
    }

}
