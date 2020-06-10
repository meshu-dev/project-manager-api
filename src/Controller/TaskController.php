<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View as RestView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Provides endpoints for tasks.
 */
class TaskController extends AbstractFOSRestController
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @param TaskRepository    $taskRepository    Task repository
     * @param ProjectRepository $projectRepository Project repository
     */
    public function __construct(
        TaskRepository $taskRepository,
        ProjectRepository $projectRepository
    ) {
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Get a task by a specified ID.
     *
     * @param int $id The ID of the task
     *
     * @return string The task formatted to output type
     *
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
     * Get all tasks.
     *
     * @return string The tasks formatted to output type
     *
     * @Route("/tasks", methods="GET")
     */
    public function getAllAction()
    {
        $view = RestView::create();

        $tasks = $this->taskRepository->findAll();
        $totalTasks = $this->taskRepository->getTotal();

        $view->setHeader('X-Total-Count', $totalTasks);
        $view->setData(
            $tasks,
            Response::HTTP_OK
        );

        return $this->handleView($view);
    }

    /**
     * Create a new task.
     *
     * @param Request $request Request data
     *
     * @return string The new task formatted to output type
     *
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
     * Change an existing task.
     *
     * @param Request $request Request data
     * @param int     $id      The ID of the task
     *
     * @return string The updated task formatted to output type
     *
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
     * Delete an existing task.
     *
     * @param int $id The ID of the task
     *
     * @return null No content as task is deleted
     *
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
