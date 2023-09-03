<?php

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Exception\NothingToUpdateException;
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
    #[OA\Response(
        response: 500,
        description: 'Returns a message about the error that occurred',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    public function index(): Response
    {
        try {

            return $this->json($this->carService->getCars());

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    #[Route(path: '/delete/{id}', name: 'api_v1_car_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    #[IsGranted('PUBLIC_ACCESS')]
    #[OA\Response(
        response: 200,
        description: 'Return deleted car ID',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'int')
            ],
            type: 'object'
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'An error that says that server cant found something that he need',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Returns a message about the error that occurred',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    public function delete(int $id): Response {
        try {

            return $this->json($this->carService->deleteCarById($id));

        } catch (NotFoundException $exception){

            return $this->json(['message' => $exception->getMessage()], $exception->getCode());

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    #[Route(path: '/update/{id}', name: 'api_v1_car_update', methods: ['PUT'])]
    #[IsGranted('ROLE_MANAGER')]
    #[OA\Response(
        response: 200,
        description: 'Return array with only one updated car',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: CarListResponse::class))
        )
    )]
    #[OA\Response(
        response: 204,
        description: 'An error that says that there is nothing to update',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    #[OA\Response(
        response: 404,
        description: 'An error that says that server cant found something that he need',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Returns a message about the error that occurred',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: UpdateCarRequest::class)
        )
    )]
    public function update(Request $request, int $id): Response {
        try {

            $content = json_decode($request->getContent());

            return $this->json($this->carService->updateCar($id, $content), Response::HTTP_OK);

        } catch (NotFoundException|NothingToUpdateException $exception){

            return $this->json(['message' => $exception->getMessage()], $exception->getCode());

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    #[Route(path: '/create', name: 'api_v1_car_create', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    #[OA\Response(
        response: 200,
        description: 'Return array with only one created car',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: CarListResponse::class))
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'An error that says that server cant found something that he need',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Returns a message about the error that occurred',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: CreateCarRequest::class)
        )
    )]
    public function create(Request $request): Response {
        try {

            $content = json_decode($request->getContent());

            return $this->json($this->carService->createCar($content));

        } catch (NotFoundException $exception){

            return $this->json(['message' => $exception->getMessage()], $exception->getCode());

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    #[Route(path: '/{id}', name: 'api_v1_car_show', methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    #[OA\Response(
        response: 200,
        description: 'Return array with only one founded by id car',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: CarListResponse::class))
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'An error that says that server cant found something that he need',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Returns a message about the error that occurred',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    public function show(string $id): Response {
        try {

            return  $this->json($this->carService->getCarById($id));

        } catch (NotFoundException $exception){

            return $this->json(['message' => $exception->getMessage()], $exception->getCode());

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }
}