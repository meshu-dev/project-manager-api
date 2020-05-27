<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Request\ParamFetcher;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use App\Repository\ProjectRepository;

use Symfony\Component\HttpFoundation\Response;

class ProjectController extends AbstractFOSRestController
{
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("/projects/{id}", methods="GET")
     * @View(statusCode=200)
     */
    public function getAction(int $id)
    {
        $project = $this->projectRepository->find($id);

        return $this->handleView(
            $this->view(
                $project,
                Response::HTTP_OK
            )
        );
    }


    /**
     * @Route("/projects", methods="GET")
     */
    public function getAllAction()
    {
        $projects = $this->projectRepository->findAll();

        return $this->handleView(
            $this->view(
                $projects,
                Response::HTTP_OK
            )
        );
    }

    /**
     * @Route("/projects", methods="POST")
     *
     * @param ParamFetcher $paramFetcher
     */
    public function postAction(Request $request, ParamFetcher $paramFetcher)
    {
        $params = $request->request->all();

        return $this->handleView(
            $this->view(
                [
                    $params
                ],
                Response::HTTP_CREATED
            )
        );
    }

    /**
     * @Route("/projects", methods="PUT", name="project")
     */
    public function putAction()
    {
        return $this->handleView(
            $this->view(
                [],
                Response::HTTP_OK
            )
        );
    }


    /**
     * @Route("/projects", methods="DELETE", name="project")
     */
    public function deleteAction(int $id)
    {
        return $this->handleView(
            $this->view(
                [],
                Response::HTTP_NO_CONTENT
            )
        );
    }
}
