<?php

namespace App\Controller;

use App\Service\CarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    private CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    #[Route('/api/cars', name: 'api_car_index', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        return $this->json($this->carService->getCars());
    }

    #[Route(path: '/api/cars/{id}', name: 'api_car_show', methods: ['GET', 'HEAD'])]
    public function show(string $id): Response {
        return  $this->json($this->carService->getCarById($id));
    }

    #[Route(path: '/api/cars/delete/{id}', name: 'api_car_delete', methods: ['DELETE'])]
    public function delete(string $id): Response {
        return $this->json($this->carService->deleteCarById($id));
    }

    #[Route(path: '/api/cars/update/{id}', name: 'api_car_update', methods: ['PUT'])]
    public function update(Request $request, string $id): Response {

        $content = json_decode($request->getContent());

        return $this->json($this->carService->updateCar($id, $content));
    }

    #[Route(path: '/api/cars/create', name: 'api_car_create', methods: ['POST'])]
    public function create(Request $request): Response {

        $content = json_decode($request->getContent());

        return $this->json($this->carService->createCar($content));
    }
}