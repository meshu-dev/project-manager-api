<?php

namespace App\Tests\Controller;

use App\Tests\ApiTestCase;

class ProjectControllerTest extends ApiTestCase
{
	private static $path = '/projects';
	private static $postData = [
		'name' => 'PHP Unit Project'
	];
	private static $putData = [
		'name' => 'Updated PHP Unit Project'
	];

    public function testGetAllUnauthenticated()
    {
        $client = static::createClient();
        $client->request('GET', self::$path);

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testGetAll()
    {
        $client = $this->getAuthClient();
        $client->request('GET', self::$path);
        
        $rows = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertIsArray($rows);
        $this->assertNotEmpty($rows);

        $firstRow = $rows[0];

        $this->rowTests($firstRow);

        return $firstRow['id'];
    }

    /**
     * @depends testGetAll
     */
    public function testGetUnauthenticated($rowId)
    {
        $client = static::createClient();
        $client->request('GET', self::$path . '/' . $rowId);

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    /**
     * @depends testGetAll
     */
    public function testGet($rowId)
    {
        $client = $this->getAuthClient();
        $client->request('GET', self::$path . '/' . $rowId);
        
        $row = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->rowTests($row);
    }

    public function testPostUnauthenticated()
    {
        $client = $this->getWriteClient(
        	self::$postData,
        	'POST',
        	self::$path,
        	false
        );

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testPost()
    {
        $client = $this->getWriteClient(
        	self::$postData,
        	'POST',
        	self::$path
        );
        
        $row = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->rowTests($row);
        $this->assertEquals($row['name'], self::$postData['name']);

        return $row['id'];
    }

    /**
     * @depends testPost
     */
    public function testPutUnauthenticated($rowId)
    {
    	$path = self::$path . '/' . $rowId;

        $client = $this->getWriteClient(
        	self::$putData,
        	'PUT',
        	$path,
        	false
        );

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    /**
     * @depends testPost
     */
    public function testPut($rowId)
    {
    	$path = self::$path . '/' . $rowId;

        $client = $this->getWriteClient(
        	self::$putData,
        	'PUT',
        	$path
        );
        
        $row = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->rowTests($row);
        $this->assertEquals($row['name'], self::$putData['name']);

        return $row['id'];
    }

    /**
     * @depends testPut
     */
    public function testDeleteUnauthenticated($rowId)
    {
    	$path = self::$path . '/' . $rowId;

        $client = static::createClient();
        $client->request('DELETE', $path);

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    /**
     * @depends testPut
     */
    public function testDelete($rowId)
    {
    	$path = self::$path . '/' . $rowId;

        $client = $this->getAuthClient();
        $client->request('DELETE', $path);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    protected function rowTests($row)
    {
        $this->assertArrayHasKey('id', $row);
        $this->assertArrayHasKey('name', $row);

        $this->assertIsInt($row['id']);
        $this->assertIsString($row['name']);
    }
}
