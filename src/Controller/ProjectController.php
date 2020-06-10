<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View as RestView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Provides endpoints for projects.
 */
class ProjectController extends AbstractFOSRestController
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @param ProjectRepository $projectRepository Project repository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Get a project by a specified ID.
     *
     * @param int $id The ID of the project
     *
     * @return string The project formatted to output type
     *
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
     * Get all projects.
     *
     * @return string The projects formatted to output type
     *
     * @Route("/projects", methods="GET")
     */
    public function getAllAction()
    {
        $view = RestView::create();

        $projects = $this->projectRepository->findAll();
        $totalProjects = $this->projectRepository->getTotal();

        $view->setHeader('X-Total-Count', $totalProjects);
        $view->setData(
            $projects,
            Response::HTTP_OK
        );

        return $this->handleView($view);
    }

    /**
     * Create a new project.
     *
     * @param Request $request Request data
     *
     * @return string The new project formatted to output type
     *
     * @Route("/projects", methods="POST")
     */
    public function postAction(Request $request)
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
     * Change an existing project.
     *
     * @param Request $request Request data
     * @param int     $id      The ID of the project
     *
     * @return string The updated project formatted to output type
     *
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
     * Delete an existing project.
     *
     * @param int $id The ID of the project
     *
     * @return null No content as project is deleted
     *
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
