<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;

class ProjectController extends AbstractFOSRestController
{
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("/projects/{id}", methods="GET")
     */
    public function getOne(int $id)
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProjectController.php',
        ]);
    }


    /**
     * @Route("/projects", methods="GET")
     */
    public function getAll()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProjectController.php',
        ]);
    }

    /**
     * @Route("/projects", methods="POST")
     */
    public function add()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProjectController.php',
        ]);
    }

    /**
     * @Route("/project", methods="GET", name="project")
     */
    public function edit()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProjectController.php',
        ]);
    }


    /**
     * @Route("/project", methods="GET", name="project")
     */
    public function delete(int $id)
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProjectController.php',
        ]);
    }
}
