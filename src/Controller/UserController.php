<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/users')]
class UserController extends AbstractController
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    #[Route(path: '/', name: 'admin_users_index', methods: ['GET'])]
    public function index() : Response {
        return $this->json([]);
    }
    #[Route(path: '/{id}', name: 'admin_users_show', methods: ['GET'])]
    public function show() : Response {
        return $this->json([]);
    }
    #[Route(path: '/create', name: 'admin_users_create', methods: ['POST'])]
    public function create() : Response {
        return $this->json([]);
    }
    #[Route(path: '/update/{id}', name: 'admin_users_update', methods: ['UPDATE'])]
    public function update() : Response {
        return $this->json([]);
    }
    #[Route(path: '/delete/{id}', name: 'admin_users_delete', methods: ['DELETE'])]
    public function delete() : Response {
        return $this->json([]);
    }
}