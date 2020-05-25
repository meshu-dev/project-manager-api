<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractFOSRestController
{	
	/**
	 * @Route("/", methods="GET") 
	 */
	public function index()
	{
		$data = ['a' => 'I love pizza'];
        $view = $this->view($data, 200);

        return $this->handleView($view);
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
