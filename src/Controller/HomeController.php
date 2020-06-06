<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractFOSRestController
{
    /**
     * @Route("/", methods="GET")
     */
    public function index()
    {
        $data = ['status' => 'OK'];

        return $this->handleView(
            $this->view(
                $data,
                Response::HTTP_OK
            )
        );
    }
}
