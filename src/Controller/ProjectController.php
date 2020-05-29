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
        $product = $this->projectRepository->create($params);

        return $this->handleView(
            $this->view(
                $product,
                Response::HTTP_CREATED
            )
        );
    }

    /**
     * @Route("/projects/{id}", methods="PUT")
     */
    public function putAction(Request $request, int $id)
    {
        $params = $request->request->all();
        $product = $this->projectRepository->update($id, $params);

        return $this->handleView(
            $this->view(
                $product,
                Response::HTTP_OK
            )
        );
    }


    /**
     * @Route("/projects/{id}", methods="DELETE")
     */
    public function deleteAction(int $id)
    {
        $this->projectRepository->delete($id);

        return $this->handleView(
            $this->view(
                null,
                Response::HTTP_NO_CONTENT
            )
        );
    }
}
