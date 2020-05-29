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

use App\Repository\TaskRepository;
use App\Repository\ProjectRepository;

use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractFOSRestController
{
    private $taskRepository;
    private $projectRepository;

    public function __construct(
        TaskRepository $taskRepository,
        ProjectRepository $projectRepository
    ) {
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("/tasks/{id}", methods="GET")
     */
    public function getAction(int $id)
    {
        $task = $this->taskRepository->find($id);

        return $this->handleView(
            $this->view(
                $task,
                Response::HTTP_OK
            )
        );
    }

    /**
     * @Route("/tasks", methods="GET")
     */
    public function getAllAction()
    {
        $tasks = $this->taskRepository->findAll();

        return $this->handleView(
            $this->view(
                $tasks,
                Response::HTTP_OK
            )
        );
    }

    /**
     * @Route("/tasks", methods="POST")
     */
    public function postAction(Request $request)
    {
        $params = $request->request->all();

        $project = $this->projectRepository->find($params['projectId']);
        $params['project'] = $project;

        $task = $this->taskRepository->create($params);

        return $this->handleView(
            $this->view(
                $task,
                Response::HTTP_CREATED
            )
        );
    }

    /**
     * @Route("/tasks/{id}", methods="PUT")
     */
    public function putAction(Request $request, int $id)
    {
        $params = $request->request->all();
        $task = $this->taskRepository->update($id, $params);

        return $this->handleView(
            $this->view(
                $task,
                Response::HTTP_OK
            )
        );
    }


    /**
     * @Route("/tasks/{id}", methods="DELETE")
     */
    public function deleteAction(int $id)
    {
        $this->taskRepository->delete($id);

        return $this->handleView(
            $this->view(
                null,
                Response::HTTP_NO_CONTENT
            )
        );
    }
}
