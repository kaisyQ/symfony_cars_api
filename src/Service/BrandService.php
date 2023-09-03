<?php

namespace App\Service;

use App\Entity\Brand;
use App\Model\BrandListItem;
use App\Model\BrandListResponse;
use App\Model\ShortBrandListItem;
use App\Model\ShortBrandListResponse;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;

class BrandService
{

    private BrandRepository $brandRepository;
    private EntityManagerInterface $em;

    public function __construct(BrandRepository $brandRepository, EntityManagerInterface $em)
    {
        $this->brandRepository = $brandRepository;
        $this->em = $em;
    }

    public function getBrands(): BrandListResponse
    {

        $brands = $this->brandRepository->findAll();
        $items = array_map(
            fn(Brand $brand) => new BrandListItem(
                $brand->getId(), $brand->getName(), $brand->getWheelPosition(), $brand->getSlug()
            ),
            $brands
        );
        return new BrandListResponse($items);
    }

    /**
     * @return string[]|null
     */
    public function getBrandNames(): ?array
    {
        $brands = $this->brandRepository->findAll();

        $items = array_values(
            array_unique(
                array_map(
                    fn(Brand $brand) => $brand->getName(),
                    $brands
                )
            )
        );
        if (empty($items)) {
            return null;
        }

        return $items;
    }

    public function createBrand($name): array
    {

        $brandL = new Brand();
        $brandL->setName($name);
        $brandL->setWheelPosition('Левый руль');
        $brandL->setSlug('Left_' . $name);

        $brandR = new Brand();
        $brandR->setName($name);
        $brandR->setWheelPosition('Правый руль');
        $brandR->setSlug('Right_' . $name);


        $this->em->persist($brandL);
        $this->em->persist($brandR);

        $this->em->flush();


        return ['brandName' => $name];
    }

}