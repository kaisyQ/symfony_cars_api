<?php

namespace App\Controller;

use App\Model\CarListResponse;
use App\Service\CarService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use OpenApi\Attributes as OA;
class CarController extends AbstractController
{
    private CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    #[OA\Response(
        response: 200,
        description: 'Returns all cars',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: CarListResponse::class))
        )
    )]
    #[Route('/api/cars', name: 'api_car_index', methods: ['GET'])]

    #[IsGranted('PUBLIC_ACCESS')]

    public function index(): Response
    {
        return $this->json($this->carService->getCars());
    }

    #[Route(path: '/api/cars/{id}', name: 'api_car_show', methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function show(string $id): Response {
        return  $this->json($this->carService->getCarById($id));
    }

    #[Route(path: '/api/cars/delete/{id}', name: 'api_car_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(string $id): Response {
        return $this->json($this->carService->deleteCarById($id));
    }

    #[Route(path: '/api/cars/update/{id}', name: 'api_car_update', methods: ['PUT'])]
    #[IsGranted('ROLE_MANAGER')]
    public function update(Request $request, string $id): Response {

        $content = json_decode($request->getContent());

        return $this->json($this->carService->updateCar($id, $content));
    }

    #[Route(path: '/api/cars/create', name: 'api_car_create', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response {

        $content = json_decode($request->getContent());

        return $this->json($this->carService->createCar($content));
    }
}