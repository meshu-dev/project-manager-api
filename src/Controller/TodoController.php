<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends AbstractController
{	
	/**
	 * @Route("/", methods="GET") 
	 */
	public function index()
	{
		return new Response('I love pizza');
	}

	/**
	 * @Route("/test/{id}", methods="GET") 
	 */
	public function test($id)
	{
		return $this->json([
			'test' => "Test Id: $id"
		]);
	}	
}
