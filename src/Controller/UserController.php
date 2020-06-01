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

use App\Repository\UserRepository;

use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View As RestView;

class UserController extends AbstractFOSRestController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/users/{id}", methods="GET")
     */
    public function getAction(int $id)
    {
        $user = $this->userRepository->find($id);

        return $this->handleView(
            $this->view(
                $user,
                Response::HTTP_OK
            )
        );
    }

    /**
     * @Route("/users", methods="GET")
     */
    public function getAllAction()
    {
        $view = RestView::create();

        $users = $this->userRepository->findAll();
        $totalUsers = $this->userRepository->getTotal();

        $view->setHeader('X-Total-Count', $totalUsers);
        $view->setData(
            $users,
            Response::HTTP_OK
        );

        return $this->handleView($view);
    }

    /**
     * @Route("/users", methods="POST")
     */
    public function postAction(Request $request)
    {
        $params = $request->request->all();

        $user = $this->userRepository->create($params);

        return $this->handleView(
            $this->view(
                $user,
                Response::HTTP_CREATED
            )
        );
    }

    /**
     * @Route("/users/{id}", methods="PUT")
     */
    public function putAction(Request $request, int $id)
    {
        $params = $request->request->all();
        $user = $this->userRepository->update($id, $params);

        return $this->handleView(
            $this->view(
                $user,
                Response::HTTP_OK
            )
        );
    }


    /**
     * @Route("/users/{id}", methods="DELETE")
     */
    public function deleteAction(int $id)
    {
        $this->userRepository->delete($id);

        return $this->handleView(
            $this->view(
                null,
                Response::HTTP_NO_CONTENT
            )
        );
    }
}
