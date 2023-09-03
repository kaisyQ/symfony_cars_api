<?php

namespace App\Controller;

use App\Model\CarListItem;
use App\Model\CarListResponse;
use App\Model\CreateCarRequest;
use App\Model\UpdateCarRequest;
use App\Service\CarService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use OpenApi\Attributes as OA;
#[Route(path: '/api/v1/cars')]
class CarController extends AbstractController
{
    private CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }
    #[Route(path: '/index', name: 'api_v1_car_index', methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    #[OA\Response(
        response: 200,
        description: 'Return all cars',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: CarListResponse::class))
        )
    )]
    public function index(): Response
    {
        return $this->json($this->carService->getCars());
    }

    #[Route(path: '/delete/{id}', name: 'api_v1_car_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    #[IsGranted('PUBLIC_ACCESS')]
    #[OA\Response(
        response: 200,
        description: 'Return deleted car ID',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'string')
            ],
            type: 'object'
        )
    )]
    public function delete(int $id): Response {
        return $this->json($this->carService->deleteCarById($id));
    }

    #[Route(path: '/update/{id}', name: 'api_v1_car_update', methods: ['PUT'])]
    #[IsGranted('ROLE_MANAGER')]
    #[IsGranted('PUBLIC_ACCESS')]
    #[OA\Response(
        response: 200,
        description: 'Return updated car',
        content: new OA\JsonContent(
            ref: new Model(type: CarListItem::class)
        )
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: UpdateCarRequest::class)
        )
    )]
    public function update(Request $request, int $id): Response {

        $content = json_decode($request->getContent());

        return $this->json($this->carService->updateCar($id, $content));
    }

    #[Route(path: '/create', name: 'api_v1_car_create', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    #[IsGranted('PUBLIC_ACCESS')]
    #[OA\Response(
        response: 200,
        description: 'Return created car',
        content: new OA\JsonContent(
            ref: new Model(type: CarListItem::class)
        )
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: CreateCarRequest::class)
        )
    )]
    public function create(Request $request): Response {

        $content = json_decode($request->getContent());

        return $this->json($this->carService->createCar($content));
    }

    #[Route(path: '/{id}', name: 'api_v1_car_show', methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    #[OA\Response(
        response: 200,
        description: 'Return the car by ID',
        content: new OA\JsonContent(
            ref: new Model(type: CarListItem::class)
        )

    )]
    public function show(string $id): Response {
        return  $this->json($this->carService->getCarById($id));
    }
}