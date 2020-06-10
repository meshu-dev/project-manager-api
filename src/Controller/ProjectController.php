<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Meshu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Repository\ProjectRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View as RestView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractFOSRestController
{
    /**
     * @var App\Repository\ProjectRepository
     */
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
     * @Route("/projects", methods="POST")
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
