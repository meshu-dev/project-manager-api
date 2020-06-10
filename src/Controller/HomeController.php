<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Provides endpoint for main website address.
 */
class HomeController extends AbstractFOSRestController
{
    /**
     * Index endpoint which outputs API status.
     *
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
