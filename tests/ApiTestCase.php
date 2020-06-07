<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTestCase extends WebTestCase
{
	protected function createAuthClient($username = 'user', $password = 'password')
	{
	    $authClient = static::createClient();
	    $authClient->request(
			'POST',
			'/login',
			[],
			[],
			['CONTENT_TYPE' => 'application/json'],
			json_encode([
    			'email' => $username,
    			'password' => $password,
			])
	    );
	    $data = json_decode($authClient->getResponse()->getContent(), true);

	    $client = clone $authClient;
	    $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

	    return $client;
	}

	protected function getAuthClient()
	{
        return $this->createAuthClient(
        	'test@gmail.com',
        	'password'
        );
	}

    protected function getWriteClient(
    	$requestData,
    	$requestMethod = 'POST',
    	$path,
    	$isAuthRequest = true
    ) {
    	if ($isAuthRequest === true) {
    		$client = $this->getAuthClient();
    	} else {
    		$client = static::createClient();
    	}
        
	    $client->request(
			$requestMethod,
			$path,
			[],
			[],
			['CONTENT_TYPE' => 'application/json'],
			json_encode($requestData)
	    );
	    return $client;
    }
}
