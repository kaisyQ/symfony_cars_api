<?php

namespace App\Service;

use App\Entity\Brand;
use App\Model\BrandListItem;
use App\Model\BrandListResponse;
use App\Repository\BrandRepository;

class BrandService
{

    private BrandRepository $repository;
    public function __construct(BrandRepository $brandRepository)
    {
        $this->repository = $brandRepository;
    }

    public function getBrands () : BrandListResponse {

        $brands = $this->repository->findAll();
        $items = array_map(
            fn (Brand $brand) => new BrandListItem(
                $brand->getId(), $brand->getName(), $brand->getWheelPosition(), $brand->getSlug()
            ),
            $brands
        );
        return new BrandListResponse($items);
    }
}