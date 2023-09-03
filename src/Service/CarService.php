<?php

namespace App\Service;

use App\Entity\Car;
use App\Model\BrandListItem;
use App\Model\CarListItem;
use App\Model\CarListResponse;
use App\Model\CreateCarRequest;
use App\Model\UpdateCarRequest;
use App\Repository\BrandRepository;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Error;
class CarService
{
    private CarRepository $carRepository;
    private BrandRepository $brandRepository;
    private EntityManagerInterface $em;
    public function __construct(CarRepository $carRepository, BrandRepository $brandRepository, EntityManagerInterface $em)
    {
        $this->carRepository = $carRepository;
        $this->brandRepository = $brandRepository;
        $this->em =$em;
    }

    public function getCars(): CarListResponse {

        $cars = $this->carRepository->findAll();

        $items = array_map(
            fn (Car $car) => new CarListItem(
                $car->getId(),
                $car->getName(),
                $car->getSlug(),
                new BrandListItem(
                    $car->getBrand()->getId(),
                    $car->getBrand()->getName(),
                    $car->getBrand()->getWheelPosition(),
                    $car->getBrand()->getSlug()
                )
            ),
            $cars
        );
        return new CarListResponse($items);
    }

    public function getCarById(string $id): CarListResponse {

        $car = $this->carRepository->find($id);

        if (!$car) {
            throw new Error('THERE IS NO CAR WITH ID=' . $id, );
        }

        return new CarListResponse([
            new CarListItem(
                $car->getId(),
                $car->getName(),
                $car->getSlug(),
                new BrandListItem(
                    $car->getBrand()->getId(),
                    $car->getBrand()->getName(),
                    $car->getBrand()->getWheelPosition(),
                    $car->getBrand()->getSlug()
                )
            )
        ]);
    }

    public function deleteCarById(int $id): array {

        $car = $this->carRepository->find($id);

        if (!$car) {
            throw new Error('THERE IS NO CAR WITH ID=' . $id);
        }

        $this->em->remove($car);
        $this->em->flush();

        return ['id' => $id];
    }

    public function updateCar(int $id, $content): CarListResponse {

        $carRequest = new UpdateCarRequest($id, $content->name, $content->brandName, $content->wheelPosition);

        $car = $this->carRepository->find($id);

        $brand = $this->brandRepository->findBrandByNameAndWheelPos(
            $content->brandName, $content->wheelPosition
        );

        if (!$brand) {
            throw new Error('THERE IS NO BRAND' . $id);
        }

        if (!$car) {
            throw new Error('THERE IS NO CAR WITH ID=' . $id);
        }

        if ($car->getName() === $carRequest->getName() && $car->getBrand()->getId() === $brand->getId()) {
            throw new Error('THERE IS NOTHING TO UPDATE');
        }

        $car->setBrand($brand);
        $car->setName($carRequest->getName());

        $this->em->flush();


        return  new CarListResponse(
            [
                new CarListItem(
                    $car->getId(),
                    $car->getName(),
                    $car->getSlug(),
                    new BrandListItem(
                        $car->getBrand()->getId(),
                        $car->getBrand()->getName(),
                        $car->getBrand()->getWheelPosition(),
                        $car->getBrand()->getSlug()
                    )
                )
            ]
        );

    }
    public function createCar($content): CarListResponse
    {
        $carRequest = new CreateCarRequest($content->name, $content->brandName, $content->wheelPosition);

        $brand = $this->brandRepository->findBrandByNameAndWheelPos(
            $carRequest->getBrandName(), $carRequest->getWheelPosition()
        );

        if (!$brand) {
            throw new Error('THERE IS NO BRAND');
        }

        $car = new Car();
        $car->setBrand($brand);
        $car->setName($carRequest->getName());
        $car->setSlug($carRequest->getName());

        $this->em->persist($car);

        $this->em->flush();

        $biggestId = $this->carRepository->findAll(['id' => Criteria::DESC])[0]->getId();

        return new CarListResponse(
            [
                new CarListItem(
                    $biggestId + 1,
                    $car->getName(),
                    $car->getSlug(),
                    new BrandListItem(
                        $car->getBrand()->getId(),
                        $car->getBrand()->getName(),
                        $car->getBrand()->getWheelPosition(),
                        $car->getBrand()->getSlug()
                    )
                )
            ]
        );
    }
}