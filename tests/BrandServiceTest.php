<?php

use PHPUnit\Framework\TestCase;
use App\Repository\BrandRepository;
use App\Entity\Brand;
use App\Service\BrandService;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\BrandListResponse;
use App\Model\BrandListItem;
class BrandServiceTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetBrands () : void
    {
        $brandRepository = $this->createMock(BrandRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);

        $brandRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([
                (new Brand())
                    ->setId(1)
                    ->setName('Toyota')
                    ->setSlug('Toyota')
                    ->setWheelPosition('Левый руль'),
                (new Brand())
                    ->setId(2)
                    ->setName('Toyota')
                    ->setSlug('Toyota')
                    ->setWheelPosition('Правый руль'),
                (new Brand())
                    ->setId(3)
                    ->setName('Nissan')
                    ->setSlug('Nissan')
                    ->setWheelPosition('Правый руль'),
                (new Brand())
                    ->setId(4)
                    ->setName('Nissan')
                    ->setSlug('Nissan')
                    ->setWheelPosition('Левый руль'),

            ]);

        $service = new BrandService($brandRepository, $em);

        $expected = new BrandListResponse(
            [
                new BrandListItem(1, 'Toyota', 'Левый руль','Toyota'),
                new BrandListItem(2, 'Toyota', 'Правый руль','Toyota'),
                new BrandListItem(3, 'Nissan', 'Правый руль','Nissan'),
                new BrandListItem(4, 'Nissan', 'Левый руль','Nissan'),
            ]
        );

        $this->assertEquals($expected, $service->getBrands());

    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetBrandNames () : void
    {
        $brandRepository = $this->createMock(BrandRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);

        $brandRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([
                (new Brand())
                    ->setId(1)
                    ->setName('Toyota')
                    ->setSlug('Toyota')
                    ->setWheelPosition('Левый руль'),
                (new Brand())
                    ->setId(2)
                    ->setName('Toyota')
                    ->setSlug('Toyota')
                    ->setWheelPosition('Правый руль'),
                (new Brand())
                    ->setId(3)
                    ->setName('Nissan')
                    ->setSlug('Nissan')
                    ->setWheelPosition('Правый руль'),
                (new Brand())
                    ->setId(4)
                    ->setName('Nissan')
                    ->setSlug('Nissan')
                    ->setWheelPosition('Левый руль'),

            ]);


        $service = new BrandService($brandRepository, $em);

        $expected = ['Toyota', 'Nissan'];

        $this->assertEquals($expected, $service->getBrandNames());
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testCreateBrand() : void
    {
        $brandRepository = $this->createMock(BrandRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);

        $service = new BrandService($brandRepository, $em);

        $expected = ['brandName' => 'Nissan'];


        $this->assertEquals($expected, $service->createBrand('Nissan'));

    }

}