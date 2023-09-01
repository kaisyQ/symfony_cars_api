<?php

namespace App\Service;

use App\Entity\Brand;
use App\Model\BrandListItem;
use App\Model\BrandListResponse;
use App\Model\ShortBrandListItem;
use App\Model\ShortBrandListResponse;
use App\Repository\BrandRepository;

class BrandService
{

    private BrandRepository $brandRepository;
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getBrands () : BrandListResponse {

        $brands = $this->brandRepository->findAll();
        $items = array_map(
            fn (Brand $brand) => new BrandListItem(
                $brand->getId(), $brand->getName(), $brand->getWheelPosition(), $brand->getSlug()
            ),
            $brands
        );
        return new BrandListResponse($items);
    }

    /**
     * @return string[]|null
     */
    public function getBrandNames () : ?array {
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
}