<?php

namespace App\Controller;

use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View as RestView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Provides endpoints for users.
 */
class UserController extends AbstractFOSRestController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository User repository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get a user by a specified ID.
     *
     * @param int $id The ID of the user
     *
     * @return string The user formatted to output type
     *
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
     * Get all users.
     *
     * @return string The users formatted to output type
     *
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
     * Create a new user.
     *
     * @param Request $request Request data
     *
     * @return string The new user formatted to output type
     *
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
     * Change an existing user.
     *
     * @param Request $request Request data
     * @param int     $id      The ID of the user
     *
     * @return string The updated user formatted to output type
     *
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
     * Delete an existing user.
     *
     * @param int $id The ID of the user
     *
     * @return null No content as user is deleted
     *
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
