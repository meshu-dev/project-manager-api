<?php

namespace App\Tests\Controller;

use App\Tests\ApiTestCase;

class HomeControllerTest extends ApiTestCase
{
    public function testIndexUnauthenticated()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testIndex()
    {
        $client = $this->getAuthClient();
        $client->request('GET', '/');
        
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals($data['status'], 'OK');
    }
}
