<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route(path: '/', name: 'admin_users_index', methods: ['GET'])]
    public function index() : Response {

        return $this->json($this->userService->getUsers());

    }
    #[Route(path: '/{email}', name: 'admin_users_show', methods: ['GET'])]
    public function show(string $email) : Response {

        return $this->json($this->userService->getUserByEmail($email));

    }
    #[Route(path: '/create', name: 'admin_users_create', methods: ['POST'])]
    public function create(Request $request) : Response {

        $content = json_decode($request->getContent());

        return $this->json($this->userService->createUser($content));

    }
    #[Route(path: '/delete/{email}', name: 'admin_users_delete', methods: ['DELETE'])]
    public function delete(string $email) : Response {

        return $this->json($this->userService->deleteUser($email));

    }
}