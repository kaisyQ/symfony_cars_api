<?php

namespace App\Controller;

use App\Model\AuthResponse;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
#[Route(path: '/api/v1/auth')]
class AuthController extends AbstractController
{

    private AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    #[Route(path: '/login', name: 'api_v1_auth_login', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Return logged in user',
        content: new OA\JsonContent(
            ref: new Model(type: AuthResponse::class)
        )
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'email', type: 'string'),
                new OA\Property(property: 'password', type: 'string')
            ],
            type: 'object'
        )
    )]
    public function login(): Response
    {

        return $this->json($this->authService->login());

    }

    #[Route('/logout', name: 'api_v1_auth_logout', methods: ['DELETE'])]
    public function logout(): Response
    {
        $this->authService->logout();

        return $this->json([], Response::HTTP_OK);

    }
    #[Route(path: '/check', name: 'api_v1_auth_check', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return created car',
        content: new OA\JsonContent(
            ref: new Model(type: AuthResponse::class)
        )
    )]
    public function check(): Response
    {

        return $this->json($this->authService->checkMe());

    }
}