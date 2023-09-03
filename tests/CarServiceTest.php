<?php

use PHPUnit\Framework\TestCase;
use App\Repository\CarRepository;
use App\Entity\Car;
use App\Entity\Brand;
use App\Service\CarService;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\CarListResponse;
use App\Model\CarListItem;
use App\Model\BrandListItem;
class CarServiceTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetCars () :void {
        $carRepository = $this->createMock(CarRepository::class);
        $brandRepository = $this->createMock(BrandRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);


        $carRepository->expects($this->once())
            ->method('findAll')
            ->willReturn(
                [
                    (new Car())
                        ->setName('Test')
                        ->setBrand(
                            (new Brand())
                                ->setName('TestBrand')
                                ->setWheelPosition('Левый руль')
                                ->setSlug('L_TestBrand')
                                ->setId(1)
                        )
                        ->setSlug('TestBrand_Test')
                        ->setId(1)
                ]
            );

        $service = new CarService($carRepository, $brandRepository, $em);

        $expected = new CarListResponse(
            [
                new CarListItem(
                    1,
                    'Test',
                    'TestBrand_Test',
                    new BrandListItem(1, 'TestBrand', 'Левый руль', 'L_TestBrand'))
            ]
        );

        $this->assertEquals($expected, $service->getCars());
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetCarById () : void {
        $carRepository = $this->createMock(CarRepository::class);
        $brandRepository = $this->createMock(BrandRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);


        $carRepository->expects($this->once())
            ->method('find')
            ->id(1)
            ->willReturn(
                (new Car())
                    ->setName('Test')
                    ->setBrand(
                        (new Brand())
                            ->setName('TestBrand')
                            ->setWheelPosition('Левый руль')
                            ->setSlug('L_TestBrand')
                            ->setId(1)
                    )
                    ->setSlug('TestBrand_Test')
                    ->setId(1)
            );

        $service = new CarService($carRepository, $brandRepository, $em);

        $expected = new CarListResponse(
            [
                new CarListItem(
                    1,
                    'Test',
                    'TestBrand_Test',
                    new BrandListItem(1, 'TestBrand', 'Левый руль', 'L_TestBrand'))
            ]
        );

        $this->assertEquals($expected, $service->getCarById(1));
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDeleteCarById () : void
    {
        $carRepository = $this->createMock(CarRepository::class);
        $brandRepository = $this->createMock(BrandRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);

        $carRepository
            ->expects($this->once())
            ->method('find')
            ->id(1)
            ->willReturn(
                (new Car())
                    ->setName('Test')
                    ->setBrand(
                        (new Brand())
                            ->setName('TestBrand')
                            ->setWheelPosition('Левый руль')
                            ->setSlug('L_TestBrand')
                            ->setId(1)
                    )
                    ->setSlug('TestBrand_Test')
                    ->setId(1)
            );

        $service = new CarService($carRepository, $brandRepository, $em);

        $expected = ['id' => 1];

        $this->assertEquals($expected, $service->deleteCarById(1));
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testCreateCar() : void
    {
        $carRepository = $this->createMock(CarRepository::class);
        $brandRepository = $this->createMock(BrandRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);


        $brandRepository
            ->expects($this->once())
            ->method('findBrandByNameAndWheelPos')
            ->with('Toyota', 'Левый руль')
            ->willReturn(
                (new Brand())
                    ->setId(2)
                    ->setSlug('Toyota')
                    ->setWheelPosition('Левый руль')
                    ->setName('Toyota')

            );

        $carRepository->method('findAll')->willReturn(
            [
                (new Car())
                    ->setId(1)
                    ->setName('FirstCar')
                    ->setSlug('FirstCar')
                    ->setBrand(
                        (new Brand())
                            ->setId(2)
                            ->setName('Toyota')
                            ->setSlug('Toyota')
                            ->setWheelPosition('Левый руль')
                    )
            ]
        );

        $brandExpected = new BrandListItem(2, 'Toyota','Левый руль','Toyota');

        $expected = new CarListResponse(
            [
                new CarListItem(2, 'Corolla', 'Corolla', $brandExpected)
            ]
        );


        $service = new CarService($carRepository, $brandRepository, $em);


        $this->assertEquals($expected, $service->createCar((object) [
            'name' => 'Corolla',
            'brandName' => 'Toyota',
            'wheelPosition' => 'Левый руль'
        ]));
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testUpdateCar() : void
    {
        $carRepository = $this->createMock(CarRepository::class);
        $brandRepository = $this->createMock(BrandRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);


        $carRepository
            ->expects($this->once())
            ->method('find')
            ->id(1)
            ->willReturn(
                (new Car())
                    ->setId(1)
                    ->setSlug('Corolla')
                    ->setName('Corolla')
                    ->setBrand(
                        (new Brand())
                            ->setId(1)
                            ->setName('Toyota')
                            ->setSlug('Toyota')
                            ->setWheelPosition('Правый руль')
                    )
            );

        $brandRepository
            ->expects($this->once())
            ->method('findBrandByNameAndWheelPos')
            ->with('Toyota', 'Левый руль')
            ->willReturn((new Brand())
                ->setId(2)
                ->setName('Toyota')
                ->setSlug('Toyota')
                ->setWheelPosition('Левый руль')
            );

        $brandExpected = new BrandListItem(2, 'Toyota','Левый руль','Toyota');

        $expected = new CarListResponse(
            [
                new CarListItem(1, 'Corolla', 'Corolla', $brandExpected)
            ]
        );

        $service = new CarService($carRepository, $brandRepository, $em);

        $this->assertEquals($expected, $service->updateCar(1, (object) [
            'name' => 'Corolla',
            'brandName' => 'Toyota',
            'wheelPosition' => 'Левый руль'
        ]));
    }
}