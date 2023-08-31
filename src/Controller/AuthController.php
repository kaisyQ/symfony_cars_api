<?php

namespace App\Controller;

use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1/auth')]
class AuthController extends AbstractController
{

    private AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    #[Route(path: '/login', name: 'api_v1_auth_login', methods: ['POST'])]
    public function index(): Response {
        return $this->json($this->authService->login());
    }
    #[Route('/logout', name: 'api_v1_auth_logout', methods: ['DELETE'])]
    public function logout(): Response
    {
        $this->authService->logout();
        return $this->json([], Response::HTTP_OK);
    }
    #[Route(path: '/check', name: 'api_v1_auth_check', methods: ['GET'])]
    public function check(): Response {
        return $this->json($this->authService->checkMe());
    }
}